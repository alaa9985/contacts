<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PackRequest;
use App\Models\Attribute;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class PackCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PackCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\Pack');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/pack');
        $this->crud->setEntityNameStrings('pack', 'packs');
    }

    protected function setupListOperation()
    {
        // TODO: remove setFromDb() and manually define Columns, maybe Filters
        $this->crud->addColumn([
            'name' => 'name', // The db column name
            'label' => trans('pack.name'),
            'type' => 'text'
        ]);
        
    }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(PackRequest::class);

        // TODO: remove setFromDb() and manually define Fields
        $this->crud->addField([
            'name' => 'name',
            'type' => 'text',
            'label' => "Nom du pack"  ,
        ]);
        $this->crud->addField([   // select_and_order
            'name' => 'attributes',
            'label' => "Listes des attributs",
            'type' => 'select_and_order',
            'options' => Attribute::get()->pluck('label','id')->toArray(),
            //'tab'   => trans('pack.attributes_tab'),

        ]);
        //$this->crud->setFromDb();
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
