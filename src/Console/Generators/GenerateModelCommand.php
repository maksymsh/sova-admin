<?php

namespace Sova\Admin\Console\Generators;

use Symfony\Component\Console\Input\InputOption;

class GenerateModelCommand extends BaseGeneratorCommand
{
    protected $name = 'admin:make:model';

    protected $namespace = 'App\Models';

    protected $dummies = [
        'DummyTimestamps', 'DummyTraits', 'DummyFillable', 'DummyTranslatable', //'DummyMutators', 'DummyScopes'
    ];


    protected function getStub()
    {
        return __DIR__ . '/stubs/model.stub';
    }




    protected function replaceTimestamps()
    {
        $data = $this->parse('timestamps');
        return "public \$timestamps = {$data};\n\t";
    }

    protected function replaceTraits()
    {
        $data = $this->parse('traits');
        return "use ${data};\n\t";
    }

    protected function replaceFillable()
    {
        $data = $this->parse('fillable');
        return "use ${data};\n\t";
    }

    protected function replaceTranslatable()
    {
        $data = $this->parse('translatable');
        return "use ${data};\n\t";
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

            ['traits', null, InputOption::VALUE_NONE, 'traits'],

            ['fillable', null, InputOption::VALUE_NONE, 'fillable'],

            ['translatable', null, InputOption::VALUE_NONE, 'translatable'],

            ['data', null, InputOption::VALUE_NONE, 'data'],

            ['force', null, InputOption::VALUE_NONE, 'force'],
        ];
    }


}