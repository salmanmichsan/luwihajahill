<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Homebanner extends Model
{
    protected $fillable = ['image','caption','active'];
}
