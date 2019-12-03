<?php

namespace Tests\Feature;

use App\Task;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;

class TasksTest extends TestCase
{
    use RefreshDatabase;

    public function testAUserCanListAllTheTasks()
    {
        $task = factory('App\Task')->create();
        $response = $this->get('/tasks');

        $response->assertSee($task->title);
        $response->assertStatus(200);
        $tasks = $response->viewData('tasks');
        $this->assertEquals($tasks->toArray(), $tasks->toArray());
    }

    public function testAUserCanReadSingleTask()
    {
        $task = factory('App\Task')->create();

        $response = $this->get('/tasks/'.$task->id);

        $response->assertSee($task->title)
                ->assertSee($task->description);
    }

    /** @test */
    public function authenticated_users_can_create_a_new_task()
    {
        // Dado que temos um usuário autenticado
        $this->actingAs(factory('App\User')->create());

        // E um objeto Task
        $task = factory('App\Task')->make();

        // Quando um usuário envia uma requisição POST para criar uma tarefa.
        $this->post('/tasks', $task->toArray());

        // Ele é armazenado no banco de dados
        $this->assertEquals(1, Task::all()->count());
    }

    /** @test */
    public function unauthenticated_users_cannot_create_a_new_task()
    {
        // Dado que temos um objeto Task
        $task = factory('App\Task')->make();

        $this->post('/tasks', $task->toArray())
             ->assertRedirect('/login');
    }

    /** @test */
    public function a_task_requires_a_title()
    {
        $this->actingAs(factory('App\User')->create());

        $task = factory('App\Task')->make(['title' => null]);

        $this->post('/tasks', $task->toArray())
            ->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_task_requires_a_description()
    {
        $this->actingAs(factory('App\User')->create());

        $task = factory('App\Task')->make(['description' => null]);

        $this->post('/tasks', $task->toArray())
            ->assertSessionHasErrors('description');
    }

    /** @test */
    public function authorized_user_can_update_the_task()
    {
        // Dado que temos um usuário logado
        $this->actingAs(factory('App\User')->create());

        // E temos uma tarefa criada pelo usuário
        $task = factory('App\Task')->create(['user_id' => Auth::id()]);
        $task->title = "Updated Title";

        $this->put('/tasks/'.$task->id, $task->toArray());
        // A tarefa deve está atualizada no banco
        $this->assertDatabaseHas('tasks', ['id' => $task->id, 'title' => 'Updated Title']);
    }

    /** @test */
    public function unauthorized_user_cannot_update_the_task()
    {
        // Dado que temos um usuário logado
        $this->actingAs(factory('App\User')->create());

        // E a tarefa em questão não foi criada pelo usuário
        $task = factory('App\Task')->create();
        $task->title = "Updated Title";
        
        // Quando o usuário manda a requisição de atualização
        $response = $this->put('/tasks/'.$task->id, $task->toArray());

        // Deve informar status 403
        $response->assertStatus(403);
    }

    /** @test */
    public function authorized_user_can_delete_the_task()
    {
        // Dado um usuário logado
        $this->actingAs(factory('App\User')->create());

        // E uma tarefa que foi criada pelo usuário
        $task = factory('App\Task')->create(['user_id' => Auth::id()]);

        // Quando o usuário tenta deletar a tarefa;
        $this->delete('/tasks/'.$task->id);

        // A tarefa deve ser removida do banco
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }

    /** @test */
    public function unauthorized_user_can_delete_the_task()
    {
        // Dado um usuário logado
        $this->actingAs(factory('App\User')->create());

        // E uma tarefa que foi criada pelo usuário
        $task = factory('App\Task')->create();

        // Quando o usuário tenta deletar a tarefa;
        $response = $this->delete('/tasks/'.$task->id);

        // O status deve retornar 403
        $response->assertStatus(403);
    }

    public function testShowFormCreateTask()
    {
        $this->actingAs(factory('App\User')->create());
        $response = $this->get('tasks/create');
        $response->assertSee('Add a new task');
    }
    
    public function testShowFormEditTask()
    {
        $this->actingAs(factory('App\User')->create());
        $task = factory('App\Task')->create();
        $response = $this->get("tasks/{$task->id}/edit");
        $response->assertSee('Edit Task');
    }
}
