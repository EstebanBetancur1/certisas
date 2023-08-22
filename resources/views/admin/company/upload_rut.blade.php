@extends('layouts.'. $appLayout)

@section('css')
    <style type="text/css">

    </style>
@endsection

@section('js')
    <script>
        $(function () {
            
        })
    </script>
@endsection

@section('content')

    <div class="content">

        <div class="row">
            <div class="col-md-8">
                <h2>{!! $pageTitle !!}: <small>{!! $item->name !!}</small></h2>
            </div>
            <div class="col-md-4 text-right">
                <a href="{{ route($routeIndex) }}" class="btn btn-outline-secondary">Volver</a>
            </div>
        </div>

        {!! Form::model($item, ['route' => ["admin.company.update.rut", $item->id], 'class' => 'form-horizontal', "files" => true ]) !!}
        <div class="row">
            
            <div class="col-6">

                <div class="block">

                    <div class="block-content">

                        <div class="form-group">
                            <label for="rut">Cargar RUT</label>
                            <input type="file" class="form-control" id="rut" name="rut">
                            @if ($errors->has('rut'))
                                <span class="text-danger" role="alert">
                                    <strong>{{ $errors->first('rut') }}</strong>
                                </span>
                            @endif
                        </div>                           


                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Cargar</button>
                            <a href="{{ route("admin.company.edit", ['id' => $item->id]) }}" class="btn btn-secondary"><i class="fa fa-edit"></i></a>
                        </div>

                    </div>

                </div>

            </div>
        </div>
        {{ Form::close() }}

    </div>

@endsection
