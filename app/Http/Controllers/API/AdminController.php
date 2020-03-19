<?php

namespace App\Http\Controllers\API;

use App\User;
use App\LeaveApply;
use App\LeaveBalance;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserCollection;

class AdminController extends Controller
{
    protected $user;
    /**
     * parse the token from the request
     * and authenticate the user via the token.
     */
    public function __construct()
    {
        $this->user = JWTAuth::parseToken()->authenticate();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        // return $this->user;
        $users = User::where('id', '<>', $this->user->id)->with(['balance', 'apply'])->get();
        $users = new UserCollection($users);
        return response()->json($users);
    }
    
    public function approve(Request $request)
    {
        $leave_apply = LeaveApply::find($request->id);
        if (!$leave_apply) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, approve leave with id ' . $request->id . ' cannot be found'
            ], 400);
        }
        
        $updated = $leave_apply->update(['status' => 'Approved']);

        if ($updated) {
            return response()->json(['success' => 'approved success']);
        } else {
            return response()->json(['error' => 'not approved'], 500);
        }
    }

    public function reject(Request $request)
    {
        $leave_apply = LeaveApply::find($request->id);
        
        if (!$leave_apply) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, reject leave with id ' . $request->id . ' cannot be found'
            ], 400);
        }
        $updated = $leave_apply->update(['status' => 'Rejected']);
        if ($updated) {
            $leave_balance = LeaveBalance::where([
                'user_id' => $leave_apply->user_id,
                'leave_type' => $leave_apply->leave_type
            ])
            ->first();
            if($leave_balance->used > 0)
                $leave_balance->decrement('used', $leave_apply->count);
            return response()->json(['success' => 'Rejected success']);
        } else {
            return response()->json(['error' => 'not Rejected'], 500);
        }
        
    }
}
