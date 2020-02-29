<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\FileUploadTrait;
use App\Http\Resources\Patient\Patient as PatientResource;
use App\Http\Resources\Patient\PatientCollection;
// use App\Notifications\Patient\AdmittedPatient;
use App\Notifications\TestNotification;
use App\Http\Requests\Patient\PatientRequest;
use App\Patient;
// use App\Role;
use App\User;
use App\OPD;
use Auth;
use Hash;
use Carbon\Carbon;
use Illuminate\Http\Request;

// use Notification;

class PatientController extends Controller
{
    use FileUploadTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $p = Patient::whereDate('created_at', Carbon::today())->latest()->get();
        return new PatientCollection($p);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PatientRequest $request)
    {
        // uplaod image
        $r = $this->savebase64($request);
        // save to db
        $patient = $this->savePatient($r);
        // $user = Auth::user();
        // $user->notify(new TestNotification($patient));
        // find accountant
        // $users = Role::find(4)->users;
        // if (count($users) > 0) {
        //     // send notification to cashiers
        //     Notification::send($users, new TestNotification($patient));
        // }

        return new PatientResource($patient);
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
        $p = Patient::findOrFail($id);
        $p->delete();

        // return new PatientResource($p);
        return response()->json($p);
    }

    /**
     * Delete all selected Patient at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $r)
    {
        if (count($r->all()) > 0) {
            $patients = Patient::whereIn('id', $r->all())->get();

            foreach ($patients as $p) {
                $p->delete();
            }

            return new PatientCollection($patients);
        }
    }

    // save patients to db
    public function savePatient($r)
    {
        if ($r) {
            // insert to patient
            $ptno = count(Patient::all());
            $auth_staff = Auth::user()->staff;

            $p = new Patient();
            $p->uniq_id = str_pad($ptno + 1, 6, "0", STR_PAD_LEFT);
            $p->adm_date = Carbon::now()->format('d/m/Y g:i:s a');
            $p->othernames = ucwords($r->othernames);
            $p->surname = ucwords($r->surname);
            $p->phone = $r->phone;
            $p->telephone = $r->telephone;
            $p->occupation = $r->occupation;
            $p->dob = $r->days . "/" . $r->month . "/" . $r->years;
            $p->month = $r->month;
            $p->age =   Carbon::now()->year - $r->years;
            $p->sex = $r->sex;
            $p->email = strtolower($r->email);
            $p->avatar = $r->avatar;
            $p->id_no = $r->idNo;
            $p->id_type = $r->idType;
            $p->town_id = $r->town;
            $p->nationality = $r->nationality;
            $p->residence = ucwords($r->residence);
            $p->street_road = $r->streetRoad;
            $p->postal_address = $r->postalAddress;
            $p->emerg_relationship = ucfirst($r->emergRelation);
            $p->emerg_name = ucfirst($r->emergName);
            $p->emerg_contacts = $r->emergContacts;
            $p->reg_by = $auth_staff->id;
            $p->save();

            if ($p) {
                //insert to opd
                $opdno = count(OPD::all());
                $opd = new OPD();
                $opd->patient_id = $p->id;
                $opd->refference_no = $r->refNo;
                $opd->opd_no = str_pad($opdno + 1, 4, "0", STR_PAD_LEFT);
                $opd->appointment_date = Carbon::now()->format('d/m/Y g:i:s a');
                $opd->save();
            }

            return $p;
        }
    }
}
