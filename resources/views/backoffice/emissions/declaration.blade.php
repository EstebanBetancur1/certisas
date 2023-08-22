@extends('layouts.pdf')

@section('css')
    <style>
    body{
    	font-family: 'sans-serif';
    	font-size: 11px;
    }

	h1 {
	    color: #ccff12;
	}

	h3{
		margin-bottom: 5px;
		font-size: 12px;
		text-transform: uppercase; 
	}

	table{
		clear: both;
		width: 100%;
		border-collapse: collapse!important;
		border-spacing:0; 
		border: 0;
		margin-bottom: 15px;
	}

	table th{
		font-size: 12px!important;
	}

	table td{
		vertical-align: top;
		padding-top: 3px;
		font-size: 11px!important;
		padding-bottom: 3px;
	}

	table.table-fill tr th{
		background-color: #f2f2f2;
		padding-top: 5px;
		padding-bottom: 5px;
		border: 1px solid #000;
	}

	table.table-fill tr td{
		padding: 5px;
		border: 1px solid #000;
	}

	.img-logo{
		width: 100px;
	}

	.text-center{
		text-align: center!important;
	}

	.text-left{
		text-align: left!important;
	}

	.text-right{
		text-align: right!important;
	}

	</style>
@endsection

@section('content')

	<table>
		
		<tr>
			
			<td width="55%">
				@if($emission->company && $emission->company->logo)
					<img src="upload/companies/{{ $emission->company->logo }}" class="img-logo"/>
				@endif
			</td>

			<td colspan="2">

				<div class="text-right" style="font-size: 10px; margin-top: 10px;">

					<h3 style="margin: 0px; padding: 0px;font-size: 13px!important;">
						@if((int)$emission->type === 1)
							CERTIFICADO DE RETENCI&Oacute;N A T&Iacute;TULO DE VENTAS
						@elseif((int)$emission->type === 2)
							CERTIFICADO DE RETENCI&Oacute;N A T&Iacute;TULO DE RENTA
						@elseif((int)$emission->type === 3)
							CERTIFICADO DE INDUSTRIA Y COMERCIO
						@endif
					</h3>

					<h3 style="margin: 0px; padding: 0px;">
						AÑO GRAVABLE {{ $emission->year }}
					</h3>

					<p style="margin: 0px; padding: 0px;">
						Periodo de Retención: 

						@if((int)$emission->period_type === 1)
							Mensual {{ $emission->period }}
						@endif

						@if((int)$emission->period_type === 1 || (int)$emission->period_type === 2)
							({{ getPeriod($emission->period_type, $emission->period) }})
						@endif

						@if((int)$emission->period_type === 3)
							(Anual)
						@endif

					</p>
				</div>
			</td>
		</tr>

		<tr>
			<td width="55%">
				<h3>AGENTE RETENEDOR</h3>
			</td>
			<td width="35%"></td>
			<td width="10%"></td>
		</tr>

		<tr>
			<td width="55%">
				<strong>Razón Social:</strong> {!! $emission->agent_name !!}
			</td>
			<td width="35%">
				<strong>NIT:</strong> {!! $emission->agent_nit !!}
			</td>
			<td width="10%">
				<strong>DV:</strong> {!! $emission->agent_dv !!}
			</td>
		</tr>

		<tr>
			<td width="55%">
				<strong>Dirección:</strong> {!! $emission->agent_address !!}
			</td>
			<td width="35%">
				<strong>Tel&eacute;fono:</strong> {!! $emission->agent_phone !!}
			</td>
			<td width="10%"></td>
		</tr>

		<tr>
			<td width="55%">
				<strong>Ciudad:</strong> {!! getCityString($emission->agent_city) !!}
			</td>
			<td width="35%"></td>
			<td width="10%"></td>
		</tr>
	</table>

	<table>

		<tr>
			<td width="55%">
				<h3>RETENCI&Oacute;N PRACTICADA A:</h3>
			</td>
			<td width="35%"></td>
			<td width="10%"></td>
		</tr>

		<tr>
			<td>
				<strong>Razón Social:</strong> {!! $emission->provider_name !!}
			</td>
			<td>
				<strong>NIT:</strong> {!! $emission->provider_nit !!}
			</td>
			<td>
				<strong>DV:</strong> {!! $emission->provider_dv !!}
			</td>
		</tr>

		<tr>
			<td>
				<strong>Dirección:</strong> {!! $emission->provider_address !!}
			</td>
			<td>
				<strong>Tel&eacute;fono:</strong> {!! $emission->provider_phone !!}
			</td>
			<td></td>
		</tr>

		<tr>
			<td>
				<strong>Ciudad:</strong> {!! getCityString($emission->provider_city) !!}
			</td>
			<td></td>
			<td></td>
		</tr>

	</table>

	<h3 style="margin-top: 25px;">CONCEPTO DE LA RETENCION:</h3>

	<table class="table-fill">
		
		<tr>
			<th align="center">Concepto</th>
			<th align="center" width="27%">Monto Total de la Operación</th>

			@if((int)$emission->type === 1)
				<th align="center" width="22%">Monto de Iva Generado </th>
			@endif

			<th align="center" width="15%">Valor Retenido</th>
		</tr>

		@php
			$concepts = json_decode($emission->concepts)
		@endphp

		@foreach($concepts as $concept)
		<tr>
			<td>{!! $concept->name !!}</td>
			<td align="right">{!! priceFormat($concept->transactionAmount) !!}</td>

			@if((int)$emission->type === 1)
				<td align="right">{!! priceFormat($concept->taxAmount) !!}</td>
			@endif

			<td align="right">{!! priceFormat($concept->amountWithheld) !!}</td>
		</tr>
		@endforeach

	</table>

	<p>Valor Total Retenido: ${!! priceFormat($emission->total_amount_withheld) !!} ({{ ucfirst(convertAmountToText(priceFormat($emission->total_amount_withheld))) }} pesos)</p>

	@if((int)$emission->type === 3)
		<p>
			<strong>Ciudad donde se practicó la retención:</strong> {{ $emission->city->code }} - {!! getCityById($emission->city_id) !!}
		</p>
	@endif

	@if(isset($declarations) && $declarations->count())
		<h3 style="margin-top: 25px;">DOCUMENTOS DE PAGO:</h3>

		<table class="table-fill">
			
			@if((int)$emission->type === 1 || (int)$emission->type === 2)
				<tr>
					<th align="center" width="15%">Mes</th>
					<th align="center" width="20%">350 - Declaración de Rete Fuente</th>
					<th align="center" width="20%">490 - Recibo oficial de pago</th>
					<th align="center" width="15%">Fecha de pago</th>
					<th align="center">Banco</th>
				</tr>
			@elseif((int)$emission->type === 3)
				<tr>
					<th align="center" width="15%">Mes</th>
					<th align="center" width="20%">Declaración</th>
					<th align="center" width="20%">Municipio</th>
					<th align="center" width="15%">Fecha de pago</th>
					<th align="center">Banco</th>
				</tr>
			@endif

			@foreach($declarations as $declaration)
				@if((int)$emission->type === 1 || (int)$emission->type === 2)

					<tr>
						<td align="center">{{ getPeriod(1, $declaration->period) }}</td>
						<td align="center">{{ $declaration->form }}</td>
						<td align="center">{{ $declaration->nro }}</td>
						<td align="center">{{ $declaration->date_payment }}</td>
						<td align="center">{{ $declaration->bank->name }}</td>
					</tr>

				@elseif((int)$emission->type === 3)

					<tr>
						<td align="center">{{ getPeriod(1, $declaration->period) }}</td>
						<td align="center">{{ $declaration->declaration }}</td>
						<td align="center">{{ $declaration->municipality->name }}</td>
						<td align="center">{{ $declaration->date_payment }}</td>
						<td align="center">{{ $declaration->bank->name }}</td>
					</tr>

				@endif

			@endforeach

		</table>
	@endif

	<p style="text-align: justify; font-style: italic;">
		La retención efectuada fue debidamente consignada dentro del término legal a favor de

		@if((int)$emission->type === 1 | (int)$emission->type === 2)
			<strong> DIAN - {{ getSectionalString($emission->agent_sectional) }}</strong>.
		@else
			- <strong>{{ getEntityByCityId($emission->city_id) }}</strong>.
		@endif

		El presente certificado emitido el <strong>{{ $emission->date_emission }}</strong>, se expide en concordancia con las disposiciones legales contenidas en el artículo 381 del Estatuto Tributario.
	</p>

	<p style="text-align: center;">
		IMPRESO POR COMPUTADOR, NO REQUIERE FIRMA AUTOGRAFA. ART. 10 DR. 836/91
	</p>

@endsection