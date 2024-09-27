<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\File;
use Illuminate\Console\Command;

class CreateService extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service {name} {--i : Create interface}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new service';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        $className = ucfirst($name) . 'Service';
        $interfaceName = ucfirst($name) . 'ServiceInterface';
        $fileName = app_path("Services/{$className}.php");
        $interfaceFileName = app_path("Services/Interfaces/{$interfaceName}.php");

        if (File::exists($fileName)) {
            $this->error('Service already exists!');
            return;
        }

        File::put($fileName, "<?php\n\nnamespace App\Services;\n\nuse App\Services\Interfaces\\$interfaceName;\n\nclass $className implements $interfaceName\n{\n    // Your service code here\n}\n");

        $this->info("Service {$className} created successfully.");

        if ($this->option('i')) {
            if (File::exists($interfaceFileName)) {
                $this->error('Interface already exists!');
                return;
            }

            File::put($interfaceFileName, "<?php\n\nnamespace App\Services\Interfaces;\n\ninterface $interfaceName\n{\n    // Your interface code here\n}\n");

            $this->info("Interface {$interfaceName} created successfully.");
            $this->info("Don`t forget register service in AppServiceProvider.php !");
        }
    }
}
