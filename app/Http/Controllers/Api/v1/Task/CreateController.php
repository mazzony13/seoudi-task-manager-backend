<?php

namespace App\Http\Controllers\Api\v1\Task;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\TaskRequest;
use App\Interfaces\TaskRepositoryInterface;
use App\Events\UserNotification;

class CreateController extends Controller
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
    public function __invoke(TaskRequest $request)
    {
        try{
            $data = $request->all();
            $assigned_to = \App\Models\User::where('uuid',$request->assigned_to)->first();
            $data['created_by']=auth()->user()->id;
            $data['assigned_to']=$assigned_to->id;
            $task  = $this->taskRepository->create($data);

            broadcast(new UserNotification($request->assigned_to , auth()->user()->name , $task->title));

            return response()->json([
                'message'       => 'Task Created successfully',
            ]);
        }catch(\Exception $e){
            return $e;
            return response()->json([
                'message' => 'Error Occured on creating Task'
            ], 500);
        }
    }
}
