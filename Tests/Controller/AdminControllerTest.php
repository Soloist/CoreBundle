<?php

namespace Soloist\Bundle\CoreBundle\Tests\Controller;

use Soloist\Bundle\CoreBundle\Tests\WebTestCase;

class AdminControllerTest extends WebTestCase
{
    public function testCreateRoot()
    {
        $client = static::createClient();

        // Go to node list and click new page
        $crawler = $client->request('GET', '/admin/soloist/page');
        $newPageLink = $crawler->filter('#soloist_page_new')->link();
        $client->click($newPageLink);



    }
}
