<?php

namespace Tests\Feature;

use App\Http\Controllers\PeriodController;
use App\Http\Requests\PeriodRequest;
use App\Services\PeriodService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\JsonResponse;
use Mockery;
use Tests\TestCase;

class PeriodTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function test_create_period(){
        // Create a mock of PeriodService
        $periodService = Mockery::mock(PeriodService::class);

        // Set an expectation for the create method with argument matching
        $periodService->shouldReceive('create')
            ->once()
            ->with(Mockery::on(function ($data) {
                return isset($data['name']) && $data['name'] === 'Period Name' &&
                    isset($data['teacher_id']) && $data['teacher_id'] === 1;
            }))
            ->andReturn(['name' => 'Period Name']);

        // Create an instance of PeriodRequest with the required data
        $periodRequest = new PeriodRequest([
            'name' => 'Period Name',
            'teacher_id' => 1,
        ]);

        // Call the create method with the mocked $periodService
        $periodController = new PeriodController();
        $response = $periodController->create($periodRequest, $periodService);

        // Assertions based on the expected behavior
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(['name' => 'Period Name'], $response->getData(true));
    }

    /** @test */
    public function test_edit_period(){
        $idToUpdate = 1;
        $requestData = [
            'teacher_id' => 2,
            'name' => 'Updated Period Name',
        ];

        // Create a mock for the PeriodService
        $periodService = Mockery::mock(PeriodService::class);

        // Set expectations for the edit method on the mock PeriodService
        $periodService->shouldReceive('edit')
            ->once()
            ->with(1, \Mockery::type('App\Http\Requests\PeriodRequest'))
            ->andReturn((object) $requestData);

        $periodController = new PeriodController($periodService);

        $response = $periodController->edit($idToUpdate, new PeriodRequest($requestData), $periodService);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->status());

        $this->assertJsonStringEqualsJsonString(json_encode($requestData), $response->getContent());
    }

    /** @test */
    public function test_delete_period(){
        $idToDelete = 1;
        $expectedResponseData = '"The period has been deleted successfully"';

        // Create a mock for the PeriodService
        $periodService = Mockery::mock(PeriodService::class);

        // Set expectations for the delete method on the mock PeriodService
        $periodService->shouldReceive('delete')
            ->once()
            ->with($idToDelete);

        // Create an instance of the PeriodController
        $periodController = new PeriodController($periodService);

        // Act
        $response = $periodController->delete($idToDelete, $periodService);

        // Assert
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(204, $response->status());
        $this->assertEquals($expectedResponseData, $response->getContent());
    }

    /** @test */
    public function test_fetch_periods_by_Teacher(){
        $teacherId = 1;
        $expectedPeriods = [
            'id' => 1,
            'teacher_id' => 1,
            'name' => 'Period 1'
        ];

        // Create a mock for the PeriodService
        $periodService = Mockery::mock(PeriodService::class);

        // Set expectations for the fetchAllByTeacher method on the mock PeriodService
        $periodService->shouldReceive('fetchAllByTeacher')
            ->once()
            ->with($teacherId)
            ->andReturn($expectedPeriods);

        // Create an instance of the PeriodController
        $periodController = new PeriodController($periodService);

        $response = $periodController->fetchAllByTeacher($teacherId, $periodService);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->status());

        // Validate the response content based on the expected periods
        $this->assertJsonStringEqualsJsonString(json_encode($expectedPeriods), $response->getContent());
    }
}
