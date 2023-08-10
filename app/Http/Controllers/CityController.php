<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $city = city::all();
        return view('cms.city.index', ['Citys' => $city]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('cms.city.creat');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name_en' => 'required|string|min:3|max:50',
            'name_ar' => 'required|string|min:3|max:50',
            'active' => 'nullable|string|in:on',
        ]);
        $city = new City();
        $city->name_en = $request->input('name_en');
        $city->name_ar = $request->input('name_ar');
        $city->active = $request->has('active');
        $isSaved = $city->save();
        if ($isSaved) {
            session()->flash('message', __('cms.successfully registered'));
            return redirect()->back();
        } else {
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(City $city)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(City $city)
    {
        //
        return response()->view('cms.city.edit', ['city' => $city]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, City $city)
    {
        //
        $request->validate([
            'name_en' => 'required|string|min:3|max:50',
            'name_ar' => 'required|string|min:3|max:50',
            'active' => 'nullable|string|in:on'
        ]);
        $city->name_en = $request->input('name_en');
        $city->name_ar = $request->input('name_ar');
        $city->active = $request->has('active');
        $isUpdate = $city->save();
        if ($isUpdate) {
            return redirect()->route('cities.index');
        } else {
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(City $city)
    {
        //
        $delete = $city->delete();
        return redirect()->back();
    }
}
