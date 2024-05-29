<?php

// tests/Feature/AccountTest.php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Account;

class AccountTest extends TestCase
{
    use RefreshDatabase;

    public function test_deposit()
    {
        $account  = Account::factory()->create(['balance' => 1000]);
        $response = $this->post('/account/deposit', ['amount' => 500]);
        $account->refresh();
        $this->assertEquals(1500, $account->balance);
    }

    public function test_withdrawal_with_fees()
    {
        $account  = Account::factory()->create(['balance' => 2000]);
        $response = $this->post('/account/withdraw', ['amount' => 1100]);
        $account->refresh();
        $this->assertEquals(768, $account->balance);
    }

    public function test_withdrawal_limit()
    {
        $account  = Account::factory()->create(['balance' => 4000]);
        $response = $this->post('/account/withdraw', ['amount' => 3100]);
        $response->assertSessionHasErrors(['amount']);
    }

    public function test_insufficient_balance()
    {
        $account  = Account::factory()->create(['balance' => 100]);
        $response = $this->post('/account/withdraw', ['amount' => 200]);
        $response->assertSessionHasErrors(['amount']);
    }
}

