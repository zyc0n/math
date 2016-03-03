@extends('layout.main')

<?php
    $hh = array('11','12','13','14','15','16','17','18','19','20');
    $mm = array('00','15','30','45');
    $dd = array('lunedì','martedì','mercoledì','giovedì','venerdì','sabato','domenica');
?>
@section('content') 
    <div class="error">
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    </div>

<div class="container">
    <form id="times-form" role="form" method="POST" action="{{ url('/admin') }}">
    <ul id="admin-calendar" class="collapsible" data-collapsible="accordion">
        @foreach ($dd as $d_key => $d) 
        <li class="day">
            <div class="collapsible-header"><i class="material-icons">access_time</i>{{$d}}</div>
            <div class="collapsible-body">
                <div class="row">
                    <div class="col s12 center-align pad-y-10">
                        <a class="add-btn btn-floating blue"><i class="material-icons">add</i></a>
                    </div>
                    <div class="time input-field col s12" data-days="{{$d_key}}">


                        @if(isset($days))
                            @for($i=0;$i<count($days);$i++)
                            @if($days[$i]['day']==$d_key)
                            <div class="timex clearfix">
                            <div class="divider"></div>
                            <input type="hidden" name="days[{{$i}}][day]" value="{{$d_key}}">
                            <select id="hh" name="days[{{$i}}][hh]" class="col s4">
                                @foreach ($hh as $key => $h) 
                                    <option @if($h==$days[$i]['hh'])selected="selected"@endif value="{{$h}}">{{$h}}</option>
                                @endforeach
                            </select>
                            <select id="mm" name="days[{{$i}}][mm]" class="col s4">
                                @foreach ($mm as $key => $m) 
                                    <option @if($m==$days[$i]['mm'])selected="selected"@endif value="{{$m}}">
                                    {{$m}}</option>
                                @endforeach
                            </select><div class="col s4 nav"><a href="#" class="remove-btn right"><i class="material-icons">remove_circle_outline</i></a></div></div>
                            @endif
                            @endfor
                        @endif



                    </div>     
                </div>
            </div>
        </li>
        @endforeach
    </ul>
    <button type="submit" class="save-btn btn-floating btn-large waves-effect waves-light red right"><i class="material-icons">save</i></button>
    {!! csrf_field() !!}
    </form>

</div>
@if (Auth::check())
    <a href="{{ url('/logout') }}">logout</a>
@endif
@stop 

@section('scripts')
<script>
    $(document).ready(function() {
        //alert('cacasd')
        var i = $('.timex').length>=1?$('.timex').length:0;
        //$('select').material_select();
        $('.collapsible').collapsible({
          accordion : false // A setting that changes the collapsible behavior to expandable instead of the default accordion style
        });

        $('#admin-calendar').on('click','.add-btn',function(e){
            e.preventDefault();
            var time = $(this).parent().parent().find('.time');
            time.append(_html(time.data('days')));
            //$('select').material_select();
            
            time.find('input[name=days]').attr('name','days['+i+'][day]');
            time.find('select[name=hh]').attr('name','days['+i+'][hh]');
            time.find('select[name=mm]').attr('name','days['+i+'][mm]');
            i++;
        });

        $('#admin-calendar').on('click','.remove-btn',function(e){
            e.preventDefault();
            $(this).parent().parent().remove();
        });

        /*$('.save-btn').on('click',function(){
            var times = [];
            $.each($('.timex'),function(index, el) {
                times.push({
                                day: $(el).data('day'),
                                times: [
                                    $(el).find('select[name=hh]').val(),
                                    $(el).find('select[name=mm]').val(),
                                ]
                            }
                );
            });
            $.ajax({
                type: 'post',
                url: '/admin',
                datatype: 'json',
                data: { 
                    times: times,
                    }
            })
            .done(function(data){
                console.log(data);
            });

        });*/



        var _html = function(day){
            return '<div class="timex clearfix"><div class="divider"></div><input type="hidden" name="days" value="'+day+'">'+              
                    '<select id="hh" name="hh" class="col s4">'+
                        @foreach ($hh as $key => $h) 
                            '<option value="{{$h}}">{{$h}}</option>'+
                        @endforeach
                    '</select>'+
                    '<select id="mm" name="mm" class="col s4">'+
                        @foreach ($mm as $key => $m) 
                            '<option value="{{$m}}">'+
                            '{{$m}}</option>'+
                        @endforeach
                    '</select><div class="col s4 nav"><a href="#" class="remove-btn right"><i class="material-icons">remove_circle_outline</i></a></div></div>';
                }

    });
</script>
@stop