extends('layouts.email')

@section('content')
    <section class="row">
        <div class="pull-left">
            Hola, {!! $order->user->full_name !!}</strong>

            <table>
            	<tr>
            		<td style="vertical-align: top">
            			<h4>Datos del cliente</h4>
                        <div><strong>Cliente:</strong> {!! $order->user->full_name !!}</div>
                        <div><strong>E-mail:</strong> {!! $order->user->email !!}</div>
            		</td>
            		<td style="vertical-align: top">
            			<h4>Datos del pedido</h4>
                        <div><strong>Pedido #:</strong> {!! $order->id !!}</div>
                        <div><strong>Total:</strong> {!! priceFormat($order->total) !!}</div>

                        @if($order->delivery_date)
                        <div><strong>Fecha entrega:</strong> {!! $order->delivery_date !!}</div>
                        @endif

                        @if($order->address_id)
                        <div><strong>Direcci&oacute;n entrega:</strong> {!! $order->address->title !!}, {!! $order->address->line_1 !!}, {!! $order->address->line_2 !!}, Tlf: {!! $order->address->phone !!}, C&oacute;digo Postal: {!! $order->address->postcode !!}</div>
                        @endif

                        <div><strong>Estatus:</strong> 

                            @if((int)$order->status === 1)
                                <span class="badge badge-success"><i class="fa fa-check" aria-hidden="true"></i> Entregado</span>
                            @elseif((int)$order->status === 2)
                                <span class="badge badge-warning"><i class="fa fa-clock-o" aria-hidden="true"></i> En proceso</span>
                            @elseif((int)$order->status === 3)
                                <span class="badge badge-primary"><i class="fa fa-truck" aria-hidden="true"></i> Enviado </span>
                            @else
                                -
                            @endif
                            
                        </div>
            		</td>
            	</tr>
           	</table>

           	<hr />

            @php
                $i_foods = 0;
                $totalFoods = 0;

                $i_products = 1;
                $totalProducts = 0;
            @endphp

            @php
                $items = getOrderItems($order);
            @endphp

            @if(array_key_exists('foods', $items) && count($items["foods"]))

                <h4>Comidas</h4>

                @foreach($items["foods"] as $addresses)

                    <table id="list-items" class="table table-bordered">
                        <thead style="background-color:#f1f1f1;">
                        <tr>
                            <th colspan="7" style="text-align: left;">
                                <small><strong style="font-weight: bold;">{!! $addresses["title"] !!}:</strong> {!! $addresses["line_1"] !!}, {!! $addresses["line_2"] !!}, Tlf: {!! $addresses["phone"] !!}, , C&oacute;digo Postal: {!! $addresses["postcode"] !!}</small>
                            </th>
                        </tr>
                        <tr>
                            <th width="4%">#</th>
                            <th>Comida</th>
                            <th class="text-center" width="12%">Fecha</th>
                            <th class="text-center" width="12%">Estado</th>
                            <th class="text-center" width="12%">Cantidad</th>
                            <th class="text-right" width="12%">Precio</th>
                            <th class="text-right" width="12%">Total</th>
                        </tr>
                        </thead>
                        <tbody>

                            @foreach($addresses["orderItems"] as $orderItem)

                                @php
                                    $i_foods++;
                                    $totalFoods += $orderItem->price*$orderItem->qty;
                                @endphp

                                <tr>
                                    <td>{{ $i_foods }}</td>
                                    <td>

                                        {!! $orderItem->food->title !!}

                                    </td>
                                    <td class="text-center align-middle">{{ $orderItem->delivery_date }}</td>
                                    <td class="text-center align-middle">
                                        @if((int)$orderItem->status === 1)
                                            <span class="badge badge-success"><i class="fa fa-check" aria-hidden="true"></i> Entregado</span>
                                        @elseif((int)$orderItem->status === 2)
                                            <span class="badge badge-warning"><i class="fa fa-clock-o" aria-hidden="true"></i> En proceso</span>
                                        @elseif((int)$orderItem->status === 3)
                                            <span class="badge badge-primary"><i class="fa fa-truck" aria-hidden="true"></i> Enviado </span>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="text-center align-middle">{{ $orderItem->qty }}</td>
                                    <td class="text-right align-middle">{{ priceFormat($orderItem->price) }}</td>
                                    <td class="text-right align-middle">{{ priceFormat($orderItem->price*$orderItem->qty) }}</td>
                                </tr>

                            @endforeach

                            <tr>
                                <td colspan="4"></td>
                                <td class="text-center">{{ $i_foods }}</td>
                                <td class="text-right"> </td>
                                <td class="text-right">{{ priceFormat($totalFoods) }}</td>
                            </td>

                        </tbody>

                    </table>

                @endforeach
                    
            @endif

            @if(array_key_exists('products', $items) && count($items["products"]))

                <h4>Productos</h4>

                <table id="list-items" class="table table-bordered">
                    <thead style="background-color:#f1f1f1;">
                    <tr>
                        <th width="4%">#</th>
                        <th>Producto</th>
                        <th class="text-center" width="12%">Estado</th>
                        <th class="text-center" width="12%">Cantidad</th>
                        <th class="text-right" width="12%">Precio</th>
                        <th class="text-right" width="12%">Total</th>
                    </tr>
                    </thead>
                    <tbody>

                        @foreach($items["products"] as $orderItem)

                            @php
                                $i_products++;
                                $totalProducts += $orderItem->price*$orderItem->qty;
                            @endphp

                            <tr>
                                <td>{{ $i_products }}</td>
                                <td>

                                    {!! $orderItem->product->title !!}

                                </td>
                                <td class="text-center align-middle">
                                    @if((int)$orderItem->status === 1)
                                        <span class="badge badge-success"><i class="fa fa-check" aria-hidden="true"></i> Entregado</span>
                                    @elseif((int)$orderItem->status === 2)
                                        <span class="badge badge-warning"><i class="fa fa-clock-o" aria-hidden="true"></i> En proceso</span>
                                    @elseif((int)$orderItem->status === 3)
                                        <span class="badge badge-primary"><i class="fa fa-truck" aria-hidden="true"></i> Enviado </span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="text-center align-middle">{{ $orderItem->qty }}</td>
                                <td class="text-right align-middle">{{ priceFormat($orderItem->price) }}</td>
                                <td class="text-right align-middle">{{ priceFormat($orderItem->price*$orderItem->qty) }}</td>
                            </tr>

                        @endforeach

                        <tr>
                            <td colspan="3"></td>
                            <td class="text-center">{{ $i_products }}</td>
                            <td class="text-right"> </td>
                            <td class="text-right">{{ priceFormat($totalProducts) }}</td>
                        </td>

                    </tbody>

                </table>
                    
            @endif

            <h4>Pagos realizados sobre el pedido</h4>

            <table id="list-items" class="table table-bordered">
                <thead style="background-color:#f1f1f1;">
                <tr>
                    <th width="4%">#</th>
                    <th>Tipo de pago</th>
                    <th class="text-right" width="12%">Monto</th>
                    <th class="text-center" width="12%">Estatus</th>
                </tr>
                </thead>
                <tbody>

                    @foreach($order->payments as $payment)

                        <tr>
                            <td>{!! $payment->id !!}</td>
                            <td>

                                {!! $payment->method->title !!}

                                @if($payment->method->label === "stripe" && $payment->stripe_receipt_url)
                                    <a href="{{ $payment->stripe_receipt_url }}" target="_blank">Ver recibo</a>
                                @endif

                            </td>
                            <td class="text-right">{{ priceFormat($payment->amount) }}</td>
                            <td class="text-center">
                                @if((int)$payment->status === 1)
                                    <span class="badge badge-success">Realizado</span>
                                @else
                                    <span class="badge badge-warning">Pendiente</span>
                                @endif
                            </td>
                        </tr>

                    @endforeach

                </tbody>

            </table>

            <p><a href="{{ route("frontoffice.home.index") }}">Volver a la tienda</a></p>
        </div>
    </section>
@endsection