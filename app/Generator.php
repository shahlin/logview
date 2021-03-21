<?php


namespace App;


use App\Exceptions\RequestFailureException;
use App\Factories\MergerFactory;
use App\Factories\WriterFactory;

class Generator
{

    private Service $service;

    public const MARKDOWN_FORMAT = 'markdown';
    public const HTML_FORMAT = 'html';

    public function __construct(private GeneratorPayload $generatorPayload) {}

    public function generate()
    {
        $urls = $this->generatorPayload->service->getURLsForVersions(
            $this->generatorPayload->fromVersion,
            $this->generatorPayload->toVersion
        );

        $changeLogs = $this->getChangeLogs($urls);
        $merger = MergerFactory::get($this->generatorPayload->format);
        $writer = WriterFactory::get($this->generatorPayload->format);

        $writer->write($merger->merge($changeLogs));
    }

    private function getChangeLogs(array $urls): array {
        return array_map(function ($url) {
            return $this->getChangeLogContentFromURL($url);
        }, $urls);
    }

    private function getChangeLogContentFromURL(string $url): string
    {
        if ($output = file_get_contents($url)) {
            return $output;
        }

        throw new RequestFailureException('Could not fetch change log data using the url: ' . $url);
    }

}
