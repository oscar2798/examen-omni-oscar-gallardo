@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                @if ($moneda === null)
                    <div class="alert alert-danger" role="alert">
                        {{ __('Error al obtener el tipo de cambio') }}
                    </div>
                @endif

                @if(count($errors) > 0)
                    <div class="alert alert-warning">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li> {{$error}}</li>
                                
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="card-header text-center"><h4>{{ __($empleado->id === null ? 'Agregar Empleado' : 'Editar Empleado') }}</h4></div>

                <div class="card-body">
                    <form method="POST" action="{{ route('empleados.store') }}">
                        @csrf

                        <div class="row mb-3">

                            <input type="hidden" name="id" value="{{$empleado->id}}" />

                            <div class="col-md-6">
                                <label for="codigo">{{ __('Código') }}</label>

                                <input id="codigo" type="text" class="form-control @error('codigo') is-invalid @enderror" name="codigo" value="{{ old('codigo', $empleado->codigo) }}" required>

                                @error('codigo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="nombre">{{ __('Nombre') }}</label>

                                <input id="nombre" type="text" class="form-control @error('nombre') is-invalid @enderror" name="nombre" value="{{ old('nombre', $empleado->nombre) }}" required>

                                @error('nombre')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="salarioDolares">{{ __('Salario Dolares') }}</label>

                                <input 
                                    id="salarioDolares" 
                                    type="number" class="form-control 
                                    @error('salarioDolares') is-invalid @enderror" 
                                    name="salarioDolares" 
                                    onchange="convertirDolares(this.value, {{$moneda}})" 
                                    value="{{ old('salarioDolares', $empleado->salarioDolares)) }}"
                                    min="1"
                                    required
                                >

                                @error('salarioDolares')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            

                            <div class="col-md-6">
                                <label for="salarioPesos">{{ __('Salario Pesos') }}</label>

                                <input 
                                    id="salarioPesos" 
                                    type="number" 
                                    class="form-control 
                                    @error('salarioPesos') is-invalid @enderror" 
                                    name="salarioPesos" 
                                    value="{{ old('salarioPesos', $empleado->salarioPesos) }}" 
                                    min="1"
                                    required
                                >

                                @error('salarioPesos')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="direccion">{{ __('Dirección') }}</label>

                                <input id="direccion" type="text" class="form-control @error('direccion') is-invalid @enderror" name="direccion" value="{{ old('direccion', $empleado->direccion) }}" required>

                                @error('direccion')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="estado">{{ __('Estado') }}</label>

                                <input id="estado" type="text" class="form-control @error('estado') is-invalid @enderror" name="estado" value="{{ old('estado', $empleado->estado) }}" required>

                                @error('estado')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="ciudad">{{ __('Ciudad') }}</label>

                                <input id="ciudad" type="text" class="form-control @error('ciudad') is-invalid @enderror" name="ciudad" value="{{ old('ciudad', $empleado->ciudad) }}" required>

                                @error('ciudad')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="celular">{{ __('Celular') }}</label>

                                <input id="celular" type="tel" class="form-control @error('celular') is-invalid @enderror" name="celular" value="{{ old('celular', $empleado->celular) }}" required>

                                @error('celular')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="correo">{{ __('Correo') }}</label>

                                <input id="correo" type="email" class="form-control @error('correo') is-invalid @enderror" name="correo" value="{{ old('correo', $empleado->correo) }}" required>

                                @error('correo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="activo">{{ __('Activo') }}</label>

                                <select id="activo" class="form-select @error('activo') is-invalid @enderror" name="activo" aria-label="Activo" required>
                                    <option value="">Seleccione una opción</option>
                                    <option value="1" @if ($empleado->activo === 1) selected @endif>Si</option>
                                    <option value="0" @if ($empleado->activo === 0) selected @endif>No</option>
                                  </select>

                                @error('activo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0 mt-5">
                            <div class="text-center">
                                <button type="submit" class="btn btn-success">
                                    {{ __('Guardar') }}
                                </button>

                                <a href="{{ url('empleados') }}" class="btn btn-danger">Cancelar</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function convertirDolares (valor, moneda) {
        var total = 0;
        
        total = parseFloat(valor * moneda).toFixed(2);

        document.getElementById('salarioPesos').value = total;
    }
</script>
@endsection