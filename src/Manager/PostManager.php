<?php


namespace App\Manager;


use App\Entity\Post;
use App\Service\SlugGenerator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class PostManager
{
    private $em;
    private $slugGen;

    public function __construct(EntityManagerInterface $em,
                                SluggerInterface $slugGen)
    {
        $this->em = $em;
        $this->slugGen = $slugGen;
    }

    public function persist(Post $post) {
        $this->slugify($post);
        // $this->sendMailToAdmin();
        $this->em->persist($post);
        $this->em->flush();

        return true;
    }

    public function slugify(Post $post) {
        $slug = $this->slugGen->slug($post->getTitle());
        $post->setSlug($slug);
    }
}