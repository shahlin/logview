<?php


namespace App\Writers;


use App\Contracts\Writer;
use Parsedown;

class HTMLWriter implements Writer
{

    private const TEMPLATE_FILE_NAME = 'template.html';

    public function write(string $changeLogs): void
    {
        $parsedown = new Parsedown();
        $markup = $parsedown->parse($changeLogs);
        $styledMarkup = $this->styleHTML($markup);

        file_put_contents('output.html', $styledMarkup);
    }

    private function styleHTML(string $html): string {
        $templatePath = resource_path('views/' . self::TEMPLATE_FILE_NAME);
        $templateHTML = file_get_contents($templatePath);

        return str_replace('{{changelog_data}}', $html, $templateHTML);
    }

}
