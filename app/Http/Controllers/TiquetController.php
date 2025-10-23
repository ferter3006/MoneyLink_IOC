<?php

namespace App\Http\Controllers;

use App\Http\Requests\Tiquets\StoreTiquetRequest;
use App\Http\Requests\Tiquets\UpdateTiquetRequest;
use App\Http\Resources\TiquetResource;
use App\Models\Tiquet;
use App\Models\User;
use Illuminate\Http\Request;

/**
 * Controlador de tiquets
 * @author Lluís Ferrater
 * @version 1.0
 * NOTA: No hay validaciones de tokens por que no es necesario,
 * ya que los tokens se validan en el middleware antes de llegar al controlador
 */
class TiquetController extends Controller
{
    /**
     * store (Crea un tiquet)
     * @author Lluís Ferrater
     * @param StoreTiquetRequest $request Request con los datos validados del tiquet
     * @return \Illuminate\Http\JsonResponse Respuesta JSON con el status y el tiquet creado
     */

    public function store(StoreTiquetRequest $request)
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

    /**
     * update (Actualiza un tiquet)
     * @author Lluís Ferrater
     * @param UpdateTiquetRequest $request Request con los datos validados del tiquet
     * @param int $id (Id del tiquet a actualizar)
     * @return \Illuminate\Http\JsonResponse Respuesta JSON con el status y el tiquet actualizado
     */

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

    /**
     * delete (Elimina un tiquet)
     * @author Lluís Ferrater
     * @param Request $request
     * @param int $id (Id del tiquet a eliminar)
     * @return \Illuminate\Http\JsonResponse Respuesta JSON con el status y un mensaje
     */

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

    /**
     * show (Muestra un tiquet)
     * @author Lluís Ferrater
     * @param Request $request
     * @param int $id (Id del tiquet a mostrar)
     * @return \Illuminate\Http\JsonResponse Respuesta JSON con el status y el tiquet
     */

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

    /**
     * autorizoSobreTiquet (Autoriza acceso o no sobre un tiquet)
     * @author Lluís Ferrater
     * @param User $user (Usuario que quiere ver el tiquet)
     * @param ?Tiquet $tiquet (Tiquet que quiere ver)
     * @return \Illuminate\Http\JsonResponse Respuesta JSON abortando si no tiene permiso
     */
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
