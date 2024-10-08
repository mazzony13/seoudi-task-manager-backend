<?php

namespace App\Http\Controllers\Api\v1\Task;

use App\Http\Controllers\Controller;
use App\Interfaces\TaskRepositoryInterface; // get Task repository

class DeleteController extends Controller
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
    public function __invoke($uuid)
    {
        try{
            $task  = $this->taskRepository->delete($uuid);

            if(!$task)
                return response()->json([
                    'message' => 'Task Not Found'
                ], 404);

            return response()->json([
                'message'       => 'Task deleted successfully',
            ]);

        }catch(\Exception $e){
            return response()->json([
                'message' => 'Error Occured on updating Task'
            ], 500);
        }
    }
}
