<?php

namespace App\Repositories;

use App\Interfaces\TaskRepositoryInterface;
use App\Models\Task;
use App\Events\AdminNotification;

// class where repository interface implementation added
class TaskRepository implements TaskRepositoryInterface
{
    public function list($data)
    {
        $task = Task::when($data['search'], function ($q) use($data) {
                return $q->where('title', 'Like', '%'.$data['search'].'%');
            })->when($data['assigned_to'] && auth()->user()->hasRole('super-admin'), function ($q) use($data) {
                return $q->whereHas('assignee',  function ($query) use ($data){
                    $query->where('uuid', $data['assigned_to']);
                });
            })->when($data['status'] , function ($q) use($data) {
                return $q->where('status',$data['status']);
            });

        return auth()->user()->hasRole('super-admin') ? $task->paginate($data['per_page'] ?? 10) : $task->whereHas('assignee',  function ($query) use ($data){
            $query->where('uuid', auth()->user()->uuid);
        })->paginate($data['per_page'] ?? 10);
    }

    public function get($uuid)
    {
        return Task::where('uuid',$uuid)->first() ?? null;
    }

    public function delete($uuid)
    {
        $Task = Task::where('uuid',$uuid)->first();
        if(!$Task)
            return false;

       $Task->delete();
       return true;
    }

    public function create(array $data)
    {
        $Task = Task::create($data);
        return $Task;
    }

    public function update($uuid, array $data)
    {
        $Task = Task::where('uuid',$uuid)->first();
        if(!$Task)
            return false;

        return ['is_updated'=>$Task->update($data), 'task'=>$Task];
    }

}
