<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateIvrRequest;
use App\IvrRequest;
use Illuminate\Http\Request;
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
    public function store(Request $request)
    {
        $ivrRequest = IvrRequest::create([
            'uuid' => Str::uuid(),
            'state' => 'incomingCall',
            'metadata' => [],
            'phone' => $request->phone
        ]);

        $ivrRequest->loadResponse();

        //return ResponseBuilder::success($ivrRequest);
        return $ivrRequest;
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
        $transition = $request->input('next');

        try {
            $ivrRequest->apply($transition); // applies transition
            $ivrRequest->save();
        } catch (SMException $e) {

            $ivrRequest->loadResponse();

            return ResponseBuilder::errorWithMessageAndData(BaseApiCodes::EX_HTTP_EXCEPTION, $e->getMessage(), $ivrRequest, 406);
        }

        $ivrRequest->loadResponse();

        //return ResponseBuilder::success($ivrRequest);
        return $ivrRequest;
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
