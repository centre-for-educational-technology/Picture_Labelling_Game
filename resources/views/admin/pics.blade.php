@extends('layouts.app')

@section('title') Pictures @stop

@section('content')

    <div class="container-fluid">

        <div class='col-md-8 col-md-offset-2'>

            @include('flash::message')


            @if ($errors->has())
                @foreach ($errors->all() as $error)
                    <div class='bg-danger alert'>{{ $error }}</div>
                @endforeach
            @endif

            <h1><i class='fa fa-upload'></i> Upload a picture</h1>

                    {!! Form::open(array('url'=>'admin/pictures','method'=>'POST', 'files'=>true)) !!}
                    <div class="control-group">
                        <div class="controls">
                            {!! Form::file('image') !!}
                            <p class="errors">{!!$errors->first('image')!!}</p>
                        </div>
                    </div>
                    <div id="success"> </div>
                    {!! Form::submit('Submit', array('class'=>'btn btn-info pull-left')) !!}
                    {!! Form::close() !!}

        </div>
    </div>

    <div class="row">
        <div class="col-sm-6" id="slider-thumbs">
            <!-- Bottom switcher of slider -->
            <ul class="hide-bullets">

                @foreach ($pics->all() as $key=>$pic)
                    <li class="col-sm-3">
                        <a class="thumbnail" id="carousel-selector-{{ ++$key }}">
                            <img src="{{ url('pictures/'.$pic->filename) }}">
                        </a>
                        {{ Form::open(['url' => 'admin/pictures/' . $pic->id, 'method' => 'DELETE', 'class'=>'picture-delete']) }}
                        {{ Form::submit('Delete', ['class' => 'btn btn-danger'])}}
                        {{ Form::close() }}
                    </li>
                @endforeach


            </ul>
        </div>
        <div class="col-sm-6">
            <div class="col-xs-12" id="slider">
                <!-- Top part of the slider -->
                <div class="row">
                    <div class="col-sm-12" id="carousel-bounding-box">
                        <div class="carousel slide" id="myCarousel">
                            <!-- Carousel items -->
                            <div class="carousel-inner">

                                @foreach ($pics->all() as $key=>$pic)

                                    @if ($key == 0)
                                        <div class="active item" data-slide-number="{{ ++$key }}">
                                            <img src="{{ url('pictures/'.$pic->filename) }}"></div>

                                    @else

                                    <div class="item" data-slide-number="{{ ++$key }}">
                                        <img src="{{ url('pictures/'.$pic->filename) }}"></div>


                                    @endif
                                @endforeach


                            </div>
                            <!-- Carousel nav -->
                            <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
                                <span class="glyphicon glyphicon-chevron-left"></span>
                            </a>
                            <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
                                <span class="glyphicon glyphicon-chevron-right"></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/Slider-->
    </div>

@stop