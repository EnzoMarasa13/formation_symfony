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
        $name = "fab";
        $countries = [['France', 'Europe'], ['Pays de Galles', 'Europe'], ['Belgique', 'Europe']];
        $age = 16;
        $post = new Post();
        $post->setIsEnabled(true)
            ->setDescription("La description")
            ->setTitle("Titre de mon super article");

        return $this->render('home/index.html.twig', [
            'name' => $name,
            'countries' => $countries,
            'age' => $age,
            'post' => $post
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
