<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class CreateRepository extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repository {name} {--i : Create interface}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new repository';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        $className = ucfirst($name) . 'Repository';
        $interfaceName = ucfirst($name) . 'RepositoryInterface';
        $fileName = app_path("Repositories/{$className}.php");
        $interfaceFileName = app_path("Repositories/Interfaces/{$interfaceName}.php");

        if (File::exists($fileName)) {
            $this->error('Repository already exists!');
            return;
        }

        File::put($fileName, "<?php\n\nnamespace App\Repositories;\n\nuse App\Repositories\Interfaces\\$interfaceName;\n\nclass $className implements $interfaceName\n{\n    // Your repository code here\n}\n");

        $this->info("Repository {$className} created successfully.");

        if ($this->option('i')) {
            if (File::exists($interfaceFileName)) {
                $this->error('Interface already exists!');
                return;
            }

            File::put($interfaceFileName, "<?php\n\nnamespace App\Repositories\Interfaces;\n\ninterface $interfaceName\n{\n    // Your interface code here\n}\n");

            $this->info("Interface {$interfaceName} created successfully.");
            $this->info("Don`t forget register service in AppServiceProvider.php !");
        }
    }
}
