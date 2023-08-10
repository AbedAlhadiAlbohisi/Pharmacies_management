<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\City;
use App\Models\pharmaceutical;
use App\Models\Pharmacist;
use App\Models\User;
use Illuminate\Http\Request;

class HomeControler extends Controller
{
    //
    public function test()
    {
        $admins = Admin::count();
        $users = User::count();
        $pharmacist = Pharmacist::count();
        $pharmaceuticals = pharmaceutical::count();
        $cities = City::count();
        return response()->view('cms.dashpard', [
            'admins' => $admins,
            'users' => $users,
            'pharmacist' => $pharmacist,
            'pharmaceuticals' => $pharmaceuticals,
            'cities' => $cities,
        ]);
    }
}
