<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MigrateSqliteToMysql extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:migrate-data {sqlite_path?}';
    protected $description = 'Migrate data from an SQLite database to MySQL database.';

    public function handle()
    {
        $sqlitePath = $this->argument('sqlite_path') ?? database_path('old_database.sqlite');
        
        if (!file_exists($sqlitePath)) {
            $this->error("SQLite database not found at: {$sqlitePath}");
            return;
        }

        // Configure temporary sqlite connection
        \Illuminate\Support\Facades\Config::set('database.connections.sqlite_old', [
            'driver' => 'sqlite',
            'database' => $sqlitePath,
            'prefix' => '',
            'foreign_key_constraints' => false,
        ]);

        $this->info("Connected to SQLite: {$sqlitePath}");

        // Get all tables from SQLite
        $sqliteDb = \Illuminate\Support\Facades\DB::connection('sqlite_old');
        $mysqlDb = \Illuminate\Support\Facades\DB::connection('mysql');

        $tables = $sqliteDb->select("SELECT name FROM sqlite_master WHERE type='table'");
        
        $ignoreTables = ['migrations', 'sqlite_sequence'];

        $mysqlDb->statement('SET FOREIGN_KEY_CHECKS=0;');

        foreach ($tables as $tableRow) {
            $table = $tableRow->name;
            if (in_array($table, $ignoreTables)) {
                continue;
            }

            if (!\Illuminate\Support\Facades\Schema::connection('mysql')->hasTable($table)) {
                $this->warn("Table '{$table}' does not exist in MySQL. Skipping.");
                continue;
            }

            $this->info("Migrating table: {$table}");
            
            $rows = $sqliteDb->table($table)->get();
            $this->line("Found {$rows->count()} rows in '{$table}'");

            if ($rows->count() > 0) {
                // Clear existing data in MySQL
                $mysqlDb->table($table)->truncate();
                
                $columns = \Illuminate\Support\Facades\Schema::connection('mysql')->getColumnListing($table);

                // Insert in chunks to avoid memory/query limits
                $chunks = $rows->chunk(500);
                foreach ($chunks as $chunk) {
                    $insertData = $chunk->map(function($item) use ($columns) {
                        $arr = (array) $item;
                        // Keep only keys that exist in MySQL to avoid unknown column errors
                        return array_intersect_key($arr, array_flip($columns));
                    })->toArray();
                    
                    $mysqlDb->table($table)->insert($insertData);
                }
                $this->info("Inserted {$rows->count()} rows into '{$table}'");
            }
        }

        $mysqlDb->statement('SET FOREIGN_KEY_CHECKS=1;');
        
        $this->info("Data migration completed successfully!");
    }
}
