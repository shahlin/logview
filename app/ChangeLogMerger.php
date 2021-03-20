<?php


namespace App;


class ChangeLogMerger
{

    public static function merge(array $changeLogs, string $format): string
    {
        $merger = new self;

        switch ($format) {
            case Writer::MARKDOWN_FORMAT: return $merger->mergeMarkdown($changeLogs);
        }
    }

    private function mergeMarkdown(array $changeLogs): string
    {
        $output = "";
        $delimiter = "\n---\n";
        foreach ($changeLogs as $changeLog) {
            $output .= $changeLog . $delimiter;
        }

        return rtrim($output, $delimiter);
    }

}
