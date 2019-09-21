<?php

return [
    'ivrRequest' => [
        // class of your domain object
        'class' => App\IvrRequest::class,

        // name of the graph (default is "default")
        'graph' => 'ivrRequest',

        // property of your object holding the actual state (default is "state")
        'property_path' => 'state',

        'metadata' => [
            'title' => 'Graph A',
        ],

        // list of all possible states
        'states' => [
            // a state as associative array with metadata
            [
                'name' => 'incomingCall',
                'metadata' => [
                    'name' => 'incomingCall',
                    'title' => 'Incoming Call',
                    'question' => 'Cual es tu numero de cedula ?',
                ],
            ],
            
            [
                'name' => 'step1',
                'metadata' => [
                    'name' => 'step1',
                    'title' => 'Step 1',
                    'question' => 'En que podemos ayudarte ? ',
                ],
            ],

            [
                'name' => 'step2',
                'metadata' => [
                    'title' => 'step2',
                    'name' => 'Step 2',
                    'question' => 'Cual es la razon de consulta?',
                ],
            ],
        ],

        // list of all possible transitions
        'transitions' => [
            'incomingCall_ingresarCedula' => [
                'from' =>  ['incomingCall'],
                'to' => 'step1',
                'metadata' => [
                    'title' => 'Digite el numero de cédula',
                    'type' => 'input',
                    'name' => 'incomingCall_ingresarCedula'
                ],
            ],
            'step1_consultarSaldo' => [
                'from' =>  ['step1'],
                'to' => 'step2',
                'metadata' => [
                    'title' => '1. Llamar a un asesor',
                    'type' => 'option',
                    'name' => 'step1_consultarSaldo'
                ],
            ],
            'step1_llamarAsesor' => [
                'from' =>  ['step1'],
                'to' => 'step2',
                'metadata' => [
                    'title' => '2. Ir al chat',
                    'type' => 'option',
                    'name' => 'step1_llamarAsesor'
                ],
            ],
        ],

        // list of all callbacks
        'callbacks' => [
            // will be called when testing a transition
            'guard' => [
                'guard_on_submitting' => [
                    // call the callback on a specific transition
                    'on' => 'submit_changes',
                    // will call the method of this class
                    'do' => ['MyClass', 'handle'],
                    // arguments for the callback
                    'args' => ['object'],
                ],
                'guard_on_approving' => [
                    // call the callback on a specific transition
                    'on' => 'approve',
                    // will check the ability on the gate or the class policy
                    'can' => 'approve',
                ],
            ],

            // will be called before applying a transition
            'before' => [],

            // will be called after applying a transition
            'after' => [],
        ],
    ],
];
