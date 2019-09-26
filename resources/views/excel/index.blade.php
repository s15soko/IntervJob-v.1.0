@extends('app')

@section('content')

    <style>

        div#listContainer{
            width: 100%;
            max-width: 1000px;
            margin: 50px auto 0 auto;
        }

        div#navButtonsContainer{
            margin-bottom: 12px;
        }

        div#navButtonsContainer button{
            margin: 0 3px;
        }

        table{
            width: 100%;
        }

        table td{
            padding: 2px 0;
        }
      
    </style>
    
    <div id="listContainer">

        <div id="navButtonsContainer" style="display: flex; flex-direction: row;">
            <form method="POST" action={{URL::to("/convert")}}>
                @csrf
                <button type="submit" class="btn btn-primary">Konwertuj</button>
            </form>

            <form method="POST" action={{URL::to("/convert/download")}}>
                @csrf
                <button type="submit" class="btn btn-primary">Konwertuj i pobierz</button>
            </form>

            <a href="{{ route('create') }}">
                <button type="submit" class="btn btn-primary">Dodaj nowy plik</button>
            </a>
        </div>

        @if(Session::has('message'))
            <p class="alert alert-info">{{ Session::get('message') }}</p>
        @endif
     
        <table id="tableExcelContent">
            @foreach ($collection as $items)
                    
                @if ($items[0] != "")

                    <tr id={{$items[0]}}>
                        @foreach ($items as $item)
                            <td>{{$item}}</td>
                        @endforeach
                        @if ($items[0] && $items[0] !== "lp.")
                            <td>
                                <a class="btn btn-primary" href="{{ url('/edit/' . $items[0]) }}" role="button">Edytuj</a>
                            </td>
                        @endif
                    </tr>
                @endif
                    
            @endforeach
        </table>
       
        @if ($collection)
            <div id="calculationsBox">
                <h3>Pokaż stan po</h3>
                <div class="form-group" style="margin-top: 14px;">
                    <label for="partyNumber">Liczba imprez z HXS</label>
                    <input type="number" class="form-control" id="partyNumber" placeholder="Mnożnik równa się 0">
                </div>
                <button id="calculateButton" class="btn btn-secondary">Wykonaj obliczenia</button>
            </div>
            <div id="calculationsResultContainer"></div>
        @endif

    </div>

    <script src="{{ asset('js/app.js')}}"></script>
@endsection
