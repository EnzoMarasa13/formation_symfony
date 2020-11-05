<?php

namespace App\Tests\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomeControllerTest extends WebTestCase
{
    /**
     * @dataProvider providerPages
     */
    public function testCriticalPages($url)
    {
        $client = static::createClient();
        $crawler = $client->request('GET', $url);

        $this->assertResponseIsSuccessful();
    }

    public function providerPages() {
        return [
            ['/home'],
            ['/create/login'],
        ];
    }

    public function testRedirectIfNotLogged() {
        $client = static::createClient();
        $crawler = $client->request('GET', "/create/new-post");

        $this->assertResponseRedirects("/create/login");
    }

    public function testRoleUserOk() {
        $client = static::createClient();

        $em = static::$container->get('doctrine')->getManager();
        $user = $em->getRepository(User::class)->find(1);

        $client->loginUser($user);

        $crawler = $client->request('GET', "/create/new-post");

        $this->assertResponseStatusCodeSame(200);
    }

    public function testErrorNewPost() {
        $client = static::createClient();

        $em = static::$container->get('doctrine')->getManager();
        $user = $em->getRepository(User::class)->find(1);

        $client->loginUser($user);

        $crawler = $client->request('GET', "/create/new-post");
        $form = $crawler->selectButton("Allez")->form([
           'post[title]' => "test"
        ]);
        $client->submit($form);

        // si ça marche :
        /*
        $this->assertResponseRedirects();
        $client->followRedirect();
        $this->assertSelectorExists(".alert.alert-success");
        */
        //si ca marche pas :
        $this->assertSelectorExists(".alert.alert-danger");
    }
}
