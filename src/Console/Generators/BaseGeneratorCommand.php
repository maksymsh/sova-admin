<?php

namespace Sova\Admin\Console\Generators;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Filesystem\Filesystem;
use Sova\Admin\Console\InputParser;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

abstract class BaseGeneratorCommand extends GeneratorCommand
{
    protected $name;

    protected $namespace;

    protected $dummies = [];

    protected $parser;

    public function __construct(Filesystem $files)
    {
        parent::__construct($files);

        $this->parser = new InputParser();
    }

    /**
     * Build the class with the given name.
     *
     * @param  string  $name
     * @return string
     */
    protected function buildClass($name)
    {
        $parent = parent::buildClass($name);
        return $this->replaceDummies($parent);
    }

    protected function replaceDummies($stub)
    {
        foreach ($this->dummies as $dummy) {
            $replaceMethod = str_replace('Dummy', 'replace', $dummy);
            if(method_exists($this, $replaceMethod)){

                $stub = str_replace($dummy, $this->$replaceMethod(), $stub);
            }
        }

        return $stub;
    }


    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['force', null, InputOption::VALUE_NONE, ''],
        ];
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, ''],
        ];
    }

    protected function parse($input)
    {
        $data = $this->option($input);
        return $this->parser->parse($data);
    }
}