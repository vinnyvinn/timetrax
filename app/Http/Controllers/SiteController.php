<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Site;
use Mapper;

class SiteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('sites.index',[
            'sites' => Site::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
          Mapper::map(53.381128999999990000, -1.470085000000040000);

        return view ('sites.create');
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
        $site = new Site();
        $site->name = $request->name;
        $site->description = $request->description;
        $site->save();
        
        flash('you have successfully added a site');
        return redirect()->route('sites.index');
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
        $site = Site::findorFail($id);
        return view ('sites.edit')->with('site', $site);
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
        $site = Site::findorFail($id);

        $site->name = $request->name;
        $site->description = $request->description;
        $site->save();

        flash('You edited the site successfully');
        return redirect()->route('sites.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $site = Site::findorFail($id);
        $site->delete();

        flash('you have successfully deleted a site');

        return redirect()->back();
        //
    }
}
