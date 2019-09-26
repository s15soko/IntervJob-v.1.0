@extends('app')

@section('content')

    <style>

        div#editFileRowContainer{
            width: 100%;
            max-width: 1000px;
            margin: 50px auto 0 auto;
        }

    </style>
    
    <div id="editFileRowContainer">

        <form method="POST" action={{URL::to("/update")}}>

            <div class="form-group">
                <label for="inputFigureName">Nazwa postaci</label>
                <input type="text" name="figure_name" class="form-control" id="inputFigureName" value={{$collection[1]}} placeholder="Nazwa postaci">
            </div>
            <div class="form-group">
                <label for="inputEnthusiasm">Entuzjazm</label>
                <input type="number" name="enthusiasm" class="form-control" id="inputEnthusiasm" value={{$collection[2]}} placeholder="Entuzjazm">
            </div>
            <div class="form-group">
                <label for="inputCreativity">Kreatywność</label>
                <input type="number" name="creativity" class="form-control" id="inputCreativity" value={{$collection[2]}} placeholder="Kreatywność">
            </div>
            <div class="form-group">
                <label for="inputCreativity">Błyskotliwość</label>
                <input type="number" name="brilliance" class="form-control" id="inputBrilliance" value={{$collection[3]}} placeholder="Błyskotliwość">
            </div>

            @if(Session::has('message'))
                <p class="alert alert-info">{{ Session::get('message') }}</p>
            @endif

            @csrf
            <input type="hidden" name="key" value={{$collection[0]}} />
            <button type="submit" class="btn btn-primary">Aktualizuj</button>

        </form>

    </div>

@endsection