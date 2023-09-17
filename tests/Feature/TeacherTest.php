<?php

namespace Tests\Feature;

use App\Http\Controllers\TeacherController;
use App\Http\Requests\TeacherRequest;
use App\Http\Requests\UserRequest;
use App\Services\TeacherService;
use App\Services\UserService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Factory;
use Mockery;
use Tests\TestCase;
use Faker\Factory as FakerFactory;

class TeacherTest extends TestCase
{
    use DatabaseTransactions;

    protected $faker;

    public function setUp(): void
    {
        parent::setUp();
        $this->faker = FakerFactory::create();
    }

    /** @test */
    public function create_a_teacher(){
        $requestData = [
            'user_name' => $this->faker->userName,
            'email' => $this->faker->safeEmail,
            'password' => 'Abc463@$!%?&4',
            'full_name' => $this->faker->name,
            'role_id' => 1,
        ];

        // Create mock instances for TeacherService and UserService
        $teacherService = Mockery::mock(TeacherService::class);
        $userService = Mockery::mock(UserService::class);

        // Set expectations for TeacherService's create method
        $teacherService->shouldReceive('create')
            ->once()
            ->with(\Mockery::type('App\Http\Requests\UserRequest'), $userService)
            ->andReturn((object) $requestData);

        // Create an instance of the UserController
        $userController = new TeacherController();

        $response = $userController->create(new UserRequest($requestData), $teacherService, $userService);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->status());
    }

    public function test_edit_teacher(){
        $teacherService = Mockery::mock(TeacherService::class);
        $userService = Mockery::mock(UserService::class);

        // Create a request data
        $requestData = [
            'user_name' => 'new_username',
            'full_name' => 'New Teacher',
            'role_id' => 2,
        ];

        // Set up expectations for the TeacherService
        $teacherService->shouldReceive('edit')
            ->once()
            ->with(1, Mockery::type(TeacherRequest::class), $userService)
            ->andReturn((object) $requestData);

        // Create an instance of TeacherController
        $teacherController = new TeacherController();

        // Call the edit method
        $response = $teacherController->edit(1, new TeacherRequest($requestData), $teacherService, $userService);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJson($response->getContent());
    }

    /** @test */
    public function test_delete_a_teacher() {
        $teacherService = Mockery::mock(TeacherService::class);

        // Set up expectations for the TeacherService
        $teacherService->shouldReceive('delete')
            ->once()
            ->with(1)
            ->andReturn(true);

        // Create an instance of TeacherController
        $teacherController = new TeacherController();

        // Call the delete method
        $response = $teacherController->delete(1, $teacherService);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(204, $response->getStatusCode());
    }
}
