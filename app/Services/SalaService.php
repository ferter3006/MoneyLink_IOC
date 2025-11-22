<?php

namespace App\Services;

use App\Models\Sala;
use App\Models\UserSalaRole;

class SalaService
{


    public static function getOneSala($id, $user = null, $inicioMes, $finMes)
    {
        // Sala
        $sala = Sala::with([
            'tiquets' => function ($query) use ($inicioMes, $finMes) {
                $query->whereBetween('created_at', [$inicioMes, $finMes]);
            }
        ])
            // con objetivos de este mes
            ->with([
                'salaObjectives' => function ($query) use ($inicioMes, $finMes) {
                    $query->whereBetween('date', [$inicioMes, $finMes]);
                }
            ])
            ->find($id);

        // Usuarios
        $sala->usuarios = UserSalaRole::select(
            'users.id',
            'users.name',
            'roles.name as sala_role'
        )
            ->where('sala_id', $id)
            ->where('user_id', '!=', $user ? $user->id : 0)
            ->join('users', 'user_sala_roles.user_id', '=', 'users.id')
            ->join('roles', 'user_sala_roles.role_id', '=', 'roles.id')

            ->get();

        return $sala;

    }
}
