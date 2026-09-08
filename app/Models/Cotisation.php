<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Modèle Cotisation — représente un paiement effectué par un membre pour une période donnée.
 *
 * @property int $id
 * @property int $membre_id
 * @property string $reference
 * @property float $montant
 * @property int $mois
 * @property int $annee
 */
class Cotisation extends Model
{
    use HasFactory;

    protected $fillable = [
        'membre_id',
        'reference',
        'montant',
        'mois',
        'annee',
        'date_paiement',
    ];

    protected function casts(): array
    {
        return [
            'date_paiement' => 'date',
            'montant' => 'decimal:2',
        ];
    }

    public static function genererReference(): string
    {
        $annee = now()->year;
        $dernier = static::query()->whereYear('created_at', $annee)->count();

        return 'REC-'.$annee.'-'.str_pad((string) ($dernier + 1), 4, '0', STR_PAD_LEFT);
    }

    public function membre(): BelongsTo
    {
        return $this->belongsTo(Membre::class);
    }

    public function getPeriodeLibelleAttribute(): string
    {
        $mois = [
            1 => 'Janvier', 2 => 'Février', 3 => 'Mars', 4 => 'Avril',
            5 => 'Mai', 6 => 'Juin', 7 => 'Juillet', 8 => 'Août',
            9 => 'Septembre', 10 => 'Octobre', 11 => 'Novembre', 12 => 'Décembre',
        ];

        return ($mois[$this->mois] ?? $this->mois).' '.$this->annee;
    }
}
