<?php

namespace App\Http\Controllers;

use App\Contact;
use App\Http\Resources\ApplicationStaus;
use App\Http\Resources\PayMethods;
use App\Http\Resources\PayValue;
use App\Repositories\InformationRepository;
use Illuminate\Database\Schema\Builder;
use Illuminate\Http\Request;

class ValidateController extends Controller
{


    protected $informationRepository;

    public function __construct(InformationRepository $informationRepository)
    {
        $this->informationRepository = $informationRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($phone)
    {
        return Contact::whereCellphone($phone)->first()->applications()->first()->status()->get();
    }


    public function payMethods(){
        return new PayMethods(
            [
                "Efecty",
                "Baloto",
                "Exito",
                "pse"
            ]
        );
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function applicationStatus($celphone, $last = true, $opens = true)
    {
        $this->informationRepository->celphone = $celphone;
        return  new ApplicationStaus($this->informationRepository->applicationStatus($last, $opens));
    }


        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function payValue($celphone)
    {
        $this->informationRepository->celphone = $celphone;
        return  new PayValue($this->informationRepository->payValue());
    }



}
