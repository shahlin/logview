<?php


namespace App\Mergers;


use App\Contracts\Merger;

class MarkdownMerger implements Merger
{

    public function merge(array $changeLogs): string
    {
        $output = "";
        $delimiter = "\n---\n\n";
        foreach ($changeLogs as $changeLog) {
            $output .= $changeLog . $delimiter;
        }

        return rtrim($output, $delimiter);
    }

}
