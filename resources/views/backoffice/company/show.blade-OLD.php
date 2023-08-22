@extends('layouts.backoffice')

@section('css')

<style type="text/css">
    .preview-image>.image {
        text-align: center;
    }

    .preview-image>.image img {
        margin: 0 auto;
    }

    #summary {
        height: 150px;
    }

</style>

@endsection

@section('js')
<script src="{{ asset('global-vendor/preview/preview.js') }}" type="text/javascript"></script>

<script>
    $(function () {
        $(".preview-image").preview({
            allowedTypes: "jpg,jpeg,png",
            pathPreview: '/images/default-image.png'
        });
    })

</script>
@endsection

@section('page_title')
Administraci&oacute;n / <small style="color: #ffffff;">Informaci&oacute;n de la empresa</small>
@endsection

@section('content')
<!-- <ul class="cs-breadcrumbs">
                <li><a href="#"><i class="icon-arrow-left"></i> Administración</a></li>
                <li><span>Editar certificado</span></li>
            </ul> -->
<div class="content content-scroll">

    <!--
        <div class="row">
            <div class="col-md-8">
                <h2>
                    Informaci&oacute;n
                </h2>
            </div>
            <div class="col-md-4 text-right">
                <a href="{{ route('backoffice.account.dashboard') }}" class="btn btn-secondary">Volver</a>
            </div>
        </div>
        -->


    <div class="row">
        <div class="col-md-12">
            <div class="page-headline">
                <h4 class="page-title">Información empresas</h4>
                <!-- <label class="cs-btn btn-outline-secundary sm-btn mb-0" for="update-rut">Nuevo Rut</label> -->
            </div>
            
        </div>
        <div class="col-md-6">
            <h4 class="page-subtitle">Rut</h4>
            <div class="rut-table-container">
                 <table class="table mb-0 table-bordered table-striped rut-table">
                    <tbody>

                        <tr>
                            <th>Nombre</th>
                            <td>
                                {!! $item->name !!}

                                <!--
                                                <a class="btn btn-sm btn-primary" href="{{ route('backoffice.company.download') }}">Descargar RUT</a>
                                                -->
                            </td>
                        </tr>

                        <tr>
                            <th>Nit</th>
                            <td>{!! $item->nit !!}</td>
                        </tr>
                        <tr>
                            <th>DV</th>
                            <td>{!! $item->dv !!}</td>
                        </tr>
                        <tr>
                            <th>Direcci&oacute;n seccional</th>
                            <td>{{ $item->sectional }} - {!! ($sectional)?$sectional->title:$item->sectional !!}</td>
                        </tr>
                        <tr>
                            <th>Tipo</th>
                            <td>

                                @if((int)$item->type === 1)
                                Persona Jur&iacute;dica
                                @else
                                Persona Natural
                                @endif

                            </td>
                        </tr>

                        <tr>
                            <th>Ciudad</th>
                            <td>{!! getOnlyCity($item->city) !!}</td>
                        </tr>

                        <tr>
                            <th>Direcci&oacute;n</th>
                            <td>{!! $item->address !!}</td>
                        </tr>

                        <tr>
                            <th>Email RUT</th>
                            <td>{!! $item->email !!}</td>
                        </tr>

                        <tr>
                            <th>Tel&eacute;fono</th>
                            <td>{!! $item->phone !!}</td>
                        </tr>

                        <tr>
                            <th>Actividades</th>
                            <td>{!! $item->activities !!}</td>
                        </tr>

                        <tr>
                            <th>Responsabilidades</th>
                            <td>
                                @php
                                $data = ($item->responsibilities)?json_decode($item->responsibilities, true):[];
                                @endphp

                                @foreach($data as $code => $value)
                                <p>{!! $value !!}</p>
                                @endforeach
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
           <div>
              <input name="rut" id="update-rut" type="file" class="rut-upload" required
                        accept="application/pdf, .doc,.docx,application/msword">
               <label class="cs-btn btn-outline-secundary sm-btn mb-0" for="update-rut">Nuevo Rut</label>
           </div>

        </div>
        <div class="col-md-3">
            <h4 class="page-subtitle">Actividad reciente</h4>
            <div class="activity-container">
                <div class="recent-item">
                    <div class="icon-state">
                        <svg height="40" width="40">
                            <circle cx="20" cy="20" r="18" stroke="black" stroke-width="2.5" fill="#fff" />
                        </svg>
                        <i class="icon-file"></i>
                    </div>

                    <div>
                        <p>Certificado generado</p>
                        <span>afernandez@amsty.com</span>
                    </div>
                    
                </div>
                <div class="recent-item">
                    <div class="icon-state">
                        <svg height="40" width="40">
                            <circle cx="20" cy="20" r="18" stroke="black" stroke-width="2.5" fill="#fff" />
                        </svg>
                        <i class="icon-file"></i>
                    </div>

                    <div>
                        <p>Certificado generado</p>
                        <span>afernandez@amsty.com</span>
                    </div>
                    
                </div>
                <div class="recent-item">
                    <div class="icon-state no-complete">
                        <svg height="40" width="40">
                            <circle cx="20" cy="20" r="18" stroke="black" stroke-width="2.5" fill="#fff" />
                        </svg>
                        <i class="icon-file"></i>
                    </div>

                    <div>
                        <p>Certificado generado</p>
                        <span>afernandez@amsty.com</span>
                    </div>
                    
                </div>
                <div class="recent-item">
                    <div class="icon-state">
                        <svg height="40" width="40">
                            <circle cx="20" cy="20" r="18" stroke="black" stroke-width="2.5" fill="#fff" />
                        </svg>
                        <i class="icon-file"></i>
                    </div>

                    <div>
                        <p>Certificado generado</p>
                        <span>afernandez@amsty.com</span>
                    </div>
                    
                </div>
                <div class="recent-item">
                    <div class="icon-state">
                        <svg height="40" width="40">
                            <circle cx="20" cy="20" r="18" stroke="black" stroke-width="2.5" fill="#fff" />
                        </svg>
                        <i class="icon-file"></i>
                    </div>

                    <div>
                        <p>Certificado generado</p>
                        <span>afernandez@amsty.com</span>
                    </div>
                    
                </div>
            </div>
            <h4 class="page-subtitle">Fechas importantes</h4>
            <div class="activity-container mb-0">
                <div class="recent-item">
                    <div class="icon-state">
                        <svg height="40" width="40">
                            <circle cx="20" cy="20" r="18" stroke="black" stroke-width="2.5" fill="#fff" />
                        </svg>
                        <i class="icon-file"></i>
                    </div>

                    <div>
                        <p>Certificado generado</p>
                        <span>afernandez@amsty.com</span>
                    </div>
                    
                </div>
                <div class="recent-item">
                    <div class="icon-state">
                        <svg height="40" width="40">
                            <circle cx="20" cy="20" r="18" stroke="black" stroke-width="2.5" fill="#fff" />
                        </svg>
                        <i class="icon-file"></i>
                    </div>

                    <div>
                        <p>Certificado generado</p>
                        <span>afernandez@amsty.com</span>
                    </div>
                    
                </div>
                <div class="recent-item">
                    <div class="icon-state">
                        <svg height="40" width="40">
                            <circle cx="20" cy="20" r="18" stroke="black" stroke-width="2.5" fill="#fff" />
                        </svg>
                        <i class="icon-file"></i>
                    </div>

                    <div>
                        <p>Certificado generado</p>
                        <span>afernandez@amsty.com</span>
                    </div>
                    
                </div>
                <div class="recent-item">
                    <div class="icon-state">
                        <svg height="40" width="40">
                            <circle cx="20" cy="20" r="18" stroke="black" stroke-width="2.5" fill="#fff" />
                        </svg>
                        <i class="icon-file"></i>
                    </div>

                    <div>
                        <p>Certificado generado</p>
                        <span>afernandez@amsty.com</span>
                    </div>
                    
                </div>
                <div class="recent-item">
                    <div class="icon-state">
                        <svg height="40" width="40">
                            <circle cx="20" cy="20" r="18" stroke="black" stroke-width="2.5" fill="#fff" />
                        </svg>
                        <i class="icon-file"></i>
                    </div>

                    <div>
                        <p>Certificado generado</p>
                        <span>afernandez@amsty.com</span>
                    </div>
                    
                </div>
            </div>
        </div>
        <div class="col-md-3">

            <h4 class="page-subtitle">Logo de la empresa</h4>

            {!! Form::open(['route'=>'backoffice.company.updateLogo', 'files' => true]) !!}

            @if($logo)
            <div class="preview-image brand-logo img-contain"
                data-image="upload/companies/{{ $logo }}"></div>
            @else
            <div class="preview-image brand-logo img-contain"></div>
            @endif

            <!-- <span class="label label-primary"><i class="fa fa-info-circle" aria-hidden="true"></i> Dimensiones: 200px por 200px</span> -->

            <div>
                <!-- <button type="submit" class="btn btn-sm btn-warning">Actualizar</button> -->
                <!-- <button type="submit" class="cs-btn btn-outline-secundary sm-btn">Actualizar</button> -->
                <label for="undefined">Cambiar imagen</label>
            </div>

            {!! Form::close() !!}

            <hr />

            {!! Form::model($item, ['route' => ["backoffice.company.update.rut", $item->id], 'class' =>
            'form-horizontal', "files" => true ]) !!}
            <div class="row">

                <div class="col-12">
                    
                    <!-- <div class="form-group">
                                            <label for="rut">Cargar RUT</label>
                                            <input type="file" class="form-control" id="rut" name="rut">
                                            @if ($errors->has('rut'))
                                                <span class="text-danger" role="alert">
                                                    <strong>{{ $errors->first('rut') }}</strong>
                                                </span>
                                            @endif
                                        </div> -->
                    <!-- <div class="cs-field field">
                                    <label for="rut">Cargar RUT</label>
                                        <div class="upload">
                                            <input name="rut" id="update-rut" type="file" class="upload" required accept="application/pdf, .doc,.docx,application/msword">
                                            <label>Cargar archivo</label>
                                        </div>
                                    </div> -->
                    <button class="cs-btn btn-blue ml-auto">Guardar</button>
                    <!-- <div class="form-group">
                                            <button type="submit" class="btn btn-primary">Cargar</button>
                                        </div> -->

                </div>
            </div>
            {{ Form::close() }}

        </div>
    </div>


</div>

@endsection
