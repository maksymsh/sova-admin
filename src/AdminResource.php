<?php

namespace Sova\Admin;

class AdminResource
{
    protected $model;
    protected $form;
    protected $tabel;



    public function __construct()
    {

    }

    /**
     * @return mixed
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param mixed $model
     */
    public function setModel($model): void
    {
        $this->model = $model;
    }

    /**
     * @return mixed
     */
    public function getForm()
    {
        return $this->form ?: $this->form = app('admin-form');
    }

    /**
     * @param mixed $form
     */
    public function setForm($form): void
    {
        $this->form = $form;
    }

    /**
     * @return mixed
     */
    public function getTabel()
    {
        return $this->tabel;
    }

    /**
     * @param mixed $tabel
     */
    public function setTabel($tabel): void
    {
        $this->tabel = $tabel;
    }



}