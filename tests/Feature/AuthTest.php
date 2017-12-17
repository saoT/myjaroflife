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
     * Creation of objects against which we will test.
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
                route('home')
            );

            $response->assertRedirect(
                route('login')
            );
        }

        // as connected user
        {
            $response = $this->actingAs(
                $this->average_joe
            )->get(
                route('home')
            );

            $response->assertSuccessful();
        }
    }

    /**
     * Tests for route 'login'.
     *
     * @return void
     */
    public function testLogin()
    {
        // as guest
        {
            $response = $this->get(
                route('login')
            );

            $response->assertSuccessful();
        }

        // as connected user
        {
            $response = $this->actingAs(
                $this->average_joe
            )->get(
                route('login')
            );

            $response->assertRedirect(
                route('home')
            );
        }
    }

    /**
     * Tests for route 'password.request'.
     *
     * @return void
     */
    public function testPasswordRequest()
    {
        // as guest
        {
            $response = $this->get(
                route('password.request')
            );

            $response->assertSuccessful();
        }

        // as connected user
        {
            $response = $this->actingAs(
                $this->average_joe
            )->get(
                route('password.request')
            );

            $response->assertRedirect(
                route('home')
            );
        }
    }

    /**
     * Tests for route 'register'.
     *
     * @return void
     */
    public function testPasswordRegister()
    {
        // as guest
        {
            $response = $this->get(
                route('register')
            );

            $response->assertSuccessful();
        }

        // as connected user
        {
            $response = $this->actingAs(
                $this->average_joe
            )->get(
                route('register')
            );

            $response->assertRedirect(
                route('home')
            );
        }
    }
}
