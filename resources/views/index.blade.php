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
                        <font color="blue">GET</font> : <b>"/register?nominal={nominal}&slug={slug}"</b> - 
                        принимает сумму и назначение платежа 
                        и возвращает URL страницы с идентификатором платёжной сессии 
                        (/payments/card/form?sessionId={sessionId}), 
                        а также сумму и назначение платежа.
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