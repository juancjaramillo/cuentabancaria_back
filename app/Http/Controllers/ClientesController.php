<?php

/*-------------------------------------------------------------------------------------------
    'Descripción            : Controlador para la autenticación y gestión de clientes en el sistema bancario.
    'Autor      	    	: Juan Jaramillo . Locatel - Colombia.
    'Fecha de Creación      : Marzo 25/2024
    'Fecha de Modificación  : Marzo 25/2024
    '-------------------------------------------------------------------------------------------
    '	Propósito :	Permite que los usuarios administradores inicien sesión en el sistema y realicen operaciones de gestión de clientes.
    '				      
    '				
    '	............................................................................
    '	Entradas :  id usuarios
    '	............................................................................
    '	Proceso  :	
    '............................................................................
    'Modifcaciones : -  Nuevas funciones
    'Consideraciones :Este controlador maneja las operaciones relacionadas con la autenticación de clientes, creación, edición, eliminación, y consultas de información de clientes.
*/

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Proceso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ClientesController extends Controller
{
    /**
     * Visualiza el formulario de inicio de sesión para el módulo de administración y gestión bancaria,
     * con validación de credenciales y manejo de errores.
     * 
     * Entradas: Correo electrónico y contraseña del usuario administrador.
     * Proceso: Validar las credenciales ingresadas y redirigir al usuario a la página de inicio.
     * Modificaciones: Mejorar diseño y presentación del formulario.
     */
    public function login(Request $request)
    {
        // Validar las credenciales
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        // Buscar al cliente por su correo electrónico
        $cliente = Cliente::where('email', $request->email)->first();

        if (!$cliente || !Hash::check($request->password, $cliente->password)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Consulta para obtener los datos de procesos del cliente
        $procesos = $cliente->procesos()->get();

        // Consulta para obtener el saldo total del cliente
        $saldoTotal = $cliente->saldo;
        return response()->json(['message' => 'Login exitoso', 'cliente' => $cliente, 'procesos' => $procesos, 'saldoTotal' => $saldoTotal], 200);
    }

    /**
     * Obtiene todos los clientes registrados en el sistema.
     */
    public function index()
    {
        return Cliente::all();
    }

    /**
     * Almacena un nuevo cliente en la base de datos.
     */
    public function store(Request $request)
    {
        // Crear un nuevo cliente
        $cliente = new Cliente();
        $cliente->nombre = $request->nombre;
        $cliente->apellido = $request->apellido;
        $cliente->documento = $request->documento;
        $cliente->numero_cuenta = $request->numero_cuenta;
        $cliente->foto = $request->foto;
        $cliente->direccion = $request->direccion;
        $cliente->email = $request->email;
        $cliente->password = Hash::make($request->password); // Hash del password
        $cliente->saldo = $request->saldo;
        $cliente->save();

        return response()->json([
            'data' => $cliente,
            'mensaje' => "Cliente creado correctamente.",
        ], 200);
    }

    /**
     * Muestra los detalles de un cliente específico.
     */
    public function show($id)
    {
        $cliente = Cliente::find($id);
        if (isset($cliente)) {
            return response()->json([
                'data' => $cliente,
                'mensaje' => "Cliente encontrado.",
            ]);
        } else {
            return response()->json([
                'error' => true,
                'mensaje' => "No existe Cliente.",
            ]);
        }
    }

    /**
     * Actualiza la información de un cliente existente.
     */
    public function update(Request $request, $id)
    {
        $cliente = Cliente::find($id);
        if (isset($cliente)) {
            $cliente->nombre = $request->nombre;
            $cliente->apellido = $request->apellido;
            $cliente->foto = $request->foto;
            $cliente->direccion = $request->direccion;
            if ($cliente->save()) {
                return response()->json([
                    'data' => $cliente,
                    'mensaje' => "Cliente actualizado.",
                ]);
            } else {
                return response()->json([
                    'error' => true,
                    'mensaje' => "No se logró actualizar cliente.",
                ]);
            };
        } else {
            return response()->json([
                'error' => true,
                'mensaje' => "No existe el cliente.",
            ]);
        };
    }

    /**
     * Elimina un cliente de la base de datos.
     */
    public function destroy($id)
    {
        $cliente = Cliente::find($id);
        if (isset($cliente)) {
            $res = Cliente::destroy($id);
            if ($res) {
                return response()->json([
                    'data' => $cliente,
                    'mensaje' => "Cliente Eliminado.",
                ]);
            } else {
                return response()->json([
                    'data' => $cliente,
                    'mensaje' => "No existe el cliente.",
                ]);
            }
        } else {
            return response()->json([
                'error' => true,
                'mensaje' => "No existe el cliente.",
            ]);
        };
    }

    /**
     * Realiza una consignación en la cuenta del cliente.
     */
    public function consignacion(Request $request)
    {
        // Obtener el ID del cliente autenticado
        $clienteId = $request->cliente_id;

        // Buscar el cliente en la base de datos
        $cliente = Cliente::find($clienteId);

        if (!$cliente) {
            return response()->json(['error' => 'Cliente no encontrado'], 404);
        }

        // Crear una instancia de Proceso
        $proceso = new Proceso();
        $proceso->valor = $request->valor;
        $proceso->tipo_transaccion = 1;

        // Guardar el proceso
        $cliente->procesos()->save($proceso);

        // Actualizar el saldo del cliente
        $cliente->saldo += $request->valor;
        $cliente->save();

        return response()->json(['message' => 'Consignación realizada con éxito', 'proceso' => $proceso], 200);
    }

    /**
     * Realiza un retiro de la cuenta del cliente.
     */
    public function retirar(Request $request)
    {
        $clienteId = $request->cliente_id;

        $cliente = Cliente::find($clienteId);

        if (!$cliente) {
            return response()->json(['error' => 'Cliente no encontrado'], 404);
        }

        if ($cliente->saldo < $request->valor) {
            return response()->json(['message' => 'Fondos insuficientes para realizar el retiro', 'error_tipo' => 'fondos_insuficientes'], 400);
        }

        $proceso = new Proceso();
        $proceso->valor = $request->valor;
        $proceso->tipo_transaccion = 0;

        $cliente->procesos()->save($proceso);

        $cliente->saldo -= $request->valor;
        $cliente->save();

        return response()->json(['message' => 'Retiro realizado con éxito', 'proceso' => $proceso], 200);
    }

    /**
     * Carga los datos de un cliente específico.
     */
    public function cargarDatos($id)
    {
        $cliente = Cliente::find($id);

        if (!$cliente) {
            return response()->json(['error' => 'Cliente no encontrado'], 404);
        }

        $procesos = $cliente->procesos()->get();

        $saldoTotal = $cliente->saldo;

        return response()->json(['cliente' => $cliente, 'procesos' => $procesos, 'saldoTotal' => $saldoTotal], 200);
    }
}
