<?php

namespace App\Http\Controllers\Api\v1\Task;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Enums\TaskStatus;

class ListStatusController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        $tasks = array();
        foreach(TaskStatus::values() as $key=>$value)
        {
           $tasks[$key]=TaskStatus::from($key)->text();
        }

        return response()->json($tasks);

    }
}
