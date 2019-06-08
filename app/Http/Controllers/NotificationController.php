<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = notification()->get(null, 5);
        return view('user.notification', compact('notifications'));
    }

    public function action(Request $request)
    {
        $request->validate(['action' => 'required']);

        switch($request->input('action'))
        {
            case 'getall':
                return $this->getAll();
                break;

            case 'getnavbar':
                return response()->json([
                    'status' => 'success',
                    'result' => notification()->get(null, 4)
                ], 200);
        }
    }

    public function getAll()
    {
        return response()->json([
            'status' => 'success',
            'result' => notification()->get()
        ], 200);
    }
}
