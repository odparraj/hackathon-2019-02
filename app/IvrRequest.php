<?php

namespace App;

use Iben\Statable\Statable;
use Illuminate\Database\Eloquent\Model;
use Mpociot\Firebase\SyncsWithFirebase;

class IvrRequest extends Model
{
    use Statable, SyncsWithFirebase;

    protected function getGraph()
    {
        return 'ivrRequest'; // the SM config to use
    }
    protected $table = 'ivr_requests';

    protected $casts = [
        'metadata' => 'array'
    ];

    protected $fillable = [
        'uuid', 'state', 'user_id', 'metadata', 'phone'
    ];

    protected $hidden = ['id', 'state'];


    public function loadResponse()
    {
        $response = [];

        $possibleTransitions = $this->stateMachine()->getPossibleTransitions();
        foreach ($possibleTransitions as $transition) {
            $response['possible_transitions'][$transition] =  $this->stateMachine()->metadata('transition', $transition);
        }

        $this['possible_transitions'] = $response['possible_transitions'] ?? [];
        $this['current_state'] = $this->stateMachine()->metadata('state');
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'uuid';
    }
}
