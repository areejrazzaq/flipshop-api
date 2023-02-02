<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Socials extends Model
{
    use HasFactory;
    protected $table = 'socials';
    protected $fillable = ['instagram','facebook','twitter'];

    public function profile()
    {
        return $this->hasOne('App\Models\Profile');
    }
}
