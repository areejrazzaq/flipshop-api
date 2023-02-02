<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Socials;
use Illuminate\Http\Request;

class SocialsController extends Controller
{
    public function index($socials)
    {
        return Socials::where('instagram',$socials['instagram'])->orWhere('facebook',$socials['facebook'])->orWhere('twitter',$socials['twitter'])->first();
    }

    public function create($id, $socials)
    {
        return Socials::updateOrCreate(['id'=>$id],$socials);
    }
    
    
}
