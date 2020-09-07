<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use Laravel\Passport\Client;

class ApiTest extends TestCase
{
    /**
     * Http Header.
     *
     * @var array
     */
    protected $header = [
        'Content-Type'     => 'application/json',
        'Accept'           => 'application/json',
        'X-Requested-With' => 'XMLHttpRequest'
    ];

    /**
     * Installing Passport api key for
     * testing purpose.
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate');
        $this->artisan('passport:install');
    }

    /**
     * Test if token is retrieved.
     *
     * @return void
     */
    public function testTokenIsRetrieved()
    {
        $client = factory(Client::class)->create();

        $content = [
            'client_id'     => $client->id,
            'client_secret' => $client->secret,
            'grant_type'    => 'client_credentials'
        ];

        $response = $this->postJson(route('passport.token'), $content, $this->header);

        $response->assertJsonStructure(
            ['token_type', 'expires_in', 'access_token']
        );
    }
}
