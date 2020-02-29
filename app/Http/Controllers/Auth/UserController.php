<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\HasPermission;
use App\Http\Resources\User\User as UserResource;
use Auth;
use Illuminate\Http\Request;
use App\User;
use Hash;
use Event;
use  App\Events\SettingsEvents;

class UserController extends Controller
{
    use HasPermission;

    public function index()
    {
        $user = Auth::user();
        return new UserResource($user);
    }

    public function check_password(Request $r)
    {
        $user =  User::findOrFail($r->userId);
        $result = Hash::check($r->password, $user->password);

        if ($result) {
            return response()->json(['result' => true], 200);
        } else {
            return response()->json(['error' => 'Invalid password, Try again'], 422);
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function get_user_no()
    {
        $unique =  'EPS/' . str_pad(count(User::all()) + 1, 6, "0", STR_PAD_LEFT);
        return  response()->json($unique);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $r, $id)
    {
        $user = User::findOrFail($id);
        if ($r->accessLevel) {
            if ($r->value == 'adminAccess') {
                $user->acc_level = 2;
            } elseif ($r->value == 'employeeAccess') {
                $user->acc_level = 1;
            } elseif ($r->value == 'patientAccess') {
                $user->acc_level = 0;
            }
            $user->update();
            return new UserResource($user);
        }

        if ($r->isActive && Auth::id() !== $id) {
            if ($r->value == 'active') {
                $user->is_active = 2;
            } elseif ($r->value == 'pending') {
                $user->is_active = 1;
            } elseif ($r->value == 'blocked') {
                $user->is_active = 0;
            }

            $user->update();
            $resource =  new UserResource($user);
            // event(new SettingsEvents($resource));
            return $resource;
        }
    }
}
