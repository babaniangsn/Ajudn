<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
 * Permet de générer et télécharger une sauvegarde (dump) de la base de données MySQL.
 */
class BackupController extends Controller
{
    public function index()
    {
        $sauvegardes = collect(Storage::disk('backups')->files())
            ->filter(fn ($f) => str_ends_with($f, '.sql'))
            ->sortDesc()
            ->values();

        return view('backup.index', compact('sauvegardes'));
    }

    /** Génère une sauvegarde SQL directement avec la connexion Laravel. */
    public function creer(): RedirectResponse
    {
        $nomFichier = 'backup-'.now()->format('Y-m-d_His').'.sql';
        $cheminComplet = storage_path('app/backups/'.$nomFichier);

        if (! File::exists(storage_path('app/backups'))) {
            File::makeDirectory(storage_path('app/backups'), 0755, true);
        }

        try {
            $contenu = $this->genererDumpSql();
            File::put($cheminComplet, $contenu);
        } catch (\Throwable $exception) {
            report($exception);

            return redirect()->route('backup.index')
                ->with('error', 'Échec de la sauvegarde. Vérifiez la connexion à la base de données.');
        }

        return redirect()->route('backup.index')
            ->with('success', 'Sauvegarde de la base de données créée avec succès.');
    }

    private function genererDumpSql(): string
    {
        $pdo = DB::connection()->getPdo();
        $tables = DB::select('SHOW TABLES');
        $sql = "SET FOREIGN_KEY_CHECKS=0;\n\n";
        $donnees = [];

        usort($tables, function ($premiereTable, $secondeTable): int {
            $ordre = ['users' => 10, 'membres' => 20, 'cotisations' => 30, 'sessions' => 40];
            $premiere = array_values((array) $premiereTable)[0];
            $seconde = array_values((array) $secondeTable)[0];

            return ($ordre[$premiere] ?? 100) <=> ($ordre[$seconde] ?? 100);
        });

        foreach ($tables as $tableRow) {
            $tableName = array_values((array) $tableRow)[0];
            $quotedTable = '`'.str_replace('`', '``', $tableName).'`';
            $definition = DB::selectOne("SHOW CREATE TABLE {$quotedTable}");
            $createSql = array_values((array) $definition)[1];

            $sql .= "DROP TABLE IF EXISTS {$quotedTable};\n";
            $sql .= $createSql.";\n\n";

            $rows = DB::select("SELECT * FROM {$quotedTable}");
            $donnees[$tableName] = [$quotedTable, $rows];
        }

        foreach ($donnees as [$quotedTable, $rows]) {
            foreach ($rows as $row) {
                $values = [];
                foreach ((array) $row as $value) {
                    $values[] = $value === null ? 'NULL' : $pdo->quote((string) $value);
                }

                $columns = array_map(
                    fn (string $column) => '`'.str_replace('`', '``', $column).'`',
                    array_keys((array) $row)
                );

                $sql .= 'INSERT INTO '.$quotedTable.' ('.implode(', ', $columns).') VALUES ('.implode(', ', $values).');'."\n";
            }

            $sql .= "\n";
        }

        $adminEmail = config('admin.email', 'ajudn@gmail.com');
        $admin = User::where('email', $adminEmail)->first();
        $adminPassword = $admin?->getRawOriginal('password') ?? Hash::make(config('admin.password', 'Ajudn2026'));
        $adminName = $admin?->name ?? config('admin.name', 'Administrateur');
        $adminCreatedAt = $admin?->created_at?->format('Y-m-d H:i:s') ?? now()->format('Y-m-d H:i:s');
        $adminUpdatedAt = $admin?->updated_at?->format('Y-m-d H:i:s') ?? $adminCreatedAt;
        $adminValues = [
            $pdo->quote($adminName),
            $pdo->quote($adminEmail),
            $pdo->quote($adminPassword),
            $pdo->quote($adminCreatedAt),
            $pdo->quote($adminUpdatedAt),
        ];

        $sql .= 'INSERT INTO `users` (`name`, `email`, `password`, `created_at`, `updated_at`) VALUES ('
            .implode(', ', $adminValues)
            .') ON DUPLICATE KEY UPDATE `name` = VALUES(`name`), `password` = VALUES(`password`), `updated_at` = VALUES(`updated_at`);'."\n\n";

        return $sql."SET FOREIGN_KEY_CHECKS=1;\n";
    }

    public function telecharger(string $fichier): BinaryFileResponse
    {
        $disk = Storage::disk('backups');
        abort_unless($disk->exists($fichier), 404);

        return response()->download($disk->path($fichier));
    }

    public function supprimer(string $fichier): RedirectResponse
    {
        Storage::disk('backups')->delete($fichier);

        return redirect()->route('backup.index')->with('success', 'Sauvegarde supprimée.');
    }
}
