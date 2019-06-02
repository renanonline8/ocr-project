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

    // controllers
    $container['testOCRController'] = function($c) {
        return new \App\Controller\TestOCRController($c);
    };
};
