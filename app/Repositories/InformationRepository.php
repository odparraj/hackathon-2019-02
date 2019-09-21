<?php

namespace App\Repositories;

use App\Contact;

class InformationRepository
{

    public $celphone;


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

            $query->orderBy('created_at', 'desc')->limit(1);

            $query->with(['status' => function ($query) {
                $query->whereIn('id', [2]);
            }]);
        }]);
        return $appStatus->first();
    }
}
