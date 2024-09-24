@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
             @endif

            <div class="card">
                <div class="card-header">{{ __('Lista de Empleados') }}</div>

                <div class="card-body">

                    <a href="{{ url('empleados/create') }}"  class="btn btn-success mb-4">Agregar</a>

                    @if (count($empleados) === 0)
                        <div class="alert alert-warning" role="alert">
                            No se encontraron empleados
                        </div>
                    @else

                        <table class="table table-light text-center">
                            <thead>
                                <tr>
                                <th scope="col">Código</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Salario Dolares</th>
                                <th scope="col">Salario Pesos</th>
                                <th scope="col">Correo</th>
                                <th scope="col">Estatus</th>
                                <th scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($empleados as $empleado)
                                <tr>
                                    <td>{{ $empleado->codigo }}</td>
                                    <td>{{ $empleado->nombre }}</td>
                                    <td>{{ $empleado->salarioDolares }}</td>
                                    <td>{{ $empleado->salarioPesos }}</td>
                                    <td>{{ $empleado->correo }}</td>
                                    <td>{{ $empleado->activo ? 'Activo' : 'Inactivo' }}</td>
                                    <td>
                                                                                    
                                        <a href="{{ route('empleados.show', $empleado->id) }}" type="button" class="btn btn-secondary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Ver detalle">
                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                        </a>
                                        
                                        <a href="{{ route('empleados.edit', $empleado->id) }}" type="button" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Editar">
                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                        </a>

                                        <a href="{{ route('empleados.activarInactivar', $empleado->id) }}" type="button" 
                                            @class(['btn', 'btn-warning' => $empleado->activo == 1, 'btn-success' => $empleado->activo == 0])
                                            data-bs-toggle="tooltip" data-bs-placement="bottom" title="{{$empleado->activo == 0 ? 'Activar' : 'Inactivar'}}"
                                        > 
                                            {{-- {{$empleado->activo == 1 ? 'Inactivar': 'Activar'}}  --}}
                                            
                                            <i @class(['fa', 'fa-times' => $empleado->activo == 1, 'fa-check' => $empleado->activo == 0]) aria-hidden="true"></i>
                                        </a>

                                        <button type="button" class="btn btn-danger" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Eliminar" data-bs-toggle="modal" data-bs-target="#modalEmpleado{{$empleado->id}}">
                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                        </button>

                                        <div class="modal fade" id="modalEmpleado{{$empleado->id}}" tabindex="-1" aria-labelledby="#modalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content" style="color: #ffffffff;">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="modalLabel">Eliminar empleado</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        ¿Estás seguro de eliminar el empleado?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">No</button>
                                                        <form action="{{ route('empleados.destroy', $empleado->id) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-success" >Si</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
