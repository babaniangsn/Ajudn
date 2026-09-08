<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * Modèle Membre — représente un adhérent de l'association.
 *
 * @property int $id
 * @property string $matricule
 * @property string $nom
 * @property string $prenom
 * @property string|null $telephone
 * @property Carbon $date_adhesion
 * @property string $statut
 */
class Membre extends Model
{
    use HasFactory;

    protected $fillable = [
        'matricule',
        'nom',
        'prenom',
        'telephone',
        'date_adhesion',
        'statut',
    ];

    protected function casts(): array
    {
        return [
            'date_adhesion' => 'date',
        ];
    }

    /**
     * Génère automatiquement le prochain matricule disponible (ex: MB-0001).
     */
    public static function genererMatricule(): string
    {
        $dernier = static::query()->orderByDesc('id')->value('id') ?? 0;

        return 'MB-'.str_pad((string) ($dernier + 1), 4, '0', STR_PAD_LEFT);
    }

    public function cotisations(): HasMany
    {
        return $this->hasMany(Cotisation::class);
    }

    public function getNomCompletAttribute(): string
    {
        return "{$this->prenom} {$this->nom}";
    }

    /**
     * Un membre est "à jour" s'il a payé la cotisation du mois/année en cours.
     */
    public function estAJour(): bool
    {
        return $this->cotisations()
            ->where('mois', now()->month)
            ->where('annee', now()->year)
            ->exists();
    }

    public function scopeActifs($query)
    {
        return $query->where('statut', 'actif');
    }

    public function scopeRecherche($query, ?string $terme)
    {
        if (blank($terme)) {
            return $query;
        }

        return $query->where(function ($q) use ($terme) {
            $q->where('nom', 'like', "%{$terme}%")
                ->orWhere('prenom', 'like', "%{$terme}%")
                ->orWhere('matricule', 'like', "%{$terme}%")
                ->orWhere('telephone', 'like', "%{$terme}%");
        });
    }
}
