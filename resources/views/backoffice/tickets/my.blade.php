@extends('layouts.backoffice')

@section("css")
    <style>

    </style>
@endsection

@section('page_title')
    Tickets
    <small style="color: #ffffff; font-size: 14px;"></small>
@endsection

@section('content')
    <?php $CompanySession = session("companyID"); ?>
    <div class="content">
        <div class="block">
            <div class="block-content">
                    {{--show all data session --}}
                    
        
                <h4 class="page-title">Mis Tickets</h4>

                <table id="list-items" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th class="align-top">Asunto</th>
                        <th class="align-top">Mensaje</th>
                        <th class="align-top">Emisor</th>
                        <th class="align-top">Receptor</th>
                        <th class="align-top" width="12%">Fecha de emisi&oacute;n</th>
                        <th class="align-top" width="6%">Opciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($tickets->count())
                        @foreach($tickets as $ticket)
                
                            <tr>
                                <td>{!! $ticket->subject !!}</td>
                                <td>{!! $ticket->message !!}</td>
                                <td>{!! $ticket->companyTransmitter->name !!}</td>
                                <td>{!! $ticket->companyReceiver->name !!}</td>
                                <td class="text-center">{{ datetimeFormat($ticket->created_at, 'Y-m-d') }}</td>
                                <td class="text-center">
                                    <a href="{{ route('backoffice.tickets.emission', ['id' => $ticket->emission_id]) }}" class="btn btn-sm btn-success">
                                        <i class="fa fa-paper-plane" aria-hidden="true"></i>
                                    </a>
                
                                    @if($CompanySession == $ticket->transmitter_id)
                                    <a href="{{ route('backoffice.tickets.close', ['id' => $ticket->id]) }}" class="btn btn-sm btn-danger">
                                        <i class="fa fa-ban" aria-hidden="true"></i>
                                    </a>
                                    @endif
                                    
                                </td>
                                
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="7">No se encontraron registros...</td>
                        </tr>
                    @endif

                    </tbody>

                </table>

            </div>
        </div>
    </div>
@endsection