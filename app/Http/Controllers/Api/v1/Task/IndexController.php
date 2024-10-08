<?php

namespace App\Http\Controllers\Api\v1\Task;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\TaskResource;
use App\Interfaces\TaskRepositoryInterface; // get Task repository
use Illuminate\Http\Request;

class IndexController extends Controller
{
    //initiate Task repository
    public function __construct(TaskRepositoryInterface $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        try{
            $tasks  = $this->taskRepository->list($request->all());
            return response()->json([
                'data' => TaskResource::collection($tasks)->response()->getData(),
            ]);
        }catch(\Exception $e){
            return response()->json([
                'message' => 'Error Retrieving Tasks'
            ], 500);
        }

    }
}
