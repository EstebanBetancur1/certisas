<div class="table-container">
    <table id="list-items" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th><input type="checkbox"></th>
                @foreach($fields as $i => $name)

                    @if($i==='status')
                        <th class="sm-col text-center">{{$name}}</th>
                    @elseif($i==='nit')
                        <th class="sm-col">{{$name}}</th>
                    @else
                        <th>{{$name}}</th>
                    @endif

                @endforeach
                <th class="text-center sm-col">Opciones</th>
            </tr>
        </thead>
        <tbody>
            @if($items->count())
                @foreach($items as $item)
                    <tr>
                        @foreach($fields as $i => $field)

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
                            @elseif($i === 'company_id')
                                <td>{!! $item->company->name !!}</td>
                            @else
                                <td>{!! $item->$i !!}</td>
                            @endif

                        @endforeach
                        <td class="text-center">
                            <!-- {!! Form::open(['route' => [$routeDestroy, $item->id]]) !!} -->
                            <!-- <div class="table-actions">
                                <a href="{{ route($routeEdit, ['id' => $item->id]) }}" class="">
                                    <i class="icon-edit"></i>
                                </a>
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Desea eliminar el registro?')" class="icon-trash"><i class="fa fa-trash"></i></button>
                            </div> -->
                            <div class="table-row-actions">
                                <a href="{{ route($routeEdit, ['id' => $item->id]) }}" class=""><i class="icon-edit"></i></a>
                                    <!-- @method('DELETE') -->
                                <!-- <button onclick="return confirm('Desea eliminar el registro?')"><i class="icon-trash"></i></button> -->
                                <button data-buttonmodal="delete-table-item" class="modal-btn"><i class="icon-trash"></i></button>
                            </div>
                            <!-- {!! Form::close() !!} -->
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>
