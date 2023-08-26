<?php

namespace App\Http\Controllers;

use App\Http\Requests\PeriodRequest;
use App\Services\PeriodService;
use Illuminate\Http\Request;

class PeriodController extends Controller
{
    /**
     * @param PeriodRequest $request
     * @param PeriodService $periodService
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(PeriodRequest $request, PeriodService $periodService) {
        $period = $periodService->create([
            "name" => $request['name'],
            "teacher_id" => $request['teacher_id']
        ]);

        return response()->json($period->fresh());
    }

    /**
     * @param $id
     * @param PeriodRequest $request
     * @param PeriodService $periodService
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(int $id, PeriodRequest $request, PeriodService $periodService){
        $period = $periodService->edit($id, $request);


        return response()->json($period->fresh(), 200);
    }

    /**
     * @param $id
     * @param PeriodService $periodService
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(int $id, PeriodService $periodService) {
        $period = $periodService->delete($id);

        return response()->json('The period has been deleted successfully', 200);
    }

    /**
     * @param int $id
     * @param PeriodService $periodService
     * @return \Illuminate\Http\JsonResponse
     */
    public function fetchAllByTeacher(int $id, PeriodService $periodService){
        $periods = $periodService->fetchAllByTeacher($id);

        return response()->json($periods->fresh(), 200);
    }
}
