@extends('layout.main')

@section('content')
<div class="container">
    <div class="row">
        <div class="col s12">
            <div id="calendar">
                <table class="bordered">
                    <thead>
                    <tr class="month"><th>{{$month}}</th></tr>
                    <tr class="day">
                        @foreach($days as $key => $day)
                            <th>
                                <span class="dd-num">{{$day[0]}}</span>
                                <span class="dd-name">{{$day[1]}}</span>
                            </th>
                        @endforeach
                    </tr>
                    </thead>
                    <tbody>

                    @for($i=0;$i< $times->getMaxRow();$i++)
                        <tr>
                        @foreach($days as $key => $day)
                            <td>
                                @if($times->getTimesOfDay($key,$i))
                                    <?php echo \Carbon\Carbon::createFromFormat('Y-F-d H:i', $year.'-'.$month.'-'.$day[0] .' '. $times->getTimesOfDay($key,$i)); exit;?>
                                    @if($course->checkDisponibility('2016-03-01 '.$times->getTimesOfDay($key,$i).':00',1)>=1)
                                        <a href="#modal1" class="modal-trigger btn waves-effect waves-light green"><span class="dd-num">{{ $times->getTimesOfDay($key,$i) }}</span></a>
                                    @else
                                        <div class="btn waves-effect waves-light"><span class="dd-num">{{ $times->getTimesOfDay($key,$i) }}</span></div>
                                    @endif
                                @endif
                            </td>
                        @endforeach
                        </tr>
                    @endfor
                    </tbody>
                </table>



                <div class="next-btn right"><a class="btn-floating waves-effect waves-light blue href="{{ route('next',['dd'=>1]) }}"><i class="material-icons">navigate_next</i></a></div>
                <div class="prev-btn left"><a class="btn-floating waves-effect waves-light blue href="{{ route('next',['dd'=>1]) }}"><i class="material-icons">navigate_before</i></a></div>
            </div>
        </div>





        <!-- Modal Structure -->
        <div id="modal1" class="modal modal-fixed-footer">
            <div class="modal-content">
                <h4>Modal Header</h4>
                <p>A bunch of text</p>
            </div>
            <div class="modal-footer">
                <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat ">Agree</a>
            </div>
        </div>

    </div>
</div>
@endsection

@section('scripts')
    <script>
        $(function(){

            /* next */
            var weeks=0;
            $('.next-btn').on('click',function(e){
                e.preventDefault();
                weeks++;

                $.ajax({
                    type: 'post',
                    url: '/next',
                    datatype: 'json',
                    data: {
                        weeks: weeks
                    }
                })
                .done(function(data){

                    //console.log(data);
                    var _html;
                    $.each(data[1], function(i,e)
                    {
                        _html +=  '<th>'+
                                    '<span class="dd-num">'+e[0]+'</span>'+
                                    '<span class="dd-name"> '+e[1]+'</span>'+
                                 '</th>';

                                    //console.log(html);
                    })

                     $('table thead tr.day')
                        .empty()
                        .html(_html);

                    $('table thead tr.month')
                        .empty()
                        .html('<th>'+data[0]+'</th>');
                });
            });


            /* modal */
            $('.modal-trigger').leanModal({
                        dismissible: true, // Modal can be dismissed by clicking outside of the modal
                        opacity: .5, // Opacity of modal background
                        in_duration: 300, // Transition in duration
                        out_duration: 200, // Transition out duration
                        ready: function() { alert('Ready'); }, // Callback for Modal open
                        complete: function() { alert('Closed'); } // Callback for Modal close
                    }
            );

        });
    </script>
@endsection
