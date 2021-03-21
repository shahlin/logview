<?php


namespace App\Writers;


use App\Contracts\Writer;

class MarkdownWriter implements Writer
{

    public function __construct() {}

    public function write(string $changeLogs): void {
        file_put_contents('output.md', $changeLogs);
    }

}
