<?php

namespace App\Http\Controllers;

use App\Models\Cotisation;
use App\Models\Membre;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;

/**
 * Centralise les exports PDF pour les membres et les cotisations.
 */
class ExportController extends Controller
{
    public function membresPdf(): Response
    {
        $membres = Membre::orderBy('nom')->get();

        $pdf = Pdf::loadView('exports.membres_pdf', compact('membres'))->setPaper('a4', 'landscape');

        return $pdf->stream('membres-'.now()->format('Y-m-d').'.pdf');
    }

    public function cotisationsPdf(): Response
    {
        $cotisations = Cotisation::with('membre')->orderByDesc('date_paiement')->get();

        $pdf = Pdf::loadView('exports.cotisations_pdf', compact('cotisations'))->setPaper('a4', 'landscape');

        return $pdf->stream('cotisations-'.now()->format('Y-m-d').'.pdf');
    }
}
