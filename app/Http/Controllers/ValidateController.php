<?php

namespace App\Http\Controllers;

use App\Contact;
use App\Http\Resources\ApplicationStaus;
use App\Http\Resources\Contact as AppContact;
use App\Http\Resources\PayMethods;
use App\Http\Resources\PayValue;
use App\Repositories\InformationRepository;
use Illuminate\Database\Schema\Builder;
use Illuminate\Http\Request;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;

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
    public function cellphone($phone)
    {
        return ResponseBuilder::success(new AppContact(Contact::whereCellphone($phone)->first()));
    }

    public function identification(Request $request)
    {
        $cedula = $request->cedula;
        $phone = $request->phone;
        return ResponseBuilder::success($this->informationRepository->validation($cedula, $phone));
    }

    public function payMethods(){
        return ResponseBuilder::success(new PayMethods(
            [
                "Efecty",
                "Baloto",
                "Exito",
                "pse"
            ]
        ));
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function applicationStatus($celphone, $last = true, $opens = true)
    {
        $this->informationRepository->celphone = $celphone;
        return  ResponseBuilder::success(new ApplicationStaus($this->informationRepository->applicationStatus($last, $opens)));
    }


        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function payValue($celphone)
    {
        $this->informationRepository->celphone = $celphone;
        return  ResponseBuilder::success(new PayValue($this->informationRepository->payValue()));
    }



}
