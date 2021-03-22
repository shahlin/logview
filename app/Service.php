<?php


namespace App;


use App\Exceptions\ServiceNotFoundException;
use App\Exceptions\VersionNotSupportedException;
use App\Factories\WriterFactory;

class Service
{

    private string $serviceConfigPrefix;
    public const VERSION_EXPR = '{{versions}}';

    public function __construct(private string $serviceIdentifier) {
        $this->serviceConfigPrefix = 'services.' . $this->serviceIdentifier;

        if (!config($this->serviceConfigPrefix)) {
            throw new ServiceNotFoundException;
        }
    }

    public static function getAllServices(): array
    {
        $services = [];
        foreach (config('services') as $serviceID => $service) {
            $services[$serviceID] = $service['name'];
        }

        return $services;
    }

    public function getSupportedVersions(): array {
        return config($this->serviceConfigPrefix . '.versions');
    }

    public function getSupportedFormats(): array
    {
        $givenFormat = $this->getBaseURLFormat();

        return WriterFactory::WRITABLE_FORMATS[$givenFormat] ?? [];
    }

    public function getBaseURL(): string
    {
        return config($this->serviceConfigPrefix . '.url');
    }

    public function getBaseURLFormat(): string {
        $url = $this->getBaseURL();
        return substr($url, strrpos($url, '.') + 1);
    }

    public function getURLsForVersions(string $fromVersion, string $toVersion): array {
        $versions = $this->getSupportedVersionsFromTo($fromVersion, $toVersion);
        throw_if(
            empty($versions),
            VersionNotSupportedException::class
        );

        return array_map(function ($version) {
            return str_replace(self::VERSION_EXPR, $version, $this->getBaseURL());
        }, $versions);
    }

    private function getSupportedVersionsFromTo(string $fromVersion, string $toVersion): array
    {
        $supportedVersions = $this->getSupportedVersions();
        if (!in_array($fromVersion, $supportedVersions) || (!empty($toVersion) && !in_array($toVersion, $supportedVersions))) {
            throw new VersionNotSupportedException;
        }

        if (empty($toVersion)) {
            return [$fromVersion];
        }

        return array_filter($supportedVersions, function ($version) use ($fromVersion, $toVersion) {
            return $version >= $fromVersion && $version <= $toVersion;
        });
    }

}
