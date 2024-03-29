<?php

use Slim\App;

return function (App $app) {
    $container = $app->getContainer();

    // view renderer
    $container['renderer'] = function ($c) {
        $settings = $c->get('settings')['renderer'];
        return new \Slim\Views\PhpRenderer($settings['template_path']);
    };

    // monolog
    $container['logger'] = function ($c) {
        $settings = $c->get('settings')['logger'];
        $logger = new \Monolog\Logger($settings['name']);
        $logger->pushProcessor(new \Monolog\Processor\UidProcessor());
        $logger->pushHandler(new \Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
        return $logger;
    };

    // tesseract
    $container['tesseract'] = function ($c) {
        $tesseract = new \thiagoalessio\TesseractOCR\TesseractOCR();
        return $tesseract;
    };

    //Upload
    $container['upload'] = function ($c) {
        return new Utils\Upload\Upload();
    };

    /**
     * Path to convert DIR
     */
    $container['toConvertDir'] = function ($c) {
        return $c->get('settings')['upload_to_convert']['path'];
    };

    $container['toTxtDir'] = function($c) {
        return $c->get('settings')['download']['pathToTxt'];
    };

    $container['toPDFDir'] = function($c) {
        return $c->get('settings')['download']['pathToPDF'];
    };

    // controllers
    $container['testOCRController'] = function($c) {
        return new \App\Controller\TestOCRController($c);
    };

    $container['convertController'] = function($c) {
        return new \App\Controller\ConvertController($c);
    };
};
