<?php

namespace Sova\Admin\Form;

use Illuminate\Contracts\Support\Renderable;

class AdminForm implements Renderable
{
    public function __construct()
    {
        //dd(app('router')->current());
    }

    public function render()
    {
        return view('admin::form.form', ['form' => $this]);
    }
}