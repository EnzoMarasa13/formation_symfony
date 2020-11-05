<?php


namespace App\Manager;


use App\Entity\Post;
use App\Service\SlugGenerator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\String\Slugger\SluggerInterface;

class PostManager
{
    private $em;
    private $slugGen;
    private $security;

    public function __construct(EntityManagerInterface $em,
                                SluggerInterface $slugGen, Security $security)
    {
        $this->em = $em;
        $this->slugGen = $slugGen;
        $this->security = $security;
    }

    public function persist(Post $post) {
        if ($post->getSlug() == null) {
            $this->slugify($post);
        }
        // $this->sendMailToAdmin();
        // est-ce que c'est pas l'admin qui créé qui le post
        if (1 == 1) {
            $post->setUser($this->security->getUser());
        }
        $this->em->persist($post);
        $this->em->flush();

        return true;
    }

    public function slugify(Post $post) {
        $slug = $this->slugGen->slug($post->getTitle());
        $post->setSlug($slug);
    }
}