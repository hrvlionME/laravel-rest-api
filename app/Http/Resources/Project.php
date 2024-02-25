<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Task as TaskResource;

class Project extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'image' => $this->image_path,
            'tasks' => TaskResource::collection($this->tasks),
            'tasks_count' => $this->when(!is_null($this->tasks_count), $this->tasks_count),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    public function with($request){
        return [
            'status' => 'OK'
        ];
    }
}
