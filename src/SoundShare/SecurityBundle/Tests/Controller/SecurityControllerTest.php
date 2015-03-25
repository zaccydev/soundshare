<?php

namespace SoundShare\SecurityBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class DefaultControllerTest extends WebTestCase
{
    public function testWrongLoginResutlIntoBadCredentials() {
        $client = static::createClient();

        $crawler = $client->request('POST', '/login');
        $form = $crawler->selectButton('login[submit]')->form(array('login[login]' => '6666', 'login[password]' => '6667'));
        $client->submit($form);
        
        $this->assertEquals(
            302,
            $client->getResponse()->getStatusCode()
        );
        $crawler = $client->followRedirect();
        $this->assertTrue($crawler->filter('html .container-fluid:contains("Error during authentification ")')->count() > 0);        
    }
    
    public function testWrongCaptchaResutlIntoBadCredentials() {
        $client = static::createClient();

        $crawler = $client->request('POST', '/login');
        $form = $crawler->selectButton('login[submit]')->form(array('login[login]' => '6666', 'login[password]' => '6666', 'login[captcha]' => 'hopenotthisone'));
        $client->submit($form);
        $crawler = $client->followRedirect();
        $this->assertTrue($crawler->filter('.container-fluid:contains("Error during authentification ")')->count() > 0);        
        $this->assertTrue($crawler->filter('header:contains("Login // Register")')->count() > 0);        
    }
   
    public function testCorrectLoginSendUserToIndexPage() {
        $client = static::createClient();
        
        $crawler = $client->request('POST', '/login');
        
        $session = $client->getContainer()->get('session');
        $captcha = $session->get('gcb_captcha');
        $form = $crawler->selectButton('login[submit]')->form(array('login[login]' => '6666', 'login[password]' => '6666', 'login[captcha]' => $captcha['phrase']));
        $client->submit($form);
        
        $this->assertTrue($client->getResponse()->isRedirect());         
        $crawler = $client->followRedirect();
        
        $this->assertTrue($crawler->filter('header:contains("Disconnect")')->count() > 0);
        $this->assertRegExp("/logout$/", $crawler->filter('header .col-xs-3 a')->first()->attr('href'));
        
        $crawler = $client->request('POST', '/logout');    
    }
   
   public function testLogout() {
        $client = static::createClient();
        
        $crawler = $client->request('GET', '/login');
        $session = $client->getContainer()->get('session');
        $captcha = $session->get('gcb_captcha');
        $form = $crawler->selectButton('login[submit]')->form(array('login[login]' => '6666', 'login[password]' => '6666', 'login[captcha]' => $captcha['phrase']));
        $client->submit($form);
        
        $crawler = $client->followRedirect();
        
        $this->assertTrue($client->getContainer()->get('security.context')->isGranted('ROLE_USER'));
        $this->assertTrue($client->getContainer()->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY'));
        
        $crawler = $client->request('POST', '/logout');
        
        $crawler = $client->followRedirect();
        // Assert a specific 200 status code
        $this->assertEquals(
            Response::HTTP_OK ,
            $client->getResponse()->getStatusCode()
        );
        $this->assertFalse($client->getContainer()->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY'));
    }
}
