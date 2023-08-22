<table>
    <thead>
    <tr>
        <th>Emisor</th>
        <th>Receptor</th>
        <th>No. Document</th>
        <th>Fecha Documento</th>
        <th>Base</th>
        <th>Impuesto</th>
        <th>Tarifa</th>
        <th>Año Proceso</th>
        <th>Mes Proceso</th>
        <th>Concepto Retencion</th>
    </tr>
    </thead>
    <tbody>
    @foreach($items as $item)
        <tr>
            <td>{{ $emission->agent_nit }} {{ $emission->agent_name }}</td>
            <td>{{ $emission->provider_nit }} {{ $emission->provider_name }}</td>
            <td>{{ $item->doc }}</td>
            <td>{{ $item->date }}</td>
            <td>{{ $item->base }}</td>
            <td>{{ $item->tax }}</td>
            <td>{{ $item->rate }}</td>
            <td>{{ $item->year_process }}</td>
            <td>{{ $item->period_process }}</td>
            <td>{{ $item->concept }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
