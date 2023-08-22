@extends('layouts.backoffice')

@section("css")
    <style>
        .block-content.block-content-full i.fa{
            font-size: 50px;
            color: #dbdbdb;
        }

        .block-content p{
            padding-bottom: 0px!important;
            margin-bottom: 0px!important;
        }

        .other-message{
            padding-right: 15%;
        }

        .my-message{
            padding-left: 15%;
        }

        .wrapper-chat{
            margin-top: 20px;
            margin-bottom: 20px;
            width: 100%;
        }

        .message{
            padding: 5px 10px;
            margin-bottom: 10px;

            border-radius: 5px;
            -moz-border-radius: 5px;
            -webkit-border-radius: 5px;
        }

        .message .datetime{
            font-size: 10px;
            margin-bottom: 5px;
        }

        .my-message .message{
            background-color: #abd3fa;
        }

        .other-message .message{
            background-color: #f1f1f1;
        }
    </style>
@endsection

@section('page_title')
    Tickets
    <small style="color: #ffffff; font-size: 14px;">Resumen del panel</small>
@endsection

@section('content')

    <div class="content">
        <div class="block">
            <div class="block-content">

                <div class="row">
                    <div class="col-10">
                        <h4>
                            Ticket para: <small>{!! $emission->agent_name !!}, {{ $emission->agent_nit }}</small>
                        </h4>
                    </div>

                    <div class="col-2 text-right">
                        <a href="{{ url()->previous() }}" class="btn btn-sm btn-secondary"> Volver </a>
                    </div>
                </div>

                @if($ticket)
                    <div style="border-left: 3px solid #cecece; padding-left: 15px; margin-bottom: 20px;">
                        <h5>{!! $ticket->subject !!}</h5>
                        <p>{!! $ticket->message !!}</p>

                        @if($ticket->file)
                            <a href="{{ route('backoffice.tickets.download.file', ['id' => $ticket->id]) }}">Descargar archivo</a>
                        @endif
                    </div>

                    @if($messages && is_object($messages) && $messages->count())
                        <div class="wrapper-chat">
                            @foreach($messages as $message)
                            <div class="row">
                                <div class="col {{ ((int)$message->user_id === (int)auth()->user()->id)?'my-message':'other-message' }}">
                                    <div class="message">
                                        <div class="datetime">{{ datetimeFormat($message->created_at, 'Y-m-d') }},
                                            @if($message->file)
                                               |  <a style="color: #ffffff;" href="{{ route('backoffice.tickets.message.download.file', ['id' => $message->id]) }}">Descargar archivo</a>
                                            @endif

                                        </div>
                                        {!! $message->message !!}
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-info">Aun no tiene mensaje este ticket.</div>
                    @endif

                    <hr />

                    <form class="form-horizontal" action="{{ route('backoffice.tickets.reply.store', [$ticket->id]) }}" method="post" enctype="multipart/form-data">

                        <div class="row justify-content-md-center">
                            <div class="col-md-12">

                                <div class="form-group">
                                    {!! Form::label('message', 'Mensaje', ['class' => 'control-label']) !!}
                                    {!! Form::textarea('message', null, ['class' => 'form-control', 'placeholder' => '', 'maxlength' => 1000]) !!}
                                    @if ($errors->has('message'))
                                        <p class="text-danger">{!! $errors->first('message') !!}</p>
                                    @endif
                                </div>

                                <div class="form-group">
                                    {!! Form::label('file', 'Archivo', ['class' => 'control-label']) !!}
                                    {!! Form::file('file', null, ['class' => 'form-control', 'placeholder' => '']) !!}
                                    @if ($errors->has('file'))
                                        <p class="text-danger">{!! $errors->first('file') !!}</p>
                                    @endif
                                </div>

                                <div class="form-group">
                                    {!! csrf_field() !!}
                                    <button type="submit" class="btn btn-primary btn-sm"> Enviar </button>
                                </div>

                            </div>
                        </div>

                    </form>

                @else

                    <hr />

                    <form class="form-horizontal" action="{{ route('backoffice.tickets.emission.store', [$emission->id]) }}" method="post" enctype="multipart/form-data">

                        <div class="row justify-content-md-center">

                            <div class="col-md-12">

                                <div class="form-group">
                                    {!! Form::label('subject', 'Asunto', ['class' => 'control-label']) !!}
                                    {!! Form::text('subject', null, ['class' => 'form-control', 'placeholder' => '']) !!}
                                    @if ($errors->has('subject'))
                                        <p class="text-danger">{!! $errors->first('subject') !!}</p>
                                    @endif
                                </div>

                                <div class="form-group">
                                    {!! Form::label('message', 'Mensaje', ['class' => 'control-label']) !!}
                                    {!! Form::textarea('message', null, ['class' => 'form-control', 'placeholder' => '', 'maxlength' => 1000]) !!}
                                    @if ($errors->has('message'))
                                        <p class="text-danger">{!! $errors->first('message') !!}</p>
                                    @endif
                                </div>

                                <div class="form-group">
                                    {!! Form::label('file', 'Archivo', ['class' => 'control-label']) !!}
                                    {!! Form::file('file', null, ['class' => 'form-control', 'placeholder' => '']) !!}
                                    @if ($errors->has('file'))
                                        <p class="text-danger">{!! $errors->first('file') !!}</p>
                                    @endif
                                </div>

                                <div class="form-group">
                                    {!! csrf_field() !!}
                                    <button type="submit" class="btn btn-primary btn-sm"> Enviar </button>
                                </div>

                            </div>
                        </div>

                    </form>
                @endif
            </div>
        </div>
    </div>
@endsection