<?php

namespace Tests\Feature;

use App\Todo;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TodoTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Instance of App\Todo : will be used as a fake content in the database.
     */
    protected $something_todo;

    /**
     * Creation of objects against which we will test.
     *
     * @return void
     */
    protected function setUp()
    {
        parent::setUp();

        $this->something_todo = factory(Todo::class)->create();
    }

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
        $this->assertDatabaseHas('todos', [
            'id' => $this->something_todo->id
        ]);

        $response = $this->get(
            route('todos.show', [
                'todo' => $this->something_todo->id
            ])
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
        $this->assertDatabaseHas('todos', [
            'id' => $this->something_todo->id
        ]);

        $response = $this->get(
            route('todos.edit', [
                'todo' => $this->something_todo->id
            ])
        );

        $response->assertSuccessful();
    }
}
