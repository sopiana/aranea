<?php

namespace App\Model\ReleaseManagement;

use Illuminate\Database\Eloquent\Model;

class ReleaseBuild extends Model
{
    protected $table = 'release_builds';
    public $timestamps = false;
}
