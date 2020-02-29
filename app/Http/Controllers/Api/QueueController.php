<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Queue\QueueCollection;
use App\Queue;
use Carbon\Carbon;

class QueueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $q = Queue::whereDate('created_at', Carbon::today())->latest()->get();
        return new QueueCollection($q);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $que = new Queue();
        $que->patient_id = $request->patientId;
        $que->queue_no = $request->patientNo;
        $que->patient_name = $request->surname . ' '. $request->otherNames;
        $que->timestamp_in =  Carbon::now()->format('d/m/Y g:i:s a');
        $que->from = $request->from;
        $que->to = $request->to;
        $que->scheme = $request->scheme;
        $que->clinic = $request->clinic;
        $que->note = $request->note;
        $que->is_emergency = $request->isEmergency;
        $que->save();
       
        
        return response()->json($que);
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
}
