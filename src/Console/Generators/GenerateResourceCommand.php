<?php

namespace Sova\Admin\Console\Generators;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class GenerateResourceCommand extends BaseGeneratorCommand
{
    protected $name = '';

    protected $namespace = '';

    protected $dummies = [];

    protected function getStub()
    {
        return __DIR__ . '/stubs/resource.stub';
    }


    protected function getOptions()
    {
        return [

        ];
    }


}