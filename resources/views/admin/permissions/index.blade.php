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
                
            </div>
        </div>

        <div class="row">
            
            <div class="col-12">

                <div class="block">
                    <div class="block-content">

                        <table id="list-items" class="table table-bordered table-striped">
                            <thead>

                            <tr>
                                <th>Permiso</th>
                                @foreach($roles as $role)
                                <th class="text-center">{!! $role->title !!}</th>
                                @endforeach
                                <th class="text-center" width="10%">Opciones</th>
                            </tr>

                            </thead>
                            <tbody>
                            @foreach($permissions as $permission)
                                <tr>
                                    <td>{!! $permission->title !!}</td>

                                    @foreach($roles as $role)
                                        <td class="text-center">
                                            @if($role->hasPermissionTo($permission->name))
                                                <a title="Activo" href="{{ route('admin.permissions.status', ['role' => $role->id, 'permission' => $permission->id]) }}"><i class="fa fa-toggle-on fa-lg"></i></a>
                                            @else
                                                <a title="Inactivo" href="{{ route('admin.permissions.status', ['role' => $role->id, 'permission' => $permission->id]) }}"><i class="fa fa-toggle-off fa-lg"></i></a>
                                            @endif
                                        </td>
                                    @endforeach

                                    <td class="text-center">
                                        {!! Form::open(['route' => [$routeDestroy, $permission->id]]) !!}
                                        <div class="btn-group">
                                            @if(isAdminOrHasPermissionOf('edit-action'))
                                            <a href="{{ route($routeEdit, ['id' => $permission->id]) }}" class="btn btn-success btn-sm"><i class="fa fa-edit"></i></a>
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

@endsection