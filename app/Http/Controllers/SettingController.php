<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    private $uploadPathLogo = 'image/logo/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $setting = Setting::find(1);

        return view('setting.Setting', compact('setting'));
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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       //
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(setting $setting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(setting $setting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $setting = Setting::find(1);

        $formFileName = 'logo';
        $fileFinalName = '';
        if ($request->$formFileName != '') {
            $fileFinalName =
             time().rand(1111, 9999).'.'.$request->file($formFileName)->getClientOriginalExtension();
            $path = $this->uploadPathLogo;
            $request->file($formFileName)->move($path, $fileFinalName);
        }

        if ($fileFinalName != '') {
            $setting->logo = $fileFinalName;
        }

        $setting->name = $request->name;
        $setting->location = $request->location;
        $setting->phone = $request->phone;
        $setting->email = $request->email;
        $setting->no_khartoum = $request->no_khartoum;
        $setting->no_faisal = $request->no_faisal;
        $setting->conditions = $request->conditions;
        $setting->save();
        session()->flash('Add');

        return view('setting.Setting', compact('setting'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(setting $setting)
    {
        //
    }
}