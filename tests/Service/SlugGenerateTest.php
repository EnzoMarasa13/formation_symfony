<?php

namespace App\Tests\Service;

use App\Service\SlugGenerator;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Security\Core\Security;

class SlugGenerateTest extends TestCase
{
    public function testSuccessSlugify()
    {
        /* dummy */
        $security = $this->createMock(Security::class);

        // s'assurer qu'une méthode du mock est appelé
        // stub
        $security->expects($this->once())->method('getUser');

        // mock
        /*
        $security
            ->expects($this->once())
            ->method('getUser')
            ->willReturn($user)
        ;
        */

        $slugGenerator = new SlugGenerator($security);

        $string = "COUCOU toi !";
        $actual = $slugGenerator->slugify($string);
        $this->assertEquals("coucou-toi", $actual);
    }
}
