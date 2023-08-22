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
    @foreach($docs as $doc)
        <tr>
            <td>{{ $doc['agent_nit'] }} {{ $doc['agent_name'] }}</td>
            <td>{{ $doc['provider_nit'] }} {{ $doc['provider_name'] }}</td>
            <td>{{ $doc['doc'] }}</td>
            <td>{{ $doc['rate'] }}</td>
            <td>{{ $doc['base'] }}</td>
            <td>{{ $doc['tax'] }}</td>
            <td>{{ $doc['rate'] }}</td>
            <td>{{ $doc['year_process'] }}</td>
            <td>{{ $doc['period_process'] }}</td>
            <td>{{ $doc['concept'] }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
