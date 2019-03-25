<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class FazaInstall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'faza:install {--c|custom : Customize installation} {--f|force : No ask for continue installation} {--ns|noserve : Force No Serve Ask}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Installing Faza, Prepare this Project.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->showHeader();
        $this->line("Melakukan perintah ini akan menyiapkan");
        $this->line("faza ini ke fresh project yang siap digunakan.");
        
        $askbeforeinstall = $this->option('custom');
        if (!$this->option('force')) {
            $continueInstal = $this->confirm('Lanjutkan?');
            if (!$continueInstal) return ;
        }

        if ($askbeforeinstall) {
            if ($this->confirm('Lakukan Migration DB?')) {
                $this->titleStep("Run Command - Migrate");
                $this->call("migrate:fresh");
            }

            if ($this->confirm('Lakukan Seeder Untuk User?')) {
                $this->titleStep("Run Command - Seeder [User]");
                $this->call("db:seed", ['--class' => 'UsersTableSeeder']);
                $this->titleStep("Run Command - Seeder [IndoRegion]");
                $this->call("db:seed", ['--class' => 'IndoRegionDistrictSeeder']);
                $this->call("db:seed", ['--class' => 'IndoRegionProvinceSeeder']);
                $this->call("db:seed", ['--class' => 'IndoRegionRegencySeeder']);
                $this->call("db:seed", ['--class' => 'IndoRegionVillageSeeder']);
            }

            if ($this->confirm('Bersihkan semua cache? ')) {
                $this->titleStep("Run Command - Clear Cache");
                $this->call("clear");
                $this->call("cache:clear");
                $this->call("view:clear");
                $this->call("config:clear");
            }
        } else {
            $this->titleStep("Run Command - Migrate");
            $this->call("migrate:fresh");
            $this->titleStep("Run Command - Seeder [User]");
            $this->call("db:seed", ['--class' => 'UsersTableSeeder']);
            $this->titleStep("Run Command - Seeder [IndoRegion]");
            $this->call("db:seed", ['--class' => 'IndoRegionDistrictSeeder']);
            $this->call("db:seed", ['--class' => 'IndoRegionProvinceSeeder']);
            $this->call("db:seed", ['--class' => 'IndoRegionRegencySeeder']);
            $this->call("db:seed", ['--class' => 'IndoRegionVillageSeeder']);
            $this->titleStep("Run Command - Clear Cache");
            $this->call("clear");
            $this->call("cache:clear");
            $this->call("view:clear");
            $this->call("config:clear");
        }

        if (!$this->option('force')) {
            $runServe = $this->confirm('Berhasil, Jalankan artisan serve?');
            $this->showFooter();
            if ($runServe) $this->call("serve");
        }
    }

    private function titleStep($msg)
    {
        $this->info("");
        $this->info("[+] $msg");
        $this->info("===========================================");
    }

    private function showHeader()
    {
        $this->info("");
        $this->info("");
        $this->info("");
        $this->info("==============================================");
        $this->info("============== FAZA INSTALLATION =============");
        $this->info("==============================================");
    }

    private function showFooter()
    {
        $this->info("==============================================");
        $this->info("============== FAZA INSTALLATION =============");
        $this->info("==============================================");
        $this->info("");
    }
}
