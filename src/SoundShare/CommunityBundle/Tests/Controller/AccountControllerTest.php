<?php

namespace SoundShare\CommunityBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AccountControllerTest extends WebTestCase
{
    /** @dataProvider provideUrls */
    public function testPageIsSuccessful($url)
    {
        $client = self::createClient();
        $client->request('GET', $url);
        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    public function provideUrls() {
        return array(
            ['/register'],            
            //['/registered'],
            //['/account'],
            //['/account/edit'],
        );
    }
}