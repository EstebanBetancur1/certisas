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
                <h4 class="page-title">Información empresa</h4>
                <!-- <label class="cs-btn btn-outline-secundary sm-btn mb-0" for="update-rut">Nuevo Rut</label> -->
            </div>

        </div>
        <div class="col-md-8 col-xl-5 col-xxl-6 table-col">
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

               {!! Form::model($item, ['route' => ["backoffice.company.update.rut", $item->id], 'class' =>'form-horizontal page-actions', "files" => true ]) !!}
               <div class="row">
                   <div class="col-12">

                       <div class="input-group mb-3">

                           <label class="cs-btn btn-outline-secundary sm-btn mb-0" for="update-rut">Subir nuevo RUT</label>
                           <input name="rut" id="update-rut" type="file" class="rut-upload" required accept="application/pdf, .doc,.docx,application/msword">

                           <div class="input-group-append">
                               <button type="submit" class="btn btn-primary btn-sm">Actualizar</button>
                           </div>

                       </div>

                   </div>

               </div>
               {{ Form::close() }}

           </div>

        </div>
        <div class="col-md-12 col-xl-4 col-xxl-3 data-col">
           <div class="row">
            <div class="col-md-6 col-lg-6 col-xl-12">
                <h4 class="page-subtitle">Actividad reciente</h4>
                <div class="activity-container">
                    <div class="recent-item">
                        <div class="icon-state">
                            <svg height="40" width="40">
                                <circle cx="20" cy="20" r="18" stroke="black" stroke-width="2" fill="#fff" />
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
                                <circle cx="20" cy="20" r="18" stroke="black" stroke-width="2" fill="#fff" />
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
                                <circle cx="20" cy="20" r="18" stroke="black" stroke-width="2" fill="#fff" />
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
                                <circle cx="20" cy="20" r="18" stroke="black" stroke-width="2" fill="#fff" />
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
                                <circle cx="20" cy="20" r="18" stroke="black" stroke-width="2" fill="#fff" />
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

            <div class="col-md-6 col-lg-6 col-xl-12">
                <h4 class="page-subtitle">Fechas importantes</h4>
                <div class="activity-container mb-0">
                   <div class="date-item">
                        <div class="date">
                            <span>Feb</span>
                            <p>15</p>
                        </div>
                        <div class="date-info">
                            <p>Delaración de renta</p>
                            <p>Generar certificado</p>
                        </div>
                   </div>
                   <div class="date-item">
                        <div class="date">
                            <span>Feb</span>
                            <p>15</p>
                        </div>
                        <div class="date-info">
                            <p>Delaración de renta</p>
                            <p>Generar certificado</p>
                        </div>
                   </div>
                   <div class="date-item">
                        <div class="date">
                            <span>Feb</span>
                            <p>15</p>
                        </div>
                        <div class="date-info">
                            <p>Delaración de renta</p>
                            <p>Generar certificado</p>
                        </div>
                   </div>
                   <div class="date-item">
                        <div class="date">
                            <span>Feb</span>
                            <p>15</p>
                        </div>
                        <div class="date-info">
                            <p>Delaración de renta</p>
                            <p>Generar certificado</p>
                        </div>
                   </div>
                   <div class="date-item">
                        <div class="date">
                            <span>Feb</span>
                            <p>15</p>
                        </div>
                        <div class="date-info">
                            <p>Delaración de renta</p>
                            <p>Generar certificado</p>
                        </div>
                   </div>
                </div>
            </div>
          </div>
        </div>
        <div class="col-md-4 col-xl-3 col-xxl-3 logo-col">

            <h4 class="page-subtitle">Logo de la empresa</h4>

            {!! Form::open(['route'=>'backoffice.company.updateLogo', 'files' => true, 'class' => 'brand-logo-container',]) !!}

                @if($logo)
                    <div class="preview-image brand-logo img-contain" data-field="image" data-image="upload/companies/{{ $logo }}"></div>
                @else
                    <div class="preview-image brand-logo img-contain" data-field="image"></div>
                @endif

                <div class="row">
                    <div class="col-12 text-center">
                        <button type="submit" class="cs-btn btn-blue" style="margin: 0 auto;">Guardar</button>
                    </div>
                </div>

            {!! Form::close() !!}

            <!--
            {!! Form::model($item, ['route' => ["backoffice.company.update.rut", $item->id], 'class' =>'form-horizontal page-actions', "files" => true ]) !!}
            <div class="row">
                <div class="col-12">
                    <button class="cs-btn btn-blue ml-auto">Guardar cambios</button>
                </div>
            </div>
            {{ Form::close() }}
            -->

        </div>
    </div>


</div>

@endsection
