<?php

namespace Sova\Admin\Http\Controllers;


use Sova\Admin\AdminResource;
use Sova\Admin\Form\ResourceForm;
use Sova\Admin\Models\Resource;

class ResourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin::resource.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(AdminResource $resource)
    {
        $form = $resource->getForm();

        return view('admin::resource.form', compact('form'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Resource  $resource
     * @return \Illuminate\Http\Response
     */
    public function store(Resource $resource)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(AdminResource $resource)
    {
        $form = $resource->getForm();

        return view('admin::resource.form', compact('form'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Resource  $resource
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Resource $resource, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}