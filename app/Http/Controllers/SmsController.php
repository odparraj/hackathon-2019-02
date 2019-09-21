<?php

namespace App\Http\Controllers;

use App\Notifications\SMSNotification;

class SmsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        \Notification::route('nexmo', '573015768607')
            ->notify(new SMSNotification());

        return "exito";
    }

}
