<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    // get location by name
    public function index($name=null){
        if($name){
            $data = Location::where('name',$name)->first();
            if(!$data){
                $data = $this->create(null,$name);
            }
        }else {
            $data = Location::all();
        }
        return $data;
    }

    public function create($id=null, $name)
    {
        return Location::updateOrCreate(['id'=>$id], ['name'=>$name]);
    }
}
