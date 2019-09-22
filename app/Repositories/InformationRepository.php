<?php

namespace App\Repositories;

use App\Contact;
use App\Notifications\SMSNotification;

class InformationRepository
{

    public $celphone;

    public function validation($cedula, $phone)
    {
        $result = Contact::orWhere('cedula', $cedula)->orWhere('cellphone',$phone)->first();

        return $result;
    }
/*
    public function applicationStatus($last = true, $opens = false)
    {

        $appStatus = Contact::where('cellphone', $this->celphone)->with(['applications' => function ($query) use ($last, $opens) {

            if ($last && !$opens) {
                $query->orderBy('created_at', 'desc')->limit(1);
            }

            if ($last && $opens) {
                $query->orderBy('created_at', 'desc');

                $query->with(['status' => function ($query) {
                    $query->whereIn('id', [1, 8, 10, 12, 2]);
                }]);
            }
        }]);
        return $appStatus->first();
    }


    public function payValue()
    {
        $appStatus = Contact::where('cellphone', $this->celphone)->with(['applications' => function ($query) {

            $query->where('id_status',2)->orderBy('created_at', 'desc')->limit(1);

            $query->with(['status' => function ($query) {

            }]);
        }]);
        return $appStatus->first()->applications()->first();
    }


*/

    public static function applicationStatus($cellphone,$cedula, $last = true, $opens = false)
    {

        $appStatus = Contact::where('cellphone', $cellphone)->orWhere('cedula',$cedula)->with(['applications' => function ($query) use ($last, $opens) {

            if ($last && !$opens) {
                $query->orderBy('created_at', 'desc')->limit(1);
            }

            if ($last && $opens) {
                $query->orderBy('created_at', 'desc');

                $query->with(['status' => function ($query) {
                    $query->whereIn('id', [1, 8, 10, 12, 2]);
                }]);
            }
        }]);
        return $appStatus->first();
    }

    public static function payMethods(){

        \Notification::route('nexmo', '573015768607')
            ->notify(new SMSNotification("Pago Baloto Convenio 45678"));
    }


    public static function payValue($cellphone, $cedula)
    {
        $appStatus = Contact::where('cellphone', $cellphone)->orWhere('cedula',$cedula)->with(['applications' => function ($query) {

            $query->where('id_status',2)->orderBy('created_at', 'desc')->limit(1);

            $query->with(['status' => function ($query) {

            }]);
        }]);
        return $appStatus->first()->applications()->first();
    }




    public static function infoAppStatus()
    {
        $phone = request('phone');
        $cedula = request('cedula');
        

        $data = self::applicationStatus($phone,$cedula,true, false);

        $application = $data->applications()->first();

        $status = $application->status;

        \Notification::route('nexmo', '573015768607')
        ->notify(new SMSNotification("La Solicitud con código ".$application->uid." está ".$status->name));
    }


    public static function infoPayValue()
    {
        $phone = request('phone');
        $cedula = request('cedula');

        $result = InformationRepository::payValue($phone,$cedula);
        $amount = $result->amount;
        $due_date = $result->due_date;

        \Notification::route('nexmo', '573015768607')
        ->notify(new SMSNotification("La fecha de pago es: ".$due_date." El monto a pagar es: ".$amount));
    }


    public static function infoContracCode()
    {
        $phone = request('phone');
        $cedula = request('cedula');
        $result = InformationRepository::payValue($phone,$cedula);
        $code = $result->uid;

        \Notification::route('nexmo', '573015768607')
        ->notify(new SMSNotification("Su codigo de firma de contrato: ".$code));
    }


    public static function infoRestorePin()
    {
        $phone = request('phone');
        $cedula = request('cedula');
        $result = InformationRepository::payValue($phone,$cedula);
        $code = $result->uid;

        \Notification::route('nexmo', '573015768607')
        ->notify(new SMSNotification("Un acesor le ayudara a recuperar su pin"));
    }
}
