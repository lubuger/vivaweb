<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="csrf-token" content="{{ Session::token() }}">

        <title>Laravel</title>

        {{--chart lib--}}
        <link rel="stylesheet" href="{{ asset('css/vis-timeline-graph2d.min.css') }}">
        <script type="text/javascript" src="{{ asset('js/vis.min.js') }}"></script>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        {{--jQuery--}}
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

        {{-- materialize css--}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.1/css/materialize.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.1/js/materialize.min.js"></script>

        {{--main style--}}
        <link rel="stylesheet" type="text/css" href="{{ asset('css/main.css') }}">

        {{-- color picker--}}
        <link rel="stylesheet" type="text/css" href="{{ asset('css/colorpicker.css') }}">
        <script type="text/javascript" src="{{ asset('js/colorpicker.js') }}"></script>

        {{--js core includes--}}
        <script type="text/javascript" src="{{ asset('js/main.js') }}"></script>
    </head>
    <body>

        <div class="container">
            <div class="row">

                <div class="col s8">
                    <form action="#" class="mt30">
                        <p class="range-field">
                            <input type="range" id="rangeSplitter" min="1" max="3600" value="3600"/>
                        </p>
                    </form>

                    <div id="visualization"></div>
                </div>

                <div class="col s4">
                    <table class="responsive-table highlight centered">
                        <thead>
                        <tr>
                            <th>Имя</th>
                            <th>Статус</th>
                            <th>Цвет</th>
                        </tr>
                        </thead>

                        <tbody>

                            @foreach($users as $user)
                                <tr>
                                    <td>{{ $user['name'] }}</td>
                                    <td>
                                        <div class="switch">
                                            <label>
                                                Зашёл
                                                <input type="checkbox" class="switch-user-status" data-userid="{{ $user['id'] }}" {{ ( $user['status'] === 1 ) ? 'checked="checked"' : '' }}>
                                                <span class="lever"></span>
                                                Ушёл
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="color-picker" data-userid="{{ $user['id'] }}" style="background: {{ $user['color'] }}"></div>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    <script type="text/javascript">

        var token = "{{ Auth::user()->api_token }}";
        // 10 +
        // 11 +
        // 12 +
        // 13 +
        // 14 +
        // 15 -
        // 16 +
        // 17 +
        // 18 +
        // 19 +
        // 20 -


//        console.log( resArr );
//        let renderArr = [ ];
//        let renderSplit = 1;
//        let renderCurrent = 0;
//
//        for(let i=0; i<resArr.length; i++)
//        {
//            let current = resArr[i];
//            let total = current.to - current.from;
//            let currentSplitCount = Math.ceil(total / renderSplit); // 5
//
//            console.log( 'current arr => ' + ( i + 1) );
//
//            for( let j=0; j<currentSplitCount; j++ )
//            {
//                let fillPercent = total - j;
//
//                if( ( j > 1 && j === total ) || fillPercent >= 1 )
//                    renderArr[renderCurrent] = 1;
//                else
//                    renderArr[renderCurrent] = fillPercent * 100;
//
//                console.log( '  renderArr[' + renderCurrent + ']' + ' => ' + renderArr[renderCurrent]);
//
//                renderCurrent++;
//            }
//
//        }
//
//        console.log( renderArr );


    </script>
    </body>
</html>
