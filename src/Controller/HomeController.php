<?php

namespace App\Controller;

use App\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
        return $this->render('header.html.twig', [
            'name' => 'Fab'
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
}
