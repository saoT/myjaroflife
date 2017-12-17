<?php

namespace Tests\Feature;

use App\Todo;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TodoTest extends TestCase
{
    /**
     * Instance of App\User : will be used as a fake connected user.
     */
    protected $average_joe;

    /**
     * Instance of App\User : will be used as author of a fake content.
     */
    protected $someone_who_does;

    /**
     * Instance of App\Todo : will be used as a fake content in the database.
     */
    protected $something_todo;

    /**
     * Create the objects against which we will test.
     *
     * @return void
     */
    protected function setUp()
    {
        parent::setUp();

        $this->average_joe = new User;

        $this->something_todo = factory(Todo::class)->create();

        $this->someone_who_does = $this->something_todo->user;
    }

    /**
     * Clean up the objects against which we tested.
     *
     * @return void
     */
    protected function tearDown()
    {
        parent::tearDown();

        $this->something_todo->forceDelete();
        $this->someone_who_does->forceDelete();
    }

    /**
     * Tests for route 'todos.index'.
     *
     * @return void
     */
    public function testIndex()
    {
        // as guest
        {
            $response = $this->get(
                route('todos.index')
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
                route('todos.index')
            );

            $response->assertSuccessful();
        }
    }

    /**
     * Tests for route 'todos.create'.
     *
     * @return void
     */
    public function testCreate()
    {
        // as guest
        {
            $response = $this->get(
                route('todos.create')
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
                route('todos.create')
            );

            $response->assertSuccessful();
        }
    }

    /**
     * Tests for route 'todos.store'.
     *
     * @return void
     */
    public function testStore()
    {
        // as guest
        {
            $response = $this->post(
                route('todos.store')
            );

            $response->assertRedirect(
                route('login')
            );
        }

        // as connected user
        {
            $response = $this->actingAs(
                $this->someone_who_does
            )->post(
                route('todos.store'), [
                    '_token' => csrf_token(),
                    'title' => 'foo',
                    'content' => 'bar'
                ]
            );

            $stored = Todo::orderBy('id', 'desc')->first();

            $response->assertRedirect(
                route('todos.show', [$stored])
            );

            $this->assertDatabaseHas('todos', [
                'id' => $stored->id
            ]);

            ($deleted = $stored)->forceDelete();

            $this->assertDatabaseMissing('todos', [
                'id' => $deleted->id
            ]);
        }
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

        // as guest
        {
            $response = $this->get(
                route('todos.show', [$this->something_todo])
            );

            $response->assertRedirect(
                route('login')
            );
        }

        // as average joe
        {
            $response = $this->actingAs(
                $this->average_joe
            )->get(
                route('todos.show', [$this->something_todo])
            );

            $response->assertStatus(403);
        }

        // as author
        {
            $response = $this->actingAs(
                $this->someone_who_does
            )->get(
                route('todos.show', [$this->something_todo])
            );

            $response->assertSuccessful();
        }
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

        // as guest
        {
            $response = $this->get(
                route('todos.edit', [$this->something_todo])
            );

            $response->assertRedirect(
                route('login')
            );
        }

        // as average joe
        {
            $response = $this->actingAs(
                $this->average_joe
            )->get(
                route('todos.edit', [$this->something_todo])
            );

            $response->assertStatus(403);
        }

        // as author
        {
            $response = $this->actingAs(
                $this->someone_who_does
            )->get(
                route('todos.edit', [$this->something_todo])
            );

            $response->assertSuccessful();
        }
    }

    /**
     * Tests for route 'todos.update'.
     *
     * @return void
     */
    public function testUpdate()
    {
        $this->assertDatabaseHas('todos', [
            'id' => $this->something_todo->id
        ]);

        // as guest
        {
            $response = $this->put(
                route('todos.update', [$this->something_todo])
            );

            $response->assertRedirect(
                route('login')
            );
        }

        // as average joe
        {
            $response = $this->actingAs(
                $this->average_joe
            )->put(
                route('todos.update', [$this->something_todo]), []
            );

            $response->assertStatus(403);
        }

        // as author
        {
            $new_data = [
                '_token' => csrf_token(),
                'title' => 'foo',
                'content' => 'bar'
            ];

            $response = $this->actingAs(
                $this->someone_who_does
            )->put(
                route('todos.update', [$this->something_todo]), $new_data
            );

            $response->assertRedirect(
                route('todos.show', [$this->something_todo])
            );

            $updated = Todo::where(
                'id', $this->something_todo->id
            )->first();

            $this->assertTrue(
                $updated->title == $new_data['title'] &&
                $updated->content == $new_data['content']
            );
        }
    }

    /**
     * Tests for route 'todos.destroy'.
     *
     * @return void
     */
    public function testDestroy()
    {
        $this->assertDatabaseHas('todos', [
            'id' => $this->something_todo->id
        ]);

        // as guest
        {
            $response = $this->delete(
                route('todos.destroy', [$this->something_todo])
            );

            $response->assertRedirect(
                route('login')
            );
        }

        // as average joe
        {
            $response = $this->actingAs(
                $this->average_joe
            )->delete(
                route('todos.destroy', [$this->something_todo])
            );

            $response->assertStatus(403);
        }

        // as author
        {
            $response = $this->actingAs(
                $this->someone_who_does
            )->delete(
                route('todos.destroy', [$this->something_todo])
            );

            $response->assertRedirect(
                route('todos.index')
            );

            $deleted = Todo::withTrashed()->where(
                'id', $this->something_todo->id
            )->first();

            $this->assertTrue($deleted->trashed());

            $deleted->restore();
        }
    }
}
