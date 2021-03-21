<?php


namespace App;


class GeneratorPayload
{

    public function __construct(
        public Service $service,
        public string $fromVersion,
        public string $toVersion,
        public string $format = Generator::MARKDOWN_FORMAT
    ) {}

}
