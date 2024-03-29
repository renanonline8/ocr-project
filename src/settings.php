<?php
return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header

        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/../templates/',
        ],

        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],

        'upload_to_convert' => [
            'path' => __DIR__ . '/../uploads/images/to_convert'
        ],

        'download' => [
            'pathToTxt' => __DIR__ . '/../download/toTxt',
            'pathToPDF' => __DIR__ . '/../download/toPdf'
        ]
    ],
];
