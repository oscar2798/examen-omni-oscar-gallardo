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
                                <canvas id="graficaPesosA" width="200" height="200"></canvas>
                            </div>
        
                            <div>
                                <canvas id="graficaDolaresA" width="200" height="200"></canvas>
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

    var salarioPesos = <?php echo $empleado->salarioPesos ?>;

    var aumento2 = Number(salarioPesos) * 0.02;
    var aumento4 = Number(salarioPesos) * 0.04;
    var aumento6 = Number(salarioPesos) * 0.06;
    var aumento8 = Number(salarioPesos) * 0.08;
    var aumento10 = Number(salarioPesos) * 0.10;
    var aumento12 = Number(salarioPesos) * 0.12;

    var primerMes = Number(salarioPesos) + aumento2;
    var segundoMes = Number(salarioPesos) + aumento4;
    var tercerMes = Number(salarioPesos) + aumento6;
    var cuartoMes = Number(salarioPesos) + aumento8;
    var quintoMes = Number(salarioPesos) + aumento10;
    var sextoMes = Number(salarioPesos) + aumento12;

    const ctx = document.getElementById('graficaPesos');
    
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['1er Mes - 2%', '2do Mes - 4%', '3er Mes - 6%', '4to Mes 8%', '5to Mes - 10%', '6to Mes - 12%'],
            datasets: [{
                label: 'Total MXN',
                data: [primerMes, segundoMes, tercerMes, cuartoMes, quintoMes, sextoMes],
                borderWidth: 5,
                borderColor: [
                    '#ff6384',
                    '#36a2eb',
                    '#cc65fe',
                    '#dd2727 ',
                    '#ffce56',
                    '#4bdd27'
                ]
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

    var salarioDolares = <?php echo $empleado->salarioDolares ?>;

    var aumentoD2 = Number(salarioDolares) * 0.02;
    var aumentoD4 = Number(salarioDolares) * 0.04;
    var aumentoD6 = Number(salarioDolares) * 0.06;
    var aumentoD8 = Number(salarioDolares) * 0.08;
    var aumentoD10 = Number(salarioDolares) * 0.10;
    var aumentoD12 = Number(salarioDolares) * 0.12;

    var primerMesD = Number(salarioDolares) + aumentoD2;
    var segundoMesD = Number(salarioDolares) + aumentoD4;
    var tercerMesD = Number(salarioDolares) + aumentoD6;
    var cuartoMesD = Number(salarioDolares) + aumentoD8;
    var quintoMesD = Number(salarioDolares) + aumentoD10;
    var sextoMesD = Number(salarioDolares) + aumentoD12;

    const ctx2 = document.getElementById('graficaDolares');
    
    new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: ['1er Mes - 2%', '2do Mes - 4%', '3er Mes - 6%', '4to Mes 8%', '5to Mes - 10%', '6to Mes - 12%'],
            datasets: [{
                label: 'Total USD',
                data: [primerMesD, segundoMesD, tercerMesD, cuartoMesD, quintoMesD, sextoMesD],
                borderWidth: 1,
                backgroundColor: [
                    '#ff6384',
                    '#36a2eb',
                    '#cc65fe',
                    '#dd2727 ',
                    '#ffce56',
                    '#4bdd27'
                ]
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

    var salarioPesosA = <?php echo $empleado->salarioPesos ?>;

    var aumento2A = Number(salarioPesosA) * 0.02;
    var aumento4A = Number(salarioPesosA) * 0.04;
    var aumento6A = Number(salarioPesosA) * 0.06;
    var aumento8A = Number(salarioPesosA) * 0.08;
    var aumento10A = Number(salarioPesosA) * 0.10;
    var aumento12A = Number(salarioPesosA) * 0.12;

    var primerMesA = Number(salarioPesosA) + aumento2A;
    var segundoMesA = primerMesA + aumento4A;
    var tercerMesA = segundoMesA + aumento6A;
    var cuartoMesA = tercerMesA + aumento8A;
    var quintoMesA = cuartoMesA + aumento10A;
    var sextoMesA = quintoMesA + aumento12A;

    const ctxA = document.getElementById('graficaPesosA');
    
    new Chart(ctxA, {
        type: 'line',
        data: {
            labels: ['1er Mes - 2%', '2do Mes - 4%', '3er Mes - 6%', '4to Mes 8%', '5to Mes - 10%', '6to Mes - 12%'],
            datasets: [{
                label: 'Total MXN',
                data: [primerMesA, segundoMesA, tercerMesA, cuartoMesA, quintoMesA, sextoMesA],
                borderWidth: 5,
                borderColor: [
                    '#ff6384',
                    '#36a2eb',
                    '#cc65fe',
                    '#dd2727 ',
                    '#ffce56',
                    '#4bdd27'
                ]
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

    var salarioDolaresA = <?php echo $empleado->salarioDolares ?>;

    var aumento2DA = Number(salarioDolaresA) * 0.02;
    var aumento4DA = Number(salarioDolaresA) * 0.04;
    var aumento6DA = Number(salarioDolaresA) * 0.06;
    var aumento8DA = Number(salarioDolaresA) * 0.08;
    var aumento10DA = Number(salarioDolaresA) * 0.10;
    var aumento12DA = Number(salarioDolaresA) * 0.12;

    var primerMesDA = Number(salarioDolaresA) + aumento2DA;
    var segundoMesDA = primerMesDA + aumento4DA;
    var tercerMesDA = segundoMesDA + aumento6DA;
    var cuartoMesDA = tercerMesDA + aumento8DA;
    var quintoMesDA = cuartoMesDA + aumento10DA;
    var sextoMesDA = quintoMesDA + aumento12DA;

    const ctx2DA = document.getElementById('graficaDolaresA');
    
    new Chart(ctx2DA, {
        type: 'bar',
        data: {
            labels: ['1er Mes - 2%', '2do Mes - 4%', '3er Mes - 6%', '4to Mes 8%', '5to Mes - 10%', '6to Mes - 12%'],
            datasets: [{
                label: 'Total USD',
                data: [primerMesDA, segundoMesDA, tercerMesDA, cuartoMesDA, quintoMesDA, sextoMesDA],
                borderWidth: 1,
                backgroundColor: [
                    '#ff6384',
                    '#36a2eb',
                    '#cc65fe',
                    '#dd2727 ',
                    '#ffce56',
                    '#4bdd27'
                ]
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