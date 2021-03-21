<?php


namespace App\Contracts;


interface Merger
{

    public function merge(array $changeLogs): string;

}
