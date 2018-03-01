<?php

namespace App\Http\Controllers;

use App\Date;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DateController extends Controller
{
    public function __construct()
    {
        $this->middleware('dates')->only(['update', 'store']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dates = Date::getCustomDates();
        return view('dates', compact('dates'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $date = Date::create([
            'day' => $request->day,
            'month' => $request->month,
            'year' => $request->year
        ]);
        if ($date)
            return response()->json($date->id);
        else
            return response()->json('Something terrible happened!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Date $date
     * @return \Illuminate\Http\Response
     */
    public function show(Date $date)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Date $date
     * @return \Illuminate\Http\Response
     */
    public function edit(Date $date)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Date $date
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Date $date)
    {
        $dateUpdated = $date->update([
            'day' => $request->day,
            'month' => $request->month,
            'year' => $request->year
        ]);
        if ($dateUpdated)
            return response()->json(true);
        else
            return response()->json('Something terrible happened!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Date $date
     * @return \Illuminate\Http\Response
     */
    public function destroy(Date $date)
    {
        $currentUserId = Auth::user()->id;
        if ($date->id === request()->dataId && $date->user_id == $currentUserId || $currentUserId == 1) {
            $dateDeleted = $date->delete();
            if ($dateDeleted)
                return response()->json(true);
            else
                return response()->json('Something terrible happened!');
        } else {
            return response()->json(['fail' => true]);
        }
    }
}
