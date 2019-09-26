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

      
    </style>
    
    <div id="listContainer">

        @if(Session::has('message'))
            <p class="alert alert-info">{{ Session::get('message') }}</p>
        @endif

        <div id="navButtonsContainer" style="display: flex; flex-direction: row;">
            <form method="POST" action={{URL::to("/convert")}}>
                @csrf
                <button type="submit" class="btn btn-primary">Konwertuj</button>
            </form>

            <a href="{{ route('create') }}">
                <button type="submit" class="btn btn-primary">Dodaj nowy plik</button>
            </a>
        </div>
     
        <table>
            @foreach ($collection as $items)
                
                @if ($items[0] != "")

                    <tr id={{$items[0]}}>
                        @foreach ($items as $item)
                            <td>{{$item}}</td>
                        @endforeach
                        @if ($items[0] != "lp.")
                            <td>
                                <a class="btn btn-primary" href="{{ url('/edit/' . $items[0]) }}" role="button">Edytuj</a>
                            </td>
                        @endif
                    </tr>
                @endif
                    
            @endforeach
        </table>
       

    </div>

@endsection