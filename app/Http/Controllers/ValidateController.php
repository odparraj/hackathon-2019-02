<?php

namespace App\Http\Controllers;

use App\Contact;
use App\Http\Resources\ApplicationStaus;
use App\Http\Resources\Contact as AppContact;
use App\Http\Resources\PayMethods;
use App\Http\Resources\PayValue;
use App\Notifications\SMSNotification;
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
        $data = $this->informationRepository->validation($cedula, $phone) ?? [];
        return $data;
    }

    public function payMethods(){

        \Notification::route('nexmo', '573015768607')
            ->notify(new SMSNotification("Pago Baloto Convenio 45678"));
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function applicationStatus(Request $request)
    {

        InformationRepository::infoAppStatus();

    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function payValue(Request $request)
    {
        InformationRepository::infoPayValue();
    }


        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function contrctCode(Request $request)
    {
        InformationRepository::infoContracCode();
    }


          /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function restorePin(Request $request)
    {
        InformationRepository::infoRestorePin();
    }







}
