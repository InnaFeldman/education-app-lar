<?php

namespace App\Services;

use App\Models\Period;
use App\Models\Teacher;


class PeriodService
{

    /**
     * @param $request
     */
    public function create($request) {
        $period = Period::create($request);
        return $period;
    }

    /**
     * @param int $id
     * @param $request
     * @return mixed
     */
    public function edit(int $id, $request){
        $period = Period::findOrFail($id);
        $period->teacher_id = $request['teacher_id'];
        $period->name = $request['name'];
        $period->save();

        return $period;
    }

    /**
     * @param int $id
     * @return void
     */
    public function delete(int $id){
        $period = Period::findOrFail($id);
        $period->delete();
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function fetchAllByTeacher(int $id){
        return Period::where('teacher_id', $id)
            ->get();
    }

}
