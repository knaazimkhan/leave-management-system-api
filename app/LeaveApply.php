<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LeaveApply extends Model
{
    protected $fillable = [
        'user_id', 'name', 'start_date','end_date','leave_type','status','description','count'
    ];
}
