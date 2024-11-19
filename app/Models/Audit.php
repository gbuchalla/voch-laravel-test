<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneOrMany;
use Illuminate\Support\Facades\Auth;

class Audit extends Model
{
    protected $fillable = [
        'auditable_type',
        'auditable_id',
        'action',
        'changes',
        'user_id',
    ];

    protected $casts = [
        'changes' => 'array',
    ];


    /**
    * Get the user that triggered the audit
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }



    /**
     * Cria auditoria para o modelo
     */
    public static function createAudit(Model $auditable, string $action): void
    {
        $user = Auth::user(); // Pega o usuário autenticado

        $changes = null;
        if ($action == 'updated') {
            // Caso seja uma atualização, pega os valores alterados
            $changes = [
                'old' => $auditable->getChanges(),
                'new' => $auditable->getOriginal()
            ];
            // dd($changes);
        }
        if ($action == 'created' || 'deleted') {
            $changes = $auditable->getAttributes();
            // dd($changes);
        }

        self::create([
            'auditable_type' => get_class($auditable),  // Tipo de modelo
            'auditable_id' => $auditable->id,  // ID da entidade
            'action' => $action,  // Ação realizada (create, update, delete)
            'changes' => $changes,  // Mudanças feitas
            'user_id' => $user ? $user->id : null,  // ID do usuário
        ]);
    }

}
