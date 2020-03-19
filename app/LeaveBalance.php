<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LeaveBalance extends Model
{
    protected $fillable = [
        'user_id', 'leave_type', 'used','total'
    ];
    
    protected $appends = ['left'];

    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function getLeftAttribute()
    {
        return $this->attributes['left'] = $this->total - $this->used;
    }

    // public function user()
    // {
    //     return $this->belongsTo('App\User');
    // }
}
