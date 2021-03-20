<?php


namespace App;


use App\Exceptions\RequestFailureException;

class Generator
{

    private Service $service;

    public function __construct(private GeneratorPayload $generatorPayload)
    {
        $this->service = new Service($this->generatorPayload->serviceIdentifier);
    }

    public function generate()
    {
        $urls = $this->service->getURLsForVersions(
            $this->generatorPayload->fromVersion,
            $this->generatorPayload->toVersion
        );

        $changeLogs = $this->getChangeLogs($urls);
        $mergedChangeLogs = ChangeLogMerger::merge($changeLogs, $this->generatorPayload->format);
        $writer = new Writer($mergedChangeLogs);

        $writer->writeToMarkdown();
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
