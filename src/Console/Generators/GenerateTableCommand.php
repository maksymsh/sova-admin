<?php

namespace Sova\Admin\Console\Generators;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class GenerateTableCommand extends BaseGeneratorCommand
{
    protected $name = '';

    protected $namespace = '';

    protected $dummies = [];

    protected function getStub()
    {
        return __DIR__ . '/stubs/table.stub';
    }


    protected function getOptions()
    {
        return [

        ];
    }


}