<?php

namespace App\Http\Controllers\Api\v1\Task;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\TaskResource;
use App\Interfaces\TaskRepositoryInterface; // get task repository

class ShowController extends Controller
{

     //initiate task repository
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
    public function __invoke($uuid)
    {
        try{
            $task  = $this->taskRepository->get($uuid);

            if(!$task)
                return response()->json([
                    'message' => 'Task Not Found'
                ], 404);

            return response()->json([
                'data' =>new TaskResource($task),

            ]);

        }catch(\Exception $e){
            return response()->json([
                'message' => 'Error Retrieving task'
            ], 500);
        }
    }
}
