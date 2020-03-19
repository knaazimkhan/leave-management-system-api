<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use App\LeaveApply;
use App\LeaveBalance;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LeaveController extends Controller
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'leave_type' => 'required',
            'start_date' => 'required',
            'end_date'=> 'required',
            'description'=> 'required',
            'token'=> 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        $start_date = Carbon::parse($request->start_date);
        $end_date = Carbon::parse($request->end_date);

        $period = CarbonPeriod::create($start_date, '1 days', $end_date);
        $leave_count = 0;

        foreach ($period as $key => $date) {
            if (!$date->isSaturday() and !$date->isSunday()){
                $leave_count++;
            }
        }

        $leave_balance = LeaveBalance::where(['user_id' => $this->user->id, 'leave_type' => $request->leave_type])
            ->first();
        
        $user = new UserResource($this->user);

        if ($leave_balance->leave_type == $request->leave_type and $leave_count <= $leave_balance->left) {
            $leave_apply = $this->create($request,$start_date,$end_date,$leave_count);
            if($leave_balance){
                $leave_balance->increment('used', $leave_count);
                return response()->json([
                    'success' => 'leave applied sucessfully',
                    'user' => $user
                ]);
            }
        } else {
            return response()->json([
                'error' => 'dont have enough leave to apply',
                'user' => $user
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function create($request,$start_date,$end_date, $leave_count)
    {
        return LeaveApply::create([
            'user_id' => $this->user->id,
            'name' => $this->user->name,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'leave_type' => $request->leave_type,
            'status' => 'Pending',
            'description' => $request->description,
            'count' =>  $leave_count,
        
        ]);
    }
}
