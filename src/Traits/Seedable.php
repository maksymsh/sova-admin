<?php

namespace Sova\Admin\Traits;

trait Seedable
{
    public function seed($class, $data = [])
    {
        if (!class_exists($class)) {
            require_once $this->seedersPath.$class.'.php';
        }

        with(new $class())->run($data);
    }
}
