<?php


namespace App\Factories;


use App\Contracts\Merger;
use App\Mergers\MarkdownMerger;

class MergerFactory
{

    public static function get(string $format): Merger {
        // Currently, only Markdown inputs are accepted hence
        // only Markdown merger is returned.
        // If we're to support different format inputs, we can
        // return multiple merger instances to handle different
        // type of merging.
        return new (MarkdownMerger::class);
    }

}
