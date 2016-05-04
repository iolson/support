<?php

return [
    'exceptions' => [
        'validate' => [
            'fail'   => 'Fix errors in the form.',
            'type'   => 'Only types allowed are rules and messages.',
            'method' => 'Method is not named correctly with starting with add or remove.',
        ],
        'model'    => [
            'read' => 'Model could not be found.',
        ],
    ],
];