<?php


namespace App\Exceptions;


class VersionNotSupportedException extends \Exception
{

    protected $message = 'The given version is not supported';

}
