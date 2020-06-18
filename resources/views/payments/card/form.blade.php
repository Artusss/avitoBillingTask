@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h2>Осуществление платежа</h2>
                <h3>Сумма : {{ $nominal }}</h2>
                <h3>Назначение платежа : {{ $slug }}</h2>
                <form action="{{ url('/payments/card/form') }}" method="post">
                    <div class="form-group">
                        <label for="card">Номер карты:</label>
                        <input type="text" class="form-control" required name="card" maxlength="16" value="">
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" name="pay" value="Оплатить">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection