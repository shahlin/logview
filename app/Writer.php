<?php


namespace App;


class Writer
{

    public const MARKDOWN_FORMAT = 'markdown';

    public function __construct(private string $changeLogs) {}

    public function writeToMarkdown() {
        file_put_contents('output.md', $this->changeLogs);
    }

}
