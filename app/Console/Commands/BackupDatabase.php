<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('app:backup-database')]
#[Description('Command description')]
class BackupDatabase extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $db = config('database.connections.mysql.database');
        $user = config('database.connections.mysql.username');
        $password = config('database.connections.mysql.password');
        $host = config('database.connections.mysql.host');
        $date = now()->format('Y_m_d_His');
        $filename = "backup_{$db}_{$date}.sql";
        $path = storage_path("backups/{$filename}");

        // Creer le dossier si inexistant
        if (! file_exists(storage_path('backups'))) {
            mkdir(storage_path('backups'), 0755, true);
        }

        // chemin mysqldump
        $mysqldump = 'C:\\laragon\\bin\\mysql\\mysql-8.4.3-winx64\\bin\\mysqldump.exe';

        $command = "\"{$mysqldump}\" -u {$user}  -h {$host} {$db} > \"{$path}\"";

        exec($command);

        // Supprimer les backups de plus de 30 jours
        $files = glob(storage_path('backups/*.sql'));
        foreach ($files as $file) {
            if (filemtime($file) < now()->subDays(30)->timestamp) {
                unlink($file);
            }
        }

        $this->info("Backup database reussi: {$filename}");

    }
}
