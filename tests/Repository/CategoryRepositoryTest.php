<?php

namespace App\Tests\Repository;

use App\Entity\Category;
use App\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CategoryRepositoryTest extends KernelTestCase
{
    private $em;
    protected function setUp()
    {
        parent::setUp();
        $kernel = self::bootKernel();
        $this->em = $kernel->getContainer()->get('doctrine')->getManager();
    }

    public function testCount()
    {
        $categories = $this->em->getRepository(Category::class)->findAll();

        $this->assertEquals(10, count($categories));
    }

    protected function tearDown():void
    {
        parent::tearDown();

        $this->em->close();
        $this->em = null;
    }


}
