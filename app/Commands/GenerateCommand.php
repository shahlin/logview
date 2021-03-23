<?php

namespace App\Commands;

use App\Exceptions\ServiceNotFoundException;
use App\Generator;
use App\GeneratorPayload;
use App\Service;
use LaravelZero\Framework\Commands\Command;

class GenerateCommand extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'generate';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Generate a merged set of changelogs from a given version to another';

    /**
     * Execute the console command.
     *
     * @return void
     * @throws ServiceNotFoundException
     */
    public function handle()
    {
        $serviceIdentifier = $this->serviceSelectionMenu() ?? exit;
        $service = new Service($serviceIdentifier);
        $supportedVersions = $service->getSupportedVersions();

        $fromVersion = $this->getFromVersionFromMenu($supportedVersions);
        $toVersion = $this->getToVersionFromMenu($supportedVersions, $fromVersion);
        $format = $this->formatSelectionMenu($service);

        $payload = new GeneratorPayload($service, $fromVersion, $toVersion, $format);
        $generator = new Generator($payload);
        $generator->generate();

        $successMessage = "Generated for version '$fromVersion'";

        if (!empty($toVersion)) {
            $successMessage .= " to '$toVersion'!";
        }

        $this->info($successMessage);
        $this->info('Saved to output.' . $format);
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

        return $this->menu('Select End Version', $listOfVersionsToDisplay)
            ->setBackgroundColour('23')
            ->setPadding(2)
            ->open();
    }

    private function formatSelectionMenu(Service $service) {
        $formats = $service->getSupportedFormats();

        $displayFormats = [];
        foreach ($formats as $format) {
            $displayFormats[$format] = ucwords($format);
        }

        if (empty($formats)) {
            $this->error('Could not write changelog - Format not supported');
            exit;
        }

        return $this->menu('Select Format', $displayFormats)
            ->setBackgroundColour('23')
            ->setPadding(2)
            ->open();
    }

    private function getFromVersionFromMenu(array $supportedVersions): string {
        $menuSelection = $this->fromVersionSelectionMenu($supportedVersions);

        return $supportedVersions[$menuSelection] ?? exit;
    }

    private function getToVersionFromMenu(array $supportedVersions, string $fromVersion): string {
        $menuSelection = $this->toVersionSelectionMenu($supportedVersions, $fromVersion);

        if ($menuSelection === 'none') {
            $toVersion = '';
        } else if (empty($menuSelection)) {
            exit;
        } else {
            $toVersion = $supportedVersions[$menuSelection];
        }

        return $toVersion;
    }

}
