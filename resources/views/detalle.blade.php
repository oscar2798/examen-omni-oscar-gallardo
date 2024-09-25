@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center"><h4>{{ __('Detalle del Empleado') }}</h4></div>
                <div class="card-body">
                    <ul class="list-group">
                        <li class="list-group-item active text-center" aria-current="true"><h4>{{ $empleado->nombre }}</h4></li>
                        <li class="list-group-item mt-4 text-center {{ $empleado->activo ? 'list-group-item-success' : 'list-group-item-danger' }} ">
                            {{$empleado->activo ? 'Activo' : 'Inactivo'}}
                        </li>
                        <li class="list-group-item">
                            <span class="fw-bold">Código:</span>
                            {{ $empleado->codigo }}
                        </li>
                        <li class="list-group-item">
                            <span class="fw-bold">Salario en dolares:</span> 
                            ${{ $empleado->salarioDolares }}
                        </li>
                        <li class="list-group-item">
                            <span class="fw-bold">Salario en pesos:</span> 
                            ${{ $empleado->salarioPesos }}
                        </li>
                        <li class="list-group-item">
                            <span class="fw-bold">Dirección:</span> 
                            {{ $empleado->direccion }}
                        </li>
                        <li class="list-group-item">
                            <span class="fw-bold">Estado:</span> 
                            {{ $empleado->estado }}
                        </li>
                        <li class="list-group-item">
                            <span class="fw-bold">Ciudad:</span> 
                            {{ $empleado->ciudad }}
                        </li>
                        <li class="list-group-item">
                            <span class="fw-bold">Celular:</span> 
                            {{ $empleado->celular }}
                        </li>
                        <li class="list-group-item">
                            <span class="fw-bold">Correo:</span> 
                            {{ $empleado->correo }}
                        </li>
                    </ul>

                    <button class="btn btn-sm btn-primary mt-5 mb-5" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="false" aria-controls="collapse1">
                        Graficas con salario incremental
                    </button>

                    <button class="btn btn-sm btn-secondary mt-5 mb-5" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
                        Graficas con salario acomulable
                    </button>
                      
                    <div class="collapse" id="collapse1">
                        <div class="card card-body">
                            <div>
                                <canvas id="graficaPesos" width="200" height="200"></canvas>
                            </div>
        
                            <div>
                                <canvas id="graficaDolares" width="200" height="200"></canvas>
                            </div>
                        </div>
                    </div>

                    <div class="collapse" id="collapse2">
                        <div class="card card-body">
                            <div>
                                <canvas id="graficaPesos2" width="200" height="200"></canvas>
                            </div>
        
                            <div>
                                <canvas id="graficaDolares2" width="200" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                   
                    <div class="d-grid gap-2">
                        <a href="{{url('empleados')}}" class="btn btn-outline-liht" type="button">
                            <i class="fa fa-arrow-left" aria-hidden="true"></i>
                            Regresar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

    const labels = ['1er Mes - 2%', '2do Mes - 4%', '3er Mes - 6%', '4to Mes 8%', '5to Mes - 10%', '6to Mes - 12%'];

    const borderColors = ['#ff6384', '#36a2eb', '#cc65fe', '#dd2727 ', '#ffce56', '#4bdd27'];

    const salariosPesos = @json($salarioPesosXMes);

    const salariosDolares = @json($salarioDolaresXMes);

    const ctx = document.getElementById('graficaPesos');
    
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Total MXN',
                data: salariosPesos,
                borderWidth: 5,
                borderColor: borderColors
            }]
        },
        options: {
            scales: {
                y: {
                    display: true
                }
            }
        }
    });

    const ctx2 = document.getElementById('graficaDolares');
    
    new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Total USD',
                data: salariosDolares,
                borderWidth: 1,
                backgroundColor: borderColors
            }]
        },
        options: {
            scales: {
                y: {
                    display: true
                }
            }
        }
    });

    // ACOMULABLE //

    const salarioPesosA = @json($empleado->salarioPesos);

    const aumento2A = Number(salarioPesosA) * 0.02;
    const aumento4A = Number(salarioPesosA) * 0.04;
    const aumento6A = Number(salarioPesosA) * 0.06;
    const aumento8A = Number(salarioPesosA) * 0.08;
    const aumento10A = Number(salarioPesosA) * 0.10;
    const aumento12A = Number(salarioPesosA) * 0.12;

    const primerMesA = Number(salarioPesosA) + aumento2A;
    const segundoMesA = primerMesA + aumento4A;
    const tercerMesA = segundoMesA + aumento6A;
    const cuartoMesA = tercerMesA + aumento8A;
    const quintoMesA = cuartoMesA + aumento10A;
    const sextoMesA = quintoMesA + aumento12A;

    const ctxA = document.getElementById('graficaPesos2');
    
    new Chart(ctxA, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Total MXN',
                data: [primerMesA, segundoMesA, tercerMesA, cuartoMesA, quintoMesA, sextoMesA],
                borderWidth: 5,
                borderColor: borderColors
            }]
        },
        options: {
            scales: {
                y: {
                    display: true
                }
            }
        }
    });

    const salarioDolaresA = @json($empleado->salarioDolares);

    const aumento2DA = Number(salarioDolaresA) * 0.02;
    const aumento4DA = Number(salarioDolaresA) * 0.04;
    const aumento6DA = Number(salarioDolaresA) * 0.06;
    const aumento8DA = Number(salarioDolaresA) * 0.08;
    const aumento10DA = Number(salarioDolaresA) * 0.10;
    const aumento12DA = Number(salarioDolaresA) * 0.12;

    const primerMesDA = Number(salarioDolaresA) + aumento2DA;
    const segundoMesDA = primerMesDA + aumento4DA;
    const tercerMesDA = segundoMesDA + aumento6DA;
    const cuartoMesDA = tercerMesDA + aumento8DA;
    const quintoMesDA = cuartoMesDA + aumento10DA;
    const sextoMesDA = quintoMesDA + aumento12DA;

    const ctx2DA = document.getElementById('graficaDolares2');
    
    new Chart(ctx2DA, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Total USD',
                data: [primerMesDA, segundoMesDA, tercerMesDA, cuartoMesDA, quintoMesDA, sextoMesDA],
                borderWidth: 1,
                backgroundColor: borderColors
            }]
        },
        options: {
            scales: {
                y: {
                    display: true
                }
            }
        }
    });
</script>
@endsection