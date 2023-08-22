@extends('layouts.admin')

@section('styles-footer')

@endsection

@section('scripts-footer')
    <script>
        $(function () {

        })
    </script>
@endsection

@section('content')
    <!-- Page Content -->
    <div class="content">

        <div class="row">
            
            <div class="col-6">
                
                <div class="block">
                    <div class="block-header block-header-default">

                        <h3 class="block-title">
                            {!! $pageTitle !!}
                        </h3>

                    </div>
                    <div class="block-content">

                        {!! Form::model($item, ['route' => [$routeUpdate], 'class' => 'form-horizontal']) !!}
                            <div class="row">
                                <div class="col-md-12">

                                    @include('admin.'.$module.'.fields')

                                    <div class="form-group">
                                        {!! csrf_field() !!}
                                        @method('PUT')
                                        <button type="submit" class="btn btn-primary">Guardar</button>
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
