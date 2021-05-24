<?php

namespace M1guelpf\GhostAPI\Test;

use GuzzleHttp\Client;
use M1guelpf\GhostAPI\Ghost;
use PHPUnit\Framework\TestCase;

class GhostTest extends TestCase
{
    /** @var Ghost */
    protected Ghost $ghost;

    public function setUp(): void
    {
        parent::setUp();

        $this->ghost = new Ghost('', null);
    }

    /** @test */
    public function it_does_not_have_token()
    {
        $this->assertNull($this->ghost->getAPIToken());
    }

    /** @test */
    public function you_can_set_api_token()
    {
        $this->ghost->connect('API_TOKEN');
        $this->assertEquals('API_TOKEN', $this->ghost->getAPIToken());
    }

    /** @test */
    public function you_can_get_client()
    {
        $this->assertInstanceOf(Client::class, $this->ghost->getClient());
    }

    /** @test */
    public function you_can_set_client()
    {
        $newClient = new Client(['base_uri' => 'http://foo.bar']);
        $this->assertInstanceOf(Client::class, $newClient);
        $this->assertNotEquals($this->ghost->getClient(), $newClient);
        $this->ghost->setClient($newClient);
        $this->assertEquals($newClient, $this->ghost->getClient());
    }
}
