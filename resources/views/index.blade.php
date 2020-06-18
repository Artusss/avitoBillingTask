@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h2>Тестовое задание для backend-стажёра в юнит Billing</h2>
                <h3>Документация по данному API</h3>
                <ul>
                    <li>
                        <font color="blue">GET</font> : <b>"/"</b> - документация по данному API.
                    </li>
                    <li>
                        <font color="blue">GET</font> : <b>"/register?nominal={nominal}&slug={slug}&callbackUrl={callbackUrl}"</b> - 
                        принимает сумму, назначение платежа и url для обратной связи 
                        и возвращает URL страницы с идентификатором платёжной сессии 
                        (/payments/card/form?sessionId={sessionId}), 
                        а также сумму, назначение платежа и url для обратной связи в формате json.
                    </li>
                    <li>
                        <font color="blue">GET</font> : <b>"/payments?dateFrom={dateFrom}&dateTo={dateTo}"</b> - 
                        принимает временной интервал 
                        и возвращает список всех платежей за данный период в фомате json.
                        Если интервал не будет указан или будет указан частично выборка также сработает.
                    </li>
                    <li>
                        <font color="blue">GET</font> : <b>"/payments/card/form?sessionId={sessionId}"</b> - 
                        по данному URL открывается форма с суммой и назначением платежа
                        а также с вводом банковской карты и кнопкой "Оплатить".
                    </li>
                    <li>
                        <font color="red">POST</font> : <b>"/payments/card/form?sessionId={sessionId}"</b> - 
                        срабатывает по нажатию на кнопку "Оплатить",
                        проверяет карту на валидность по алгоритму Луна и имитирует успешную оплату 
                        в случае корректного прохождения валидации. Иначе возвращает ошибку.
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection