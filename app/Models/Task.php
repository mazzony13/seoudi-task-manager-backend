<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Dyrynda\Database\Support\GeneratesUuid;

class Task extends Model
{
    use HasFactory,GeneratesUuid;

    protected $fillable = [
        'uuid',
        'title',
        'description',
        'status',
        'created_by',
        'assigned_to'
    ];


    public function creator(){
            return $this->belongsTo( User::class, 'created_by');
    }

    public function assignee(){
        return $this->belongsTo( User::class, 'assigned_to');
    }
}
