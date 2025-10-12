<?php

namespace App\Http\Controllers;

use App\Http\Requests\TiquetsRecurrentes\StoreTiquetRecurrenteRequest;
use App\Http\Requests\TiquetsRecurrentes\UpdateTiquetRecurrenteRequest;
use App\Models\TiquetRecurrente;
use App\Models\User;
use Illuminate\Http\Request;

class TiquetRecurrenteController extends Controller
{
    public function store(StoreTiquetRecurrenteRequest $request)
    {
        $userFromMiddleware = $request->get('userFromMiddleware');

        $tiquet = TiquetRecurrente::create([
            'user_id' => $userFromMiddleware->id,
            'sala_id' => $request->input('sala_id'),
            'category_id' => $request->input('category_id'),
            'es_ingreso' => $request->input('es_ingreso'),
            'description' => $request->input('description'),
            'amount' => $request->input('amount'),
            'recurrencia_es_mensual' => $request->input('recurrencia_es_mensual'),
            'recurrencia_dia_activacion' => $request->input('recurrencia_dia_activacion')
        ]);

        return response()->json([
            'status' => '1',
            'message' => 'Tiquet recurrente creado correctamente',
            'tiquet' => $tiquet
        ]);
    }

    public function delete(Request $request, $id)
    {
        $userFromMiddleware = $request->get('userFromMiddleware');
        $tiquet = TiquetRecurrente::find($id);

        $this->autorizoSobreTiquet($userFromMiddleware, $tiquet);

        $tiquet->delete();

        return response()->json([
            'status' => '1',
            'message' => 'Tiquet recurrente eliminado correctamente',
            'tiquet' => $tiquet
        ]);
    }

    public function update(UpdateTiquetRecurrenteRequest $request, $id)
    {
        $userFromMiddleware = $request->get('userFromMiddleware');
        $tiquet = TiquetRecurrente::find($id);

        $this->autorizoSobreTiquet($userFromMiddleware, $tiquet);

        $tiquet->category_id = $request->category_id ?? $tiquet->category_id;
        $tiquet->es_ingreso = $request->es_ingreso ?? $tiquet->es_ingreso;
        $tiquet->description = $request->description ?? $tiquet->description;
        $tiquet->amount = $request->amount ?? $tiquet->amount;
        $tiquet->recurrencia_es_mensual = $request->recurrencia_es_mensual ?? $tiquet->recurrencia_es_mensual;
        $tiquet->recurrencia_dia_activacion = $request->recurrencia_dia_activacion ?? $tiquet->recurrencia_dia_activacion;

        $tiquet->save();

        return response()->json([
            'status' => '1',
            'message' => 'Tiquet recurrente actualizado correctamente',
            'tiquet' => $tiquet
        ]);
    }

    private function autorizoSobreTiquet(User $user, ?TiquetRecurrente $tiquet)
    {
        if (!$tiquet) {
            abort(response()->json([
                'status' => '0',
                'message' => 'Tiquet no encontrado'
            ], 404));
        }

        if ($tiquet->user_id !== $user->id) {
            abort(response()->json([
                'status' => '0',
                'message' => 'No tienes permiso para ver este tiquet'
            ], 403));
        }
    }
}
