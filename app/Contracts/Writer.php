<?php


namespace App\Contracts;


interface Writer
{

    public function write(string $changeLogs): void;

}
