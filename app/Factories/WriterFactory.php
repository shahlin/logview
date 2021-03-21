<?php


namespace App\Factories;


use App\Contracts\Writer;
use App\Generator;
use App\Writers\MarkdownWriter;

class WriterFactory
{

    public static function get(string $format): Writer {
        return match ($format) {
            Generator::MARKDOWN_FORMAT => new (MarkdownWriter::class)
        };
    }

}
