<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Citas; // Asegúrate de que el nombre del modelo sea correcto
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CitasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $citas = Citas::all(); // Asegúrate de que el nombre del modelo sea correcto
        return response()->json($citas, 200);
        
        if ($citas->count() == 0) return response()->json([], 204);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'tipo_documento' => 'required|in:cc,ti,cxe,pasaporte',
            'numero_documento' => 'required|string|max:20|unique:citas,numero_documento',
            'tipo_servicio' => 'required|in:cambio de aceite,revision general,mantenimiento general',
            'dia' => 'required|date|after_or_equal:today',
            'hora' => 'required|date_format:H:i',
        ]);

        $cita = Citas::create($request->all()); // Asegúrate de que el nombre del modelo sea correcto
        return response()->json([
            'message' => 'Cita creada exitosamente',
            'data' => $cita,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $cita = Citas::find($id); // Asegúrate de que el nombre del modelo sea correcto
        if (!$cita) {
            return response()->json(['message' => 'Cita no encontrada'], 404);
        }
        return response()->json($cita, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $cita = Citas::find($id); // Asegúrate de que el nombre del modelo sea correcto
        if (!$cita) {
            return response()->json(['message' => 'Cita no encontrada'], 404);
        }

        $request->validate([
            'nombre' => 'sometimes|string|max:255',
            'apellido' => 'sometimes|string|max:255',
            'tipo_documento' => 'sometimes|in:cc,ti,cxe,pasaporte',
            'numero_documento' => 'sometimes|string|max:20|unique:citas,numero_documento,' . $cita->id,
            'tipo_servicio' => 'sometimes|in:cambio de aceite,revision general,mantenimiento general',
            'dia' => 'sometimes|date|after_or_equal:today',
            'hora' => 'sometimes|date_format:H:i',
        ]);

        $cita->fill($request->all());
        $cita->save(); // O puedes usar $cita->update($request->all());

        return response()->json([
            'message' => 'Cita actualizada exitosamente',
            'data' => $cita,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cita = Citas::find($id); // Asegúrate de que el nombre del modelo sea correcto
        if (!$cita) {
            return response()->json(['message' => 'Cita no encontrada'], 404);
        }
        $cita->delete();
        return response()->json(['message' => 'Cita eliminada exitosamente'], 200);
    }
}