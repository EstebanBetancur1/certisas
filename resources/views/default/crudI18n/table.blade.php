<table id="list-items" class="table table-bordered table-striped">
    <thead>
    <tr>
        @foreach($fields as $i => $field)

            @if(is_array($field))
                @foreach($field as $_i => $_field)
                    <th>{!! $_field !!}</th>
                @endforeach
            @else
                @if($i === 'status')
                    <th class="text-center" width="15%">{!! $field !!}</th>
                @else
                    <th>{!! $field !!}</th>
                @endif
            @endif

        @endforeach
        <th class="text-center" width="15%">Opciones</th>
    </tr>
    </thead>
    <tbody>
        @if($items->count())
            @foreach($items as $item)
                <tr>
                    @foreach($fields as $i => $field)

                        @if(is_array($field))
                            @foreach($field as $_i => $_field)
                                <td>{!! $item->versions->where("lang", $i)->first()->$_i !!}</td>
                            @endforeach
                        @else
                            @if($i === 'status')
                                <td class="text-center">

                                    <div class="btn-group" role="group">
                                        <button class="btn btn-sm @if((int)$item->$i === 0)  btn-danger @elseif((int)$item->$i === 1) btn-success @else btn-default  @endif btn-xs dropdown-toggle" type="button" id="dropdownMenu-{{ $i }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                            {{ (array_key_exists($item->$i, $statusOptions)) ? $statusOptions[$item->$i] : $field }}
                                            <span class="caret"></span>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop-{{ $i }}">
                                            @foreach($statusOptions as $o => $option)
                                                <a class="dropdown-item" href="{{ route($routeStatus, ['id' => $item->id, 'status' => $o]) }}">{{ $option }}</a>
                                            @endforeach
                                        </div>
                                    </div>

                                </td>
                            @else
                                <td>{!! $item->$i !!}</td>
                            @endif
                        @endif

                    @endforeach

                    <td class="text-center">
                        {!! Form::open(['route' => [$routeDestroy, $item->id]]) !!}
                        <div class="btn-group">
                            <a href="{{ route($routeEdit, ['id' => $item->id]) }}" class="btn btn-secondary btn-sm"><i class="fa fa-edit"></i></a>
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Desea eliminar el registro?')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                        </div>
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="{{ count($fields)+1 }}">
                    No se encontraron registros
                </td>
            </tr>
        @endif
    </tbody>
</table>