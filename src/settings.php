<?php
return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header
    ],

    'kafka' => [
        'brokers' => '127.0.0.1',
        'log_level' => LOG_DEBUG,
    ]
];
