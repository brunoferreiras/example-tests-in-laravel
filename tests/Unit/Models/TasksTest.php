<?php

namespace Tests\Unit\Models;

use App\Task;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TasksTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testFillable()
    {
        $fillable = ['title', 'description', 'user_id'];
        $this->assertEquals($fillable, (new Task())->getFillable());
    }
}
