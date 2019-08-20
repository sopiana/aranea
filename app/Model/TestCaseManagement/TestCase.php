<?php

namespace App\Model\TestCaseManagement;

use Illuminate\Database\Eloquent\Model;

class TestCase extends Model
{
    protected $table = 'test_cases';
    public $timestamps = false;
}
