<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Classes\EPayment;
use Request;

class AdminProfileFormSettingController extends AdminController
{
    public function index()
    {
        return "e-payment-profile-form-settings";
    }
}
