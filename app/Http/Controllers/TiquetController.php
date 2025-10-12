<?php

namespace App\Http\Controllers;

use App\Http\Requests\Tiquets\StoreTiquetRequest;
use App\Http\Requests\Tiquets\UpdateTiquetRequest;
use App\Http\Resources\TiquetResource;
use App\Models\Tiquet;
use App\Models\User;
use Illuminate\Http\Request;

class TiquetController extends Controller
{
    // Crear un tiquet
    public function create(StoreTiquetRequest $request)
    {
        $userFromMiddleware = $request->get('userFromMiddleware');

        $tiquet = Tiquet::create([
            'user_id' => $userFromMiddleware->id,
            'sala_id' => $request->input('sala_id'),
            'category_id' => $request->input('category_id'),
            'es_ingreso' => $request->input('es_ingreso'),
            'description' => $request->input('description'),
            'amount' => $request->input('amount')
        ]);

        return response()->json([
            'status' => '1',
            'message' => 'Tiquet creado correctamente',
            'tiquet' => $tiquet
        ]);
    }

    // Actualizar un tiquet, solo ciertos campos

    public function update(UpdateTiquetRequest $request, $id)
    {
        $userFromMiddleware = $request->get('userFromMiddleware');
        $tiquet = Tiquet::find($id);

        $this->autorizoSobreTiquet($userFromMiddleware, $tiquet);

        $tiquet->category_id = $request->category_id ?? $tiquet->category_id;
        $tiquet->es_ingreso = $request->es_ingreso ?? $tiquet->es_ingreso;
        $tiquet->description = $request->description ?? $tiquet->description;
        $tiquet->amount = $request->amount ?? $tiquet->amount;

        $tiquet->save();

        return response()->json([
            'status' => '1',
            'message' => 'Tiquet actualizado correctamente',
            'tiquet' => $tiquet
        ]);
    }

    public function delete(Request $request, $id)
    {
        $userFromMiddleware = $request->get('userFromMiddleware');
        $tiquet = Tiquet::find($id);

        $this->autorizoSobreTiquet($userFromMiddleware, $tiquet);

        $tiquet->delete();

        return response()->json([
            'status' => '1',
            'message' => 'Tiquet eliminado correctamente'
        ]);
    }

    public function show(Request $request, $id)
    {
        $userFromMiddleware = $request->get('userFromMiddleware');
        $tiquet = Tiquet::find($id);

        $this->autorizoSobreTiquet($userFromMiddleware, $tiquet);

        return response()->json([
            'status' => '1',
            'tiquet' => new TiquetResource($tiquet)
        ], 200);
    }

    // Funcion para verificar si el usuario tiene permiso sobre el tiquet
    // Posibleme esto me ayude para los permisos de Admin?
    private function autorizoSobreTiquet(User $user, ?Tiquet $tiquet)
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
