<?php

namespace App\Models\Traits;

use App\Models\School;
use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Builder;

trait BelongsToSchool
{
    /**
     * Este método se ejecuta automáticamente cuando un modelo usa este Trait.
     */
    protected static function bootBelongsToSchool(): void
    {
        // 🔥 1. EL ESCUDO DE CREACIÓN (Evita los NULL)
        static::creating(function ($model) {
            // Evaluamos directamente si getTenant() devuelve el modelo del colegio
            if (empty($model->school_id) && Filament::getTenant()) {
                $model->school_id = Filament::getTenant()->id;
            }
        });

        // 🕵️ 2. EL FILTRO INVISIBLE (Global Scope)
        static::addGlobalScope('school_tenant', function (Builder $builder) {
            // Evaluamos directamente si getTenant() devuelve el modelo del colegio
            if (Filament::getTenant()) {
                $builder->where('school_id', Filament::getTenant()->id);
            }
        });
    }

    /**
     * Relación con el Colegio. Al estar en el Trait, ya no tienes que escribirla en cada modelo.
     */
    public function school()
    {
        return $this->belongsTo(School::class);
    }
}