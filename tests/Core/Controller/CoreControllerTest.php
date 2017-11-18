<?php

namespace Test\Core\Controller;

use Tests\WebTestCase;

class CoreControllerTest extends WebTestCase
{
    public function testHome()
    {
        $response = $this->runApp('GET', '/');
        
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertContains('Hello World!', (string) $response->getBody());
    }
}
