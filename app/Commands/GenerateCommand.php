<?php

namespace App\Commands;

use App\Generator;
use App\GeneratorPayload;
use App\Service;
use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

class GenerateCommand extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'generate';
//                            {service_id : Service identifier}
//                            {--F|from= : Version to start the generation from}
//                            {--T|to= : Version to generate the logs till}';

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
        $serviceIdentifier = $this->serviceSelectionMenu() ?? exit;
        $service = new Service($serviceIdentifier);
        $supportedVersions = $service->getSupportedVersions();

        // Selection menu functions return index of the selected version
        $fromVersion = $supportedVersions[$this->fromVersionSelectionMenu($supportedVersions)] ?? exit;
        $toVersion = $this->toVersionSelectionMenu($supportedVersions, $fromVersion);

        if (empty($fromVersion)) {
            $this->error('Please specify the version(s)');
            return;
        }

        $payload = new GeneratorPayload($service, $fromVersion, $toVersion);
        $generator = new Generator($payload);
        $generator->generate();

        $successMessage = "Generated for version '$fromVersion'";

        if (!empty($toVersion)) {
            $successMessage .= " to '$toVersion'!";
        }

        $this->info($successMessage);
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

    private function serviceSelectionMenu()
    {
        return $this->menu('Select Service', Service::getAllServices())
            ->setBackgroundColour('23')
            ->setPadding(2)
            ->open();
    }

    private function fromVersionSelectionMenu(array $supportedVersions)
    {
        return $this->menu('Select Start Version', $supportedVersions)
            ->setBackgroundColour('23')
            ->setPadding(2)
            ->open();
    }

    private function toVersionSelectionMenu(array $supportedVersions, string $fromVersion)
    {
        $listOfVersionsToDisplay = array_filter($supportedVersions, function ($version) use ($fromVersion) {
            return $version > $fromVersion;
        });

        // Add none to support picking only fromVersion
        $listOfVersionsToDisplay['none'] = "None, generate single version changelog";

        $toVersion = $this->menu('Select End Version', $listOfVersionsToDisplay)
            ->setBackgroundColour('23')
            ->setPadding(2)
            ->open();

        if ($toVersion === 'none') {
            $toVersion = '';
        } else if (empty($toVersion)) {
            exit;
        } else {
            $toVersion = $supportedVersions[$toVersion];
        }

        return $toVersion;
    }

}
