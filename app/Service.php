<?php


namespace App;


use App\Exceptions\ServiceNotFoundException;
use App\Exceptions\VersionNotSupportedException;

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

    public function getSupportedVersions(): array {
        return config($this->serviceConfigPrefix . '.versions');
    }

    public function getBaseURL(): string
    {
        return config($this->serviceConfigPrefix . '.url');
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
        if (!in_array($fromVersion, $supportedVersions) || !in_array($toVersion, $supportedVersions)) {
            throw new VersionNotSupportedException;
        }

        return array_filter($this->getSupportedVersions(), function ($version) use ($fromVersion, $toVersion) {
            return $version >= $fromVersion && $version <= $toVersion;
        });
    }

}
