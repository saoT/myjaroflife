<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TodoTest extends TestCase
{
    /**
     * Tests for route 'todos.index'.
     *
     * @return void
     */
    public function testIndex()
    {
        $response = $this->get(
            route('todos.index')
        );

        $response->assertSuccessful();
    }

    /**
     * Tests for route 'todos.create'.
     *
     * @return void
     */
    public function testCreate()
    {
        $response = $this->get(
            route('todos.create')
        );

        $response->assertSuccessful();
    }

    /**
     * Tests for route 'todos.show'.
     *
     * @return void
     */
    public function testShow()
    {
        $this->assertDatabaseHas('todos', []);

        $response = $this->get(
            route('todos.show', ['todo' => 0])
        );

        $response->assertSuccessful();
    }

    /**
     * Tests for route 'todos.edit'.
     *
     * @return void
     */
    public function testEdit()
    {
        $this->assertDatabaseHas('todos', []);

        $response = $this->get(
            route('todos.edit', ['todo' => 0])
        );

        $response->assertSuccessful();
    }
}
