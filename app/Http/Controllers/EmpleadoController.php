<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Empleado;
use Illuminate\Http\Request;

class EmpleadoController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('home', ['empleados' => Empleado::where('deleted_at', null)->get()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $moneda = $this->obtenerMoneda();

        return view('form-empleado', ['empleado' => new Empleado(), 'moneda' => $moneda['success'] ? $moneda['data'] : null]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validacionRequest($request);

        $empleado = Empleado::find($request->id);

        if (is_null($empleado)) {
            Empleado::create($request->all());

            $statusText = '¡Empleado guardado correctamente!';

        } else {
            $empleado->update($request->all());

            $statusText = '¡Empleado actualizado correctamente!';
        }

        return redirect('/empleados')->with('status', $statusText);
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Empleado $empleado)
    {
        $salarios = $this->salariosIncrementales($empleado);

        return view('detalle', ['empleado' => $empleado, 'salarioPesosXMes' => $salarios[0], 'salarioDolaresXMes' => $salarios[1]]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Empleado $empleado)
    {
        $moneda = $this->obtenerMoneda();

        return view('form-empleado', ['empleado' => $empleado, 'moneda' => $moneda['success'] ? $moneda['data'] : null]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Empleado $empleado)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Empleado $empleado)
    {
        $empleado->delete();

        return redirect('/empleados')->with('status', '¡Empleado eliminado correctamente!');

    }

    public function activarInactivar(Empleado $empleado)
    {

        if(!$empleado->activo){
             $empleado->update(['activo' => 1]);
             $status = '¡Empleado activado correctamente!';
        }else{
             $empleado->update(['activo' => 0]);
             $status = '¡Empleado inactivado correctamente!';
        }

        return redirect('/empleados')->with('status', $status);

    }

    public function salariosIncrementales($empleado)
    {
        $salarioPesos = $empleado->salarioPesos;
        $salarioDolares = $empleado->salarioDolares;

        $porcentajes = [0.02, 0.04, 0.06, 0.08, 0.10, 0.12];

        $meses = [1, 2, 3, 4, 5, 6];

        $salarioPesosXMes = array();
        $salarioDolaresXMes = array();

        foreach ($meses as $mes) {
            if ($mes === 1) {
                $totalSalarioPesos = $salarioPesos + $salarioPesos * $porcentajes[0];
                $totalSalarioDolares = $salarioDolares + $salarioDolares * $porcentajes[0];

                array_push($salarioPesosXMes, $totalSalarioPesos);
                array_push($salarioDolaresXMes, $totalSalarioDolares);
            }
            if ($mes === 2) {
                $totalSalarioPesos = $salarioPesos + $salarioPesos * $porcentajes[1];
                $totalSalarioDolares = $salarioDolares + $salarioDolares * $porcentajes[1];

                array_push($salarioPesosXMes, $totalSalarioPesos);
                array_push($salarioDolaresXMes, $totalSalarioDolares);
            }
            if ($mes === 3) {
                $totalSalarioPesos = $salarioPesos + $salarioPesos * $porcentajes[2];
                $totalSalarioDolares = $salarioDolares + $salarioDolares * $porcentajes[2];

                array_push($salarioPesosXMes, $totalSalarioPesos);
                array_push($salarioDolaresXMes, $totalSalarioDolares);
            }
            if ($mes === 4) {
                $totalSalarioPesos = $salarioPesos + $salarioPesos * $porcentajes[3];
                $totalSalarioDolares = $salarioDolares + $salarioDolares * $porcentajes[3];

                array_push($salarioPesosXMes, $totalSalarioPesos);
                array_push($salarioDolaresXMes, $totalSalarioDolares);
            }
            if ($mes === 5) {
                $totalSalarioPesos = $salarioPesos + $salarioPesos * $porcentajes[4];
                $totalSalarioDolares = $salarioDolares + $salarioDolares * $porcentajes[4];

                array_push($salarioPesosXMes, $totalSalarioPesos);
                array_push($salarioDolaresXMes, $totalSalarioDolares);
            }
            if ($mes === 6) {
                $totalSalarioPesos = $salarioPesos + $salarioPesos * $porcentajes[5];
                $totalSalarioDolares = $salarioDolares + $salarioDolares * $porcentajes[5];

                array_push($salarioPesosXMes, $totalSalarioPesos);
                array_push($salarioDolaresXMes, $totalSalarioDolares);
            }
        }

        return [$salarioPesosXMes, $salarioDolaresXMes];
    }

    public function validacionRequest(Request $request) {
        $request->validate([
            'codigo' => 'required'. (is_null($request->id) ? '|unique:empleados' : "|unique:empleados,codigo,{$request->id}"),
            'nombre' => 'required|regex:/^[a-zA-Z\s]+$/u',
            'salarioDolares' => 'required|numeric|min:1',
            'salarioPesos' => 'required|numeric|min:1',
            'direccion' => 'required',
            'estado' => 'required',
            'ciudad' => 'required',
            'celular' => 'required',
            'correo' => 'required'. (is_null($request->id) ? '|unique:empleados' : "|unique:empleados,correo,{$request->id}").'|regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
            'activo' => 'required'
        ],
        [
            'codigo.unique' => 'El código que ingreso ya se encuentra registrado',
            'nombre.regex' => 'El nombre debe ser con caracteres alfabéticos sin ñ y sin acentos',
            'salarioDolares.min' => 'El salario en Dolares debe ser mayor a 0',
            'salarioDolares.numeric' => 'El salario en Dolares debe ser númerico',
            'salarioPesos.min' => 'El salario en Pesos debe ser mayor a 0',
            'salarioPesos.numeric' => 'El salario en Pesos debe ser númerico',
            'correo.regex' => 'El formato del correo no es valido',
            'correo.unique' => 'El correo que ingreso ya se encuentra registrado'
        ]);
    }

    public function obtenerMoneda() {
        try {
            $url = 'https://www.banxico.org.mx/SieAPIRest/service/v1/series/SF43718/datos/oportuno';
            $token = '5d3b176fb75583c085f07de1239b849dc4d4833f60c965f60197f39ea5b08975';

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Bmx-Token: ' . $token,
                'Accept: application/json'
            ));
            /* curl_setopt($ch, CURLOPT_POSTFIELDS, $dataJson);
            curl_setopt($ch, CURLOPT_POST, true); */

            $response = curl_exec($ch);

            $data = json_decode($response, true);

            if ($data !== null && isset($data['bmx']['series'][0]['datos'][0]['dato'])) {
                $tipo_cambio = $data['bmx']['series'][0]['datos'][0]['dato'];

                $respuesta = array(
                    'success' => true,
                    'data' =>  $tipo_cambio,
                    'msg' => array(
                        'Se obtuvo el cambio de moneda correctamente'
                    )
                );
            } else {
                $respuesta = array(
                    'success' => false,
                    'msg' => array(
                        'Error al obtener el tipo de cambio'
                    )
                );
            }

            curl_close($ch);

        } catch (Exception $ex){
            $respuesta = array(
                'success' => false,
                'msg' => array(
                    'Ocurrio un error en el servidor, intentar mas tarde',
                    $ex->getMessage()
                )
            );
        }
        return $respuesta;
    }
}
