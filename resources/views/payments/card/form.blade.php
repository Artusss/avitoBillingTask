@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h2>Осуществление платежа</h2>
                <h3>Сумма : {{ $nominal }}</h2>
                <h3>Назначение платежа : {{ $slug }}</h2>
                <form action="{{ url('/payments/card/form?sessionId='.$sessionId) }}" method="post">
                    <div class="form-group">
                        <label for="card">Номер карты:</label>
                        <input type="text" class="form-control" required name="card" id="card" maxlength="16" value="">
                    </div>
                    <div class="form-group">
                        <input type="submit" onclick="callbackResponse()" class="btn btn-primary" name="pay" value="Оплатить">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        function callbackResponse(){
            let cardValue = document.getElementById("card").value;
            if(luhnAlgorithm(cardValue))
            {
                $.ajax({
                    type: "POST",
                    url: {{ $callbackUrl }},
                    data: {
                        message: "Ответ на совершение платежа"
                    }
                });
            }
        }
        function luhnAlgorithm(value) {
            let sum = 0;
            for (let i = 0; i < value.length; i++) {
                let cardNum = parseInt(value[i]);
                if ((value.length - i) % 2 === 0) 
                {
                    cardNum *= 2;
                    if (cardNum > 9) cardNum -= 9;
                }
                sum += cardNum;
            }
            return sum % 10 === 0;
        }
    </script>
@endsection