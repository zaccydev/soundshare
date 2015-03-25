<?php

namespace SoundShare\CommunityBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
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
            ['/'],                        
            ['/sound/read/test.mp3'],
            //['/sound/upload'],
        );
    }

}
