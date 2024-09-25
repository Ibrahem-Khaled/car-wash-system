<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NotificationModel;
class homeController extends Controller
{
    public function notification()
    {
        $notification = NotificationModel::all();
        return response()->json($notification, 200);
    }
}
