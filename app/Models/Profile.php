<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;
    protected $table = 'profiles';
    protected $fillable = ['user_id','socials_id','locations_id','picture','prof_status','information','mobile'];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function socials()
    {
        return $this->belongsTo('App\Models\Socials');
    }

    public function locations()
    {
        return $this->belongsTo('App\Models\Location');
    }
}
