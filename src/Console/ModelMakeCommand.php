<?php

namespace Sova\Admin\Console;

use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;

class ModelMakeCommand extends GeneratorCommand
{
    protected $name = 'admin:make:model';

    protected function getStub()
    {
        return __DIR__ . '/../../stubs/model.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return parent::getDefaultNamespace($rootNamespace) . '\Models';
    }

    protected function replaceClass($stub, $name)
    {
        $stub = parent::replaceClass($stub, $name);

        $replace = [
            'DummyTraits' => $this->buildTraits() . "\n\t",
            'DummyFillable' => $this->buildFillable() . "\n\t",
            'DummyTranslatable' => $this->buildTranslatable() . "\n\t",
            'DummyTimestamps' => $this->buildTimestamps() . "\n\t",
            'DummyRelations' => $this->buildRelations() . "\n\t",
        ];

        $stub = str_replace(array_keys($replace), array_values($replace), $stub);

        return $stub;
    }

    protected function parseOption(string $option)
    {
        $data = [];
        $value = $this->option($option);

        foreach (explode('|', $value) as $item) {
            $parts = explode(':', $item);

            if(count($parts) > 1){
                $key = array_shift($parts);
                $value = count($parts) > 1 ? $parts : array_shift($parts);
            } else {
                $key = null;
                $value = array_shift($parts);
            }



            //$key = array_shift($parts);
            //$value = count($parts) > 1 ? $parts : array_shift($parts);

            if(is_array($value)){
                foreach ($value as &$v) {
                    $parts = explode(',', $v);
                    if(count($parts) > 1){
                        $v = $parts;
                    }
                }
            } else {
                $parts = explode(',', $value);
                if(count($parts) > 1){
                    $value = $parts;
                } else {
                    $value = array_shift($parts);
                }
            }

            if($key)
                $data[$key] = $value;

            $data[] = $value;

        }

        if(count($data) === 1){
            $data = array_shift($data);
        }

        return $data;
    }

    protected function buildRelations()
    {

        return '';
    }

    protected function buildTimestamps()
    {
        if ($data = $this->parseOption('data')) {
            return 'public $timestamps = ' . ($data['timestamps'] ?? 'false') . ';';
        }
    }

    public function buildTraits()
    {
        if ($traits = $this->parseOption('traits')) {
            return 'use ' . implode(', ', $traits) . ';';
        }
    }

    public function buildFillable()
    {
        if ($fillable = $this->parseOption('fillable')) {
            return "protected \$fillable = ['" . implode("', '", $fillable) . "'];";
        }
    }

    public function buildTranslatable()
    {
        if ($data = $this->parseOption('data')) {
            if($data['translatable'] ?? false){
                return "protected \$translatable = ['" . implode("', '", $data['translatable']) . "'];";
            }
        }
    }

    protected function getOptions()
    {
        return [
            ['traits', 'r', InputOption::VALUE_REQUIRED, 'traits'],

            ['fillable', 'f', InputOption::VALUE_REQUIRED, 'fillable'],

            ['translatable', 't', InputOption::VALUE_REQUIRED, 'translatable'],

            ['data', 'd', InputOption::VALUE_REQUIRED, 'translatable'],

            ['force', null, InputOption::VALUE_NONE, 'Create the class even if the model already exists.'],
        ];
    }

}