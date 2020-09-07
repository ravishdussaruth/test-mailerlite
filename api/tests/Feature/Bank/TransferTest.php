<?php

namespace Tests\Feature\Bank;

use Tests\TestCase;
use Laravel\Passport\Client;
use App\Models\Bank\Account;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TransferTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Installing Passport api key for testing purpose.
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate');
        $this->artisan('passport:install');
    }

    /**
     * Will test that an account can transfer money to another account.
     *
     * @return void
     */
    public function testAnAccountCanTransferMoneyToAnotherAccount()
    {
        // Given two accounts.
        $from = factory(Account::class)->states('with_client')->create([
            'balance'       => 100000,
            'limit_per_day' => 5000
        ]);

        $to = factory(Account::class)->create([
            'balance'       => 400,
            'limit_per_day' => 5000
        ]);

        // When user send request to transfer data.
        $response = $this->postJson(route('bank.transfer', $from->id), [
            'to'      => $to->id,
            'details' => 'Testing a new transaction',
            'amount'  => 4000
        ], $this->header($from));

        $response->assertSuccessful();

        $from->refresh();
        $to->refresh();

        // Then $from balance should be reduced, and to incremented.
        $this->assertEquals(96000, $from->balance);
        $this->assertEquals(4400, $to->balance);
    }

    /**
     * Will test that if an account overspend is possible.
     *
     * @return void
     */
    public function testUserCannotOverSpend()
    {
        // Given two accounts.
        $from = factory(Account::class)->states(['with_transaction', 'with_client'])->create([
            'balance'       => 100000,
            'limit_per_day' => 5000
        ]);

        $to = factory(Account::class)->create([
            'balance'       => 4500,
            'limit_per_day' => 5000
        ]);

        // When user send request to transfer data.
        $response = $this->postJson(route('bank.transfer', $from->id), [
            'to'      => $to->id,
            'details' => 'Testing a small transaction',
            'amount'  => 4000
        ], $this->header($from));

        $response->assertStatus(422);

        $from->refresh();
        $to->refresh();

        // Money has not been transferred yet.
        $this->assertEquals(100000, $from->balance);
        $this->assertEquals(4500, $to->balance);
    }

    /**
     * Will test that an account cannot send money to other account due to insufficient fund.
     *
     * @return void
     */
    public function testAccountCannotSendMoneyDueToInsufficientFund()
    {
        // Given two accounts.
        $from = factory(Account::class)->states('with_client')->create([
            'balance'       => 1500,
            'limit_per_day' => 3000
        ]);

        $to = factory(Account::class)->create([
            'balance'       => 4500,
            'limit_per_day' => 5000
        ]);

        // When user send request to transfer data.
        $response = $this->postJson(route('bank.transfer', $from->id), [
            'to'      => $to->id,
            'details' => 'Testing a small transaction',
            'amount'  => 4000
        ], $this->header($from));

        $response->assertStatus(422);

        $from->refresh();
        $to->refresh();

        // Money has not been transferred yet.
        $this->assertEquals(1500, $from->balance);
        $this->assertEquals(4500, $to->balance);
    }

    /**
     * Get connection header for account.
     *
     * @param Account $account
     *
     * @return array
     */
    protected function header(Account $account): array
    {
        $header = [
            'Content-Type'     => 'application/json',
            'Accept'           => 'application/json',
            'X-Requested-With' => 'XMLHttpRequest'
        ];

        $content = [
            'client_id'     => $account->client->id,
            'client_secret' => $account->client->secret,
            'grant_type'    => 'client_credentials'
        ];

        $response = $this->postJson(route('passport.token'), $content, $header);

        // Converting the response to json.
        $responseJson = json_decode($response->getContent());

        // Adding the Authorization into the header.
        $header['Authorization'] = $responseJson->token_type . ' ' . $responseJson->access_token;

        return $header;
    }
}
