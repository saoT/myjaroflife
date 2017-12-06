<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
{
    /**
     * Instance of App\User : will be used as a fake connected user.
     */
    protected $average_joe;

    /**
     * Creation of objects to help the tests.
     *
     * @return void
     */
    protected function setUp()
    {
        parent::setUp();

        $this->average_joe = new User;
    }

    /**
     * Tests for route 'home'.
     *
     * @return void
     */
    public function testHome()
    {
        // as guest
        {
            $response = $this->get(
                'home'
            );

            $response->assertRedirect('login');
        }

        // as connected user
        {
            $response = $this->actingAs(
                $this->average_joe
            )->get(
                'home'
            );

            $response->assertStatus(200);
        }
    }
}
