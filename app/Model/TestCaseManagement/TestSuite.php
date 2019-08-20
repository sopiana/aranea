<?php

namespace App\Model\TestCaseManagement;

use Illuminate\Database\Eloquent\Model;

class TestSuite extends Model
{
    protected $table = 'test_suites';
    public $timestamps = false;
}
