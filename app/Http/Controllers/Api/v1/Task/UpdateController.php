<?php

namespace App\Http\Controllers\Api\v1\Task;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\TaskRequest;
use App\Interfaces\TaskRepositoryInterface; // get Task repository
use Illuminate\Http\Request;
use App\Events\AdminNotification;

class UpdateController extends Controller
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
    public function __invoke(Request $request , $uuid)
    {
        $rules  = (new TaskRequest)->rules($uuid);
        $validatedData = $request->validate($rules);

        try{

            $assigned_to = \App\Models\User::where('uuid',$request->assigned_to)->first();
            $validatedData['assigned_to']=$assigned_to->id;
            $task  = $this->taskRepository->update($uuid,$validatedData);

            if(!$task['is_updated'])
                return response()->json([
                    'message' => 'Task Not Found'
                ], 404);


            if(auth()->user()->hasRole('user'))
            {
              broadcast(new AdminNotification($task['task']['title'] , \App\Enums\TaskStatus::from($task['task']['status'])->text() , auth()->user()->name));
            }
            return response()->json([
                'message' => 'Task Updated successfully',
            ]);

        }catch(\Exception $e){
            return $e;
            return response()->json([
                'message' => 'Error Occured on updating Task'
            ], 500);
        }
    }
}
