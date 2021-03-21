<?php


namespace App\Factories;


use App\Contracts\Merger;
use App\Generator;
use App\Mergers\MarkdownMerger;

class MergerFactory
{

    public static function get(string $format): Merger {
        return match ($format) {
            Generator::MARKDOWN_FORMAT => new (MarkdownMerger::class)
        };
    }

}
