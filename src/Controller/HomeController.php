<?php

namespace App\Controller;

use App\Entity\Job;
use App\Entity\Post;
use App\Event\JobEvent;
use App\Form\JobType;
use App\Form\PostType;
use App\Form\RechercheType;
use App\Form\SearchType;
use App\Manager\PostManager;
use App\Service\FileUploader;
use App\Service\SlugGenerator;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 */
class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index(): Response
    {
        $countries = [['France', 'Europe'], ['Pays de Galles', 'Europe'], ['Belgique', 'Europe']];
        $age = 16;

        $post = new Post();
        $post->setIsEnabled(true)
            ->setDescription("<p>La description 1 caca</p>")
            ->setCreatedAt(new \DateTime())
            ->setTitle("Titre de mon super article");
        $posts[] = $post;

        $post = new Post();
        $post->setIsEnabled(true)
            ->setCreatedAt(new \DateTime("2020-11-02 14:00:00"))
            ->setDescription("La description 2 \n Test")
            ->setTitle("Titre de mon super article");
        $posts[] = $post;

        $post = new Post();
        $post->setIsEnabled(true)
            ->setCreatedAt(new \DateTime("2020-11-04 11:00:00"))
            ->setDescription("La description 3")
            ->setTitle("Titre de mon super article");
        $posts[] = $post;

        return $this->render('home/index.html.twig', [
            'countries' => $countries,
            'age' => $age,
            'posts' => $posts
        ]);
    }

    public function header(): Response
    {
        $form = $this->createForm(RechercheType::class, null, [
            'method' => 'GET',
            'action' => $this->generateUrl('search')
        ]);

        return $this->render('header.html.twig', [
            'formSearch' => $form->createView()
        ]);
    }

    /**
     * @Route("/sitemap", name="sitemap")
     */
    public function sitemap(): Response
    {
        return $this->render('sitemap.xml.twig', [
        ]);
    }

    /**
     * @Route("/create/new-post", name="new_post")
     */
    public function newPost(Request $request, SlugGenerator $slugGenerator,
                            PostManager $postManager, FileUploader $fileUploader) {

        if (!$this->isGranted('ROLE_USER')) {
            throw new AccessDeniedHttpException();
        }
        // l'instance que le form doit gérer
        $post = new Post();

        //création du formulaire
        $form = $this->createForm(PostType::class, $post);

        // demander au formulaire d'aller chercher les informations soumises
        $form->handleRequest($request);

        // formulaire soumis ?
        if ($form->isSubmitted()) {
            // est-ce qu'il est valide ?
            if ($form->isValid()) {
                // récupérer l'image uploadée
                /** @var UploadedFile $image */
                $image = $form->get('image')->getData();
                if ($image) {
                    $filename = $fileUploader->upload($image);
                    $post->setImageFilename($filename);
                }

                // enregistrer en bdd
                $postManager->persist($post);

                // message : flash message en session, retiré de la session dès qu'il est affiché une fois
                $this->addFlash('success', 'Post bien enregistré !');

                // rediriger pour éviter de renvoyer une deuxième le même form
                return $this->redirectToRoute('home');
            }
            else {
                $this->addFlash('danger', 'Une erreur est survenue !');
            }
        }

        return $this->render('home/new_post.html.twig', [
            'formPost' => $form->createView()
        ]);
    }

    /**
     * @Route("/create/new-job", name="new_job")
     * @IsGranted("ROLE_ADMIN")
     */
    public function newJob(Request $request, EventDispatcherInterface $eventDispatcher) {
        // l'instance que le form doit gérer
        $job = new Job();

        //création du formulaire
        $form = $this->createForm(JobType::class, $job);

        // demander au formulaire d'aller chercher les informations soumises
        $form->handleRequest($request);


        // formulaire soumis ?
        if ($form->isSubmitted()) {
            // est-ce qu'il est valide ?
            if ($form->isValid()) {
                // enregistrer en bdd
                $em = $this->getDoctrine()->getManager();
                $em->persist($job);
                $em->flush();

                // dispatcher l'evenement de création de job

                $eventDispatcher->dispatch(new JobEvent($job), JobEvent::NAME);

                // message : flash message en session, retiré de la session dès qu'il est affiché une fois
                $this->addFlash('success', 'Job bien enregistré !');

                // rediriger pour éviter de renvoyer une deuxième le même form
                return $this->redirectToRoute('home');
            }
            else {
                $this->addFlash('danger', 'Une erreur est survenue !');
            }
        }

        return $this->render('home/new_job.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/search", name="search")
     */
    public function search(Request $request) {
        $form = $this->createForm(RechercheType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $search = $form->get('search')->getData();
            // recherche des posts et des jobs
            $posts = [];
            $jobs = [];
        }

        return $this->render('home/search.html.twig', [

        ]);
    }
}
