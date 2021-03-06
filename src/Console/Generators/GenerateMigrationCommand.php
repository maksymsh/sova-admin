<?php

namespace Sova\Admin\Console\Generators;

use Sova\Admin\Helpers\DBHelper;
use Symfony\Component\Console\Input\InputOption;

class GenerateMigrationCommand extends BaseGeneratorCommand
{
    protected $name = 'admin:make:migration';

    protected $dummies = [
        'DummyTable', 'DummyFields'
    ];

    protected function getStub()
    {
        return __DIR__ . '/stubs/migration.stub';
    }

    protected function replaceTable()
    {

    }

    protected function replaceFields()
    {
        $fields = $this->parse('fields');

        $schema = '';

        foreach ($fields as $field) {
            $type = $field['type'] ?: $field['name'];

            if(array_key_exists($type, DBHelper::fluentMethods)){
                $params = DBHelper::fluentMethods[$type];

                if(array_key_exists('name', $params)){

                    //$type = $params['name'];

                    if($field['arguments']){
                        $arguments = ', ' . implode(', ', $field['arguments']);
                        $schema .= "\$table->{$type}('{$field['name']}' $arguments);\n\t\t\t";
                    } else {
                        $schema .= "\$table->{$type}('{$field['name']}');\n\t\t\t";
                    }

                } else {
                    if($field['arguments']){
                        $arguments = implode(', ', $field['arguments']);
                        $schema .= "\$table->{$type}($arguments);\n\t\t\t";
                    } else {
                        $schema .= "\$table->{$type}();\n\t\t\t";
                    }
                }
            }
        }

        return $schema;
    }

    protected function getOptions()
    {
        return array_merge(parent::getOptions(), [
            ['fields', null, InputOption::VALUE_REQUIRED],
        ]);
    }

}