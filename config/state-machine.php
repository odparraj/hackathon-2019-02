<?php

use App\Http\Controllers\ValidateController;

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
                    'name' => 'step2',
                    'title' => 'Step 2',
                    'question' => 'Un mensaje de texto fue enviado a tu celular con la información requerida.',
                ],
            ],

            [
                'name' => 'end',
                'metadata' => [
                    'title' => 'end',
                    'name' => 'Finalizado',
                    'question' => 'Proceso atendido por el ivr normal',
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
                    'name' => 'incomingCall_ingresarCedula',
                ],
            ],
            'step1_metodosDePago' => [
                'from' =>  ['step1'],
                'to' => 'step2',
                'metadata' => [
                    'title' => 'Consultar metodos de pago',
                    'type' => 'option',
                    'name' => 'step1_metodosDePago'
                ],
            ],
            'step1_estadoDeApp' => [
                'from' =>  ['step1'],
                'to' => 'step2',
                'metadata' => [
                    'title' => 'Consultar el estado de mi credito',
                    'type' => 'option',
                    'name' => 'step1_estadoDeApp'
                ],
            ],
            'step1_consultarPago' => [
                'from' =>  ['step1'],
                'to' => 'step2',
                'metadata' => [
                    'title' => 'Consultar Pago a la fecha',
                    'type' => 'option',
                    'name' => 'step1_consultarPago'
                ],
            ],
            'step1_codigoDeContrato' => [
                'from' =>  ['step1'],
                'to' => 'step2',
                'metadata' => [
                    'title' => 'Reenviar codigo de contrato',
                    'type' => 'option',
                    'name' => 'step1_codigoDeContrato'
                ],
            ],
            'step1_restorePin' => [
                'from' =>  ['step1'],
                'to' => 'step2',
                'metadata' => [
                    'title' => 'Recuperación de pin',
                    'type' => 'option',
                    'name' => 'step1_restorePin'
                ],
            ]
        ],

        'callbacks' => [
            'after' => [
                'step1_metodosDePago' => [
                    'on' => 'step1_metodosDePago',
                    'do' => 'App\Repositories\InformationRepository@payMethods'
                ],
                'step1_estadoDeApp' => [
                    'on' => 'step1_estadoDeApp',
                    'do' => 'App\Repositories\InformationRepository@infoAppStatus'
                ],
                'step1_consultarPago' => [
                    'on' => 'step1_consultarPago',
                    'do' => 'App\Repositories\InformationRepository@infoPayValue'
                ],
                'step1_codigoDeContrato' => [
                    'on' => 'step1_codigoDeContrato',
                    'do' => 'App\Repositories\InformationRepository@infoContracCode'
                ],
                'step1_restorePin' => [
                    'on' => 'step1_restorePin',
                    'do' => 'App\Repositories\InformationRepository@infoRestorePin'
                ]
            ]
        ]

        /* // list of all callbacks
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
            'before' => [
                incomingCall_ingresarCedula
            ],

            // will be called after applying a transition
            'after' => [],
        ], */
    ],
];
