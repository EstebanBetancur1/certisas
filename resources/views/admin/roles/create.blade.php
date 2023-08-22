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
                
               <a href="{{ route($routeIndex) }}" class="btn btn-outline-secondary">Volver</a>

            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="block">
                    <div class="block-content">
                        <form class="form-horizontal" action="{{ route($routeStore) }}" method="post">

                            <div class="row">
                                <div class="col-md-8">

                                    @include('admin.'.$module.'.fields')

                                    <div class="form-group">
                                        <div class="col-sm-offset-3 col-sm-10">
                                            {!! csrf_field() !!}
                                            <button type="submit" class="btn btn-primary">Guardar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                     </div>
                </div>
            </div>
        </div>

    </div>
    <!-- END Page Content -->   
@endsection
