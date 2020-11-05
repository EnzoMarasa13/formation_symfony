<?php

namespace App\Tests\Entity;

use App\Entity\Post;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;

class PostValidatorTest extends KernelTestCase
{
    public function testSuccessPost()
    {
        $kernel = self::bootKernel();
        $validator = $kernel->getContainer()->get('validator');

        $post = new Post();
        $post->setTitle("Coucou");
        $post->setDescription("Description");

        $violations = $validator->validate($post);
        $this->assertCount(0, $violations);
    }

    /**
     * @dataProvider providerErrors
     */
    public function testErrorPost($title, $description)
    {
        $kernel = self::bootKernel();
        $validator = $kernel->getContainer()->get('validator');

        $post = new Post();
        $post->setTitle($title);

        if ($description != null) {
            $post->setDescription($description);
        }

        $violations = $validator->validate($post);
        $this->assertCount(1, $violations);
    }

    public function providerErrors() {
        return [
            ["Totre", null],
            ['Ce', "FHRIUFHIHSUFHRUIFH"],
            ['Ce', "e"]
        ];
    }
}
