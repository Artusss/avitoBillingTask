<?php
$router->get('/payment', "PaymentServiceController@payment");
$router->get('/', "PaymentServiceController@index");
