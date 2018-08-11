<?php

namespace Sova\Admin\Console\Generators;

use Symfony\Component\Console\Input\InputOption;

class GenerateModelCommand extends BaseGeneratorCommand
{
    protected $name = 'admin:make:model';

    protected $namespace = 'App\Models';

    protected $dummies = [
        'DummyTimestamps', 'DummySoftDeletes', 'DummyTraits', 'DummyFillable', 'DummyTranslatable', //'DummyMutators', 'DummyScopes'
    ];


    protected function getStub()
    {
        return __DIR__ . '/stubs/model.stub';
    }




    protected function replaceTimestamps()
    {
        if($data = $this->option('timestamps')) {
            return "public \$timestamps = true;\n\t";
        }
    }

    protected function replaceSoftDeletes()
    {
        if($data = $this->option('softDeletes')) {
            return "public \$softDeletes = true;\n\t";
        }
    }

    protected function replaceTraits()
    {
        if($data = $this->option('traits')){
            return "use ${data};\n\t";
        }
    }

    protected function replaceFillable()
    {
        if($data = $this->parse('fillable')){
            $data = array_pluck($data, 'name');
            $fillable = implode("', '", $data);
            return "protected \$fillable = ['{$fillable}'];\n\t";
        }
    }

    protected function replaceTranslatable()
    {
        if($data = $this->parse('translatable')){
            $data = array_pluck($data, 'name');
            $translatable = implode("', '", $data);
            return "protected \$translatable = ['{$translatable}'];\n\t";
        }
    }

    protected function replaceMutators(){
        //$data = $this->parse('mutators');
        //return "use ${data};\n\t";
    }

    protected function replaceScopes(){
        //$data = $this->parse('scopes');
        //return "use ${data};\n\t";
    }



    protected function getOptions()
    {
        return [
            ['timestamps', null, InputOption::VALUE_NONE, 'timestamps'],

            ['softDeletes', null, InputOption::VALUE_NONE, 'softDeletes'],

            ['traits', null, InputOption::VALUE_OPTIONAL, 'traits'],

            ['fillable', null, InputOption::VALUE_OPTIONAL, 'fillable'],

            ['translatable', null, InputOption::VALUE_OPTIONAL, 'translatable'],

            ['data', null, InputOption::VALUE_OPTIONAL, 'data'],

            ['force', null, InputOption::VALUE_NONE, 'force'],
        ];
    }


}