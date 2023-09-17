<?php

namespace App\Http\Controllers;

use App\Http\Requests\PeriodRequest;
use App\Services\PeriodService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class PeriodController extends Controller
{
    /**
     * @param PeriodRequest $request
     * @param PeriodService $periodService
     * Creates a new period
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(PeriodRequest $request, PeriodService $periodService) {
        $period = $periodService->create([
            "name" => $request['name'],
            "teacher_id" => $request['teacher_id']
        ]);

        return response()->json($period);
    }

    /**
     * @param $id
     * @param PeriodRequest $request
     * @param PeriodService $periodService
     * Updates the period
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(int $id, PeriodRequest $request, PeriodService $periodService){
        $period = $periodService->edit($id, $request);


        return response()->json($period, 200);
    }

    /**
     * @param $id
     * @param PeriodService $periodService
     * Delete the period
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(int $id, PeriodService $periodService) {
        $periodService->delete($id);

        return response()->json(Lang::get('messages.success.delete',['name' => 'period']), 204);
    }

    /**
     * @param int $id
     * @param PeriodService $periodService
     * Gets all periods by teacher id
     * @return \Illuminate\Http\JsonResponse
     */
    public function fetchAllByTeacher(int $id, PeriodService $periodService){
        $periods = $periodService->fetchAllByTeacher($id);

        return response()->json($periods, 200);
    }
}
