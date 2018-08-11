<?php

namespace Sova\Admin\Form;

use Illuminate\Contracts\Support\Renderable;

class ResourceForm extends AdminForm
{
    protected function build($form)
    {
        $form->text('name');
    }
}