@extends('app')

@section('content')

    <style>

        div#uploadFileContainer{
            width: 100%;
            max-width: 1000px;
            margin: 50px auto 0 auto;
        }

    </style>
    
    <div id="uploadFileContainer">

        <form method="POST" action={{URL::to("/store")}} enctype="multipart/form-data">

            <div class="form-group">
                <label for="inputFile">Wrzuć plik</label>
                <input id="inputFile" class="form-control-file" type="file" name="file"/>
            </div>

            @if(Session::has('message'))
                <p class="alert alert-info">{{ Session::get('message') }}</p>
            @endif

            @csrf
            <button type="submit" class="btn btn-primary btn-sm">Dodaj</button>

        </form>

    </div>

@endsection