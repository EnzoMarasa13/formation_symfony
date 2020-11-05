<?php

namespace App\Tests\Entity;

use App\Entity\Post;
use PHPUnit\Framework\TestCase;

class PostTest extends TestCase
{
    public function testSuccessPostTitle()
    {
        $post = new Post();
        $post->setTitle("Coucou mon 1er article");

        $this->assertEquals("COUCOU MON 1ER ARTICLE", $post->getTitle());

        $post = new Post();
        $post->setTitle("Coucou peux-tu étayer ?");

        $this->assertEquals("COUCOU PEUX-TU ÉTAYER ?", $post->getTitle());
    }

    public function testErrorPostTitle()
    {
        $post = new Post();
        $post->setTitle("Titre");

        $this->assertNotEquals("Titre", $post->getTitle());
    }

    public function testConstructPost() {
        $post = new Post();

        $this->assertIsObject($post->getCreatedAt());
    }
}
