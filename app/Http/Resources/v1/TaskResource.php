<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'uuid' => $this->uuid,
            'title' => $this->title,
            'description' => $this->description,
            'status'=>\App\Enums\TaskStatus::from($this->status)->text(),
            'status_class'=>\App\Enums\TaskStatus::from($this->status)->class(),
            'status_id'=>$this->status,
            'creator'=>new UserResource($this->creator),
            'assignee'=>new UserResource($this->assignee)
        ];
    }
}
