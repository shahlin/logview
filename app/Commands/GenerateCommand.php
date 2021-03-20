<?php

namespace App\Commands;

use App\Contracts\Service;
use App\Generator;
use App\GeneratorPayload;
use App\ServiceFactory;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Validator;
use LaravelZero\Framework\Commands\Command;

class GenerateCommand extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'generate
                            {service_id : Service identifier}
                            {--F|from= : Version to start the generation from}
                            {--T|to= : Version to generate the logs till}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Generate a merged set of changelogs from a given version to another';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $fromVersion = $this->option('from');
        $toVersion = $this->option('to');

        if (!$this->validate($fromVersion, $toVersion)) {
            return;
        }

        $payload = new GeneratorPayload($this->argument('service_id'), $fromVersion, $toVersion);
        $generator = new Generator($payload);
        $generator->generate();

        $this->info('Generated!');
    }

    /**
     * Define the command's schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    public function schedule(Schedule $schedule): void
    {
        // $schedule->command(static::class)->everyMinute();
    }

    private function validate($fromVersion, $toVersion) {
        if (!$fromVersion || !$toVersion) {
            $this->error('Please specify both from and to versions');
            return false;
        }

        return true;
    }
}
