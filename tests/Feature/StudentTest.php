<?php

namespace Tests\Feature;

use App\Http\Controllers\StudentController;
use App\Http\Requests\StudentRequest;
use App\Models\Student;
use App\Models\User;
use App\Services\StudentService;
use App\Services\UserService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Mockery;
use Tests\TestCase;
use Faker\Factory as FakerFactory;

class StudentTest extends TestCase
{
    use DatabaseTransactions;

    protected $faker;

    public function setUp(): void
    {
        parent::setUp();
        $this->faker = FakerFactory::create();
    }

    public function tearDown(): void
    {
        Mockery::close();
    }

    /** @test */
    public function test_create_student(){
        $studentService = Mockery::mock(StudentService::class);
        $userService = Mockery::mock(UserService::class);

        // Request data generated with Faker
        $requestData = [
            'user' => [
                'user_name' => $this->faker->userName,
                'full_name' => $this->faker->name,
                'email' => $this->faker->email,
                'password' => $this->faker->password,
                'role_id' => 1,
            ],
            'grade' => 6,
        ];


        // Set up expectations for the StudentService
        $studentService->shouldReceive('create')
            ->once()
            ->withArgs([\Mockery::type('App\Http\Requests\StudentRequest'), $userService])
            ->andReturn((object) $requestData);

        // Create an instance of StudentController
        $studentController = new StudentController();

        // Call the create method
        $response = $studentController->create(new StudentRequest($requestData), $studentService, $userService);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function test_delete_student(){
        $studentService = Mockery::mock(StudentService::class);

        // Set up expectations for the StudentService
        $studentService->shouldReceive('delete')
            ->once()
            ->with(1)
            ->andReturn(null);

        // Create an instance of StudentController
        $studentController = new StudentController();

        // Call the delete method
        $response = $studentController->delete(1, $studentService);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(204, $response->getStatusCode());
    }

    public function test_edit_student() {
        $studentService = Mockery::mock(StudentService::class);

        $requestData = [
            'user_name' => 'new_username',
            'full_name' => 'New Student',
            'role_id' => 1,
        ];

        // Set up expectations for the StudentService
        $studentService->shouldReceive('edit')
            ->once()
            ->with(1, Mockery::type(StudentRequest::class))
            ->andReturn((object) $requestData);

        // Create an instance of StudentController
        $studentController = new StudentController();

        // Call the edit method
        $response = $studentController->edit(1, new StudentRequest($requestData), $studentService);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJson($response->getContent());
    }

    public function test_fetchAllByPeriod()
    {
        $periodId = DB::table('periods')->insertGetId([
            'name' => 'Test Period',
            'teacher_id' => 1
        ]);

        DB::table('student_periods')->insert([
            [
                'period_id' => $periodId,
                'student_id' => 1,
            ],
        ]);

        $studentService = new StudentService();

        $result = $studentService->fetchAllByPeriod($periodId);

        $this->assertNotEmpty($result);

        $this->assertEquals(1, $result[0]->student_id);
    }
}
