<?php


namespace App\Factories;


use App\Contracts\Writer;
use App\Generator;
use App\Writers\HTMLWriter;
use App\Writers\MarkdownWriter;

class WriterFactory
{

    public const WRITABLE_FORMATS = [
        // From format => Supported to convert to format
        'md' => [ Generator::MARKDOWN_FORMAT, Generator::HTML_FORMAT ]
    ];

    public static function get(string $format): Writer {
        return match ($format) {
            Generator::MARKDOWN_FORMAT => new (MarkdownWriter::class),
            Generator::HTML_FORMAT => new (HTMLWriter::class),
        };
    }

}
