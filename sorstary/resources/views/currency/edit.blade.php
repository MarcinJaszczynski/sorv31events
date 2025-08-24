@extends('layouts.app')
@section('content')
<div class="container">
    <div class="justify-content-center">
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>Opps!</strong> Something went wrong, please check below errors.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="card">
            <div class="card-header">Waluty - edycja
                <span class="float-right">
                    <a class="btn btn-primary" href="{{ route('currency.index') }}">Waluty</a>
                </span>
            </div>
            <div class="card-body">
                {!! Form::model($currency, ['route' => ['currency.update', $currency->id],'method' => 'PATCH']) !!}
                    <div class="form-group">
                        <strong>Nazwa:</strong>
                        {!! Form::text('name', null, array('placeholder' => $currency->name,'class' => 'form-control')) !!}
                    </div>
                    <div class="form-group">
                        <strong>Nazwa:</strong>
                        {!! Form::text('symbol', null, array('placeholder' => $currency->symbol,'class' => 'form-control')) !!}
                    </div>
              
                    <button type="submit" class="btn btn-primary">Submit</button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection