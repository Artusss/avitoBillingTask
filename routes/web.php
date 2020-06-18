<?php
$router->get('/', "PaymentServiceController@index");
$router->get('/register', "PaymentServiceController@register");
$router->get('/payments/card/form', "PaymentServiceController@paymentsCardForm");
$router->post('/payments/card/form', "PaymentServiceController@paymentsCardFormPay");
