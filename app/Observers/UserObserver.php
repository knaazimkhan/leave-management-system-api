<?php

namespace App\Observers;

use App\User;
use Carbon\Carbon;
use App\LeaveBalance;

class UserObserver
{
    /**
     * Handle the user "created" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function created(User $user)
    {
        $data = [
            [
                'user_id' => $user->id,
                'leave_type' => 'AL',
                'used' => 0,
                'total' => Carbon::now()->day > 15 ? 1 : 2,
            ],
            [
                'user_id' => $user->id,
                'leave_type' => 'CL',
                'used' => 0,
                'total' => 7,
            ],
            [
                'user_id' => $user->id,
                'leave_type' => 'SL',
                'used' => 0,
                'total' => 7,
            ],
        ];

        // LeaveBalance::truncate();
        
        foreach ($data as $value) {
            LeaveBalance::create($value);
        }
    }

    /**
     * Handle the user "updated" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function updated(User $user)
    {
        //
    }

    /**
     * Handle the user "deleted" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function deleted(User $user)
    {
        //
    }

    /**
     * Handle the user "restored" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function restored(User $user)
    {
        //
    }

    /**
     * Handle the user "force deleted" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function forceDeleted(User $user)
    {
        //
    }
}
