<?php


namespace App;


class GeneratorPayload
{

    public function __construct(
        public string $serviceIdentifier,
        public string $fromVersion,
        public string $toVersion,
        public string $format = Writer::MARKDOWN_FORMAT
    ) {}

}
