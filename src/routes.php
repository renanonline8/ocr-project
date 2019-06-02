<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

return function (App $app) {
    $container = $app->getContainer();

    $app->get('/testOCR/convert', 'testOCRController:convert');
    $app->get('/testOCR/langs', 'testOCRController:langAvailable');
    $app->get('/testOCR/version', 'testOCRController:version');

    $app->post('/convert', 'convertController:convert');
};
