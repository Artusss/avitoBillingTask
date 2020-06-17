<?php
$router->get('/register', "PaymentServiceController@register");
$router->get('/', "PaymentServiceController@index");
$router->get('/payments/card/form', "PaymentServiceController@paymentsCardForm");
$router->post('/payments/card/form', "PaymentServiceController@paymentsCardFormPay");
