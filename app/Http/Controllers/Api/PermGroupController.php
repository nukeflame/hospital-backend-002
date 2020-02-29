<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\PermCategory;
use App\PermGroup;
use App\Role;
use App\Http\Resources\Perm\PermissionCollection as PermCollection;
use Auth;
use App\Client;

class PermGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $perm = PermGroup::all();
        return new PermCollection($perm);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $modules = Client::find($id)->modules;
        $mods = ['general'];//default module 'general'

        foreach ($modules as $module) {
            array_push($mods, $module->slug);
        }
        
        $perm_group = PermGroup::whereIn('slug', $mods)->with('categories')->get();
        return new PermCollection($perm_group);
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
        $role = Role::findOrFail($id);
        $cat = PermCategory::findOrFail($r->catId);
        // $user_id = Auth::id();
        $checked = $r->checked;
        // $check_status = ['can_view' => $checked,'role_id' => $role->id,'perm_category_id' => $cat->id,'hosp_branch_id' => $r->hospBranchId];

        // } else {
        //     $role->permissions()->detach($cat->id, ['hosp_branch_id' => $r->hospBranchId, 'can_view' => $checked]);
        // }

        if ($r->value === 'canView') {
            if ($checked) {
                $role->permissions()->attach($cat->id, ['hosp_branch_id' => $r->hospBranchId, 'can_view' => $checked]);
            } else {
                $role->permissions()->detach($cat->id, ['hosp_branch_id' => $r->hospBranchId, 'can_view' => $checked]);
            }
        }
        if ($r->value === 'canCreate') {
            if ($checked) {
                $role->permissions()->attach($cat->id, ['hosp_branch_id' => $r->hospBranchId, 'can_create' => $checked]);
            } else {
                $role->permissions()->detach($cat->id, ['hosp_branch_id' => $r->hospBranchId, 'can_create' => $checked]);
            }
        }
        if ($r->value === 'canEdit') {
            if ($checked) {
                $role->permissions()->attach($cat->id, ['hosp_branch_id' => $r->hospBranchId, 'can_edit' => $checked]);
            } else {
                $role->permissions()->detach($cat->id, ['hosp_branch_id' => $r->hospBranchId, 'can_edit' => $checked]);
            }
        }
        if ($r->value === 'canDelete') {
            if ($checked) {
                $role->permissions()->attach($cat->id, ['hosp_branch_id' => $r->hospBranchId, 'can_delete' => $checked]);
            } else {
                $role->permissions()->detach($cat->id, ['hosp_branch_id' => $r->hospBranchId, 'can_delete' => $checked]);
            }
        }



        return response()->json($r->all());

        
        
        // elseif ($r->value === 'enableCreate') {
        //     $cat->enable_add = $checked;
        //     if ($checked) {
        //         $role->permissions()->attach($cat->id);
        //     } else {
        //         $role->permissions()->detach($cat->id);
        //     }
        // } elseif ($r->value === 'enableEdit') {
        //     $cat->enable_edit = $checked;
        //     if ($checked) {
        //         $role->permissions()->attach($cat->id);
        //     } else {
        //         $role->permissions()->detach($cat->id);
        //     }
        // } elseif ($r->value === 'enableDelete') {
        //     $cat->enable_delete = $checked;
        //     if ($checked) {
        //         $role->permissions()->attach($cat->id);
        //     } else {
        //         $role->permissions()->detach($cat->id);
        //     }
        // }
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
}
