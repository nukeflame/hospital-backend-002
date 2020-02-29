<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\RoomStatus;
use Auth;
use App\Http\Resources\Dep\RoomStatusCollection;
use Carbon\Carbon;
use App\Http\Resources\Dep\RoomStatus as RoomStatusResource;
use App\Staff;
use App\Http\Resources\User\User as UserResource;

class RoomStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $r = RoomStatus::where('user_id', $user->id)->orderBy('sign_in_at', 'desc')->get();
        return new RoomStatusCollection($r);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $room = new RoomStatus();
        $room->user_id = Auth::id();
        $room->room_id = $request->roomId;
        $room->status_id = $request->statusId;
        if ($request->has('signOut')) {
            $room->sign_out_at = Carbon::now();
        } else {
            $room->sign_in_at = Carbon::now();
        }
        $room->save();

        return response()->json($room);
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $staff = Staff::where('user_id', $request->userId)->first();

        if ($request->branchId > 0) {
            $room = RoomStatus::findOrFail($id);
            $room->user_id = $request->userId;
            $room->branch_id = $request->branchId;
            $room->room_id =  $request->roomId;
            $room->status_id = 2;//available
            $room->sign_in_at = Carbon::now();
            $room->update();
            $staff->main_branch = 0;//false
            $staff->update();
        } else {
            $staff->main_branch = 1;//true
            $staff->update();
            $room = RoomStatus::where('user_id', $request->userId)->first();
        }

        $user = new UserResource($staff->user);
        $room = new RoomStatusResource($room);
        return response()->json(['user' => $user, 'room' => $room]);
    }

    /**
      * Display a listing of the resource.
      *
      * @return \Illuminate\Http\Response
      */
    public function login()
    {
        $auth = Auth::user();
        //set online
        $logins = $auth->logins;
        $counts = str_pad($logins + 1, 6, 0, STR_PAD_LEFT);
        $auth->logins = $counts;
        $auth->online_status = 1;//active
        $auth->update();
        // set room
        $room = new RoomStatus();
        $room->user_id = $auth->id;
        $room->branch_id = $auth->staff->branch_id;
        $room->room_id =  $auth->staff->department_id;
        $room->status_id = 2;//available
        $room->sign_in_at = Carbon::now();
        $room->save();

        return new RoomStatusResource($room);
    }

    /**
      * Display a listing of the resource.
      *
      * @return \Illuminate\Http\Response
      */
    public function logout(Request $request)
    {
        // $auth = Auth::user();
        // //set online
        // $auth->online_status = 0;//inactive
        // $auth->update();
        // // set room
        // $room = new RoomStatus();
        // $room->user_id = $auth->id;
        // $room->branch_id = $auth->staff->branch_id;
        // $room->room_id =  $auth->staff->department_id;
        // $room->status_id = 2;//available
        // $room->sign_in_at = Carbon::now();
        // $room->save();

        // $room = RoomStatus::where('user_id', $auth->id)->orderBy('sign_in_at', 'desc')->first();
        //     $room->sign_out_at =  Carbon::now();
        //     $room->update();
        //     $token = $auth->token();
        //     $token->revoke();
  
        return response()->json($request->all());
        // return new RoomStatusCollection($r);
    }
}
