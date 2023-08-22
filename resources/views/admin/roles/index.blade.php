@extends('layouts.admin')


@section('content')

    <!-- Page Content -->
    <div class="content">

        <div class="row">
            <div class="col-md-8">
                <h2>
                    {!! $pageTitle !!}
                </h2>
            </div>
            <div class="col-md-4 text-right">
                @if(isAdminOrHasPermissionOf('create-action'))
                    <a href="{{ route($routeCreate) }}" class="btn btn-success">{!! $textCreateBtn !!}</a>
                @endif
            </div>
        </div>

        <div class="row">
            
            <div class="col-12">

                <div class="block">

                    <div class="block-content">

                        <table id="list-items" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>T&iacute;tulo</th>
                                <th width="20%">Rol</th>
                                <th class="text-center" width="15%">Opciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($items as $item)
                                <tr>
                                    <td>{{ $item->title }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td class="text-center">
                                        {!! Form::open(['route' => [$routeDestroy, $item->id]]) !!}
                                        <div class="btn-group">
                                            @if(isAdminOrHasPermissionOf('edit-action'))
                                                <a href="{{ route($routeEdit, ['id' => $item->id]) }}" class="btn btn-success btn-sm"><i class="fa fa-edit"></i></a>
                                            @endif

                                            @method('DELETE')

                                            @if(isAdminOrHasPermissionOf('delete-action'))
                                                <button type="submit" onclick="return confirm('Desea eliminar el registro?')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                            @endif
                                        </div>
                                        {!! Form::close() !!}
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                       
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- END Page Content -->

@endsection