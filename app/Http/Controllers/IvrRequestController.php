<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateIvrRequest;
use App\Http\Requests\UpdateIvrRequest;
use App\IvrRequest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use MarcinOrlowski\ResponseBuilder\BaseApiCodes;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;
use SM\SMException;

class IvrRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateIvrRequest $request)
    {
        $ivrRequest = IvrRequest::create([
            'uuid' => Str::uuid(),
            'state' => 'incomingCall',
            'metadata' => [],
            'phone' => $request->phone
        ]);

        $ivrRequest->loadResponse();

        return ResponseBuilder::success($ivrRequest);
        //return $ivrRequest;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\IvrRequest  $ivrRequest
     * @return \Illuminate\Http\Response
     */
    public function show(IvrRequest $ivrRequest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\IvrRequest  $ivrRequest
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateIvrRequest $request, IvrRequest $ivrRequest)
    {
        $request->merge([
            'phone' => $ivrRequest->phone,
            'cedula' => Arr::get($ivrRequest->metadata, 'cedula', $request->data) 
        ]);

        $transition = $request->input('next');
        if ($transition == 'incomingCall_ingresarCedula') {
            $ivrRequest->metadata = [
                'cedula' => $request->data
            ]; 
            $ivrRequest->save();
            //dd('no paso');
            $controller = app(ValidateController::class);

            try {
                $data = $controller->identification($request);
                //dd($data);
                throw_if(empty($data), new Exception('usuario no encontrado'));

            } catch (Exception $e) {
                $ivrRequest->state = 'end';
                $ivrRequest->loadResponse();
                return ResponseBuilder::success($ivrRequest);
            }
        }

        try {
            $ivrRequest->apply($transition); // applies transition
            $ivrRequest->save();
        } catch (SMException $e) { }

        $ivrRequest->loadResponse();

        return ResponseBuilder::success($ivrRequest);
        //return $ivrRequest;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\IvrRequest  $ivrRequest
     * @return \Illuminate\Http\Response
     */
    public function destroy(IvrRequest $ivrRequest)
    {
        //
    }
}
