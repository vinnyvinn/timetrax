<?php

namespace App\Http\Controllers\ApiController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;
use App\Site;
use Mapper;
use Bodunde\GoogleGeocoder\Geocoder;

class LocationController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $sites = Site::all();

        return response()->json(['data' => ['sites' => $sites]]);
    }


    public function store(Request $request)
    {
        $data = $request->all();

        $site = Site::create($data);

        return response()->json(['data' => ['message' => 'Site added successfully!', 'site_id' => $site->id]]);


    }
    public function get_distance(Geocoder $geocoder, Request $request)
    {

          $location1 = [
                    "lat" => $request->lt,
                    "lng" => $request->ld
                  ];

                $site = Site::findorFail($request->site_id);
                 
                $location2 = [
                "lat" => $site->lt,
                "lng" => $site->ld
                         ];
                $distance = $geocoder->getDistanceBetween($location1, $location2);
                if($distance < 0.2)
                    {
                        return response()->json(['data'=>['status' => true]]);
                    }
                  
           
                  return response()->json(['data'=>['status' => false]]);
    }
}

