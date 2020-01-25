<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\TicketRequest;
use App\Models\Contact;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class TicketCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class TicketCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\RevisionsOperation;


    public function setup()
    {
        $this->crud->setModel('App\Models\Ticket');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/ticket');
        $this->crud->setEntityNameStrings('ticket', 'tickets');
        $this->crud->addButtonFromView('line', 'assign', 'assign', 'beginning');


    }

    protected function setupListOperation()
    {
        // TODO: remove setFromDb() and manually define Columns, maybe Filters
//        $this->crud->setFromDb();
//        $this->crud->enableBulkActions();
        $this->crud->addFilter([
            'name' => 'status',
            'type' => 'dropdown',
            'label'=> 'Status'
        ], [
            'new' => 'Nouveau',
            'pending' => 'En cours',
            'completed' => 'cloturé',
            'canceled' => 'annulé',
        ], function($value) { // if the filter is active
             $this->crud->addClause('where', 'status', $value);
        });
        $this->crud->addFilter([
            'type'  => 'date_range',
            'name'  => 'from_to',
            'label' => 'Date de creation'
        ],
            false,
            function ($value) { // if the filter is active, apply these constraints
                 $dates = json_decode($value);
                 $this->crud->addClause('where', 'created_at', '>=', $dates->from);
                 $this->crud->addClause('where', 'created_at', '<=', $dates->to . ' 23:59:59');
            });
        $this->crud->addColumn([
            'name' => 'name', // The db column name
            'label' => "Nom de ticket", // Table column heading
            'type' => 'text'
        ]);
        $this->crud->addColumn([
            'label' => "Pack", // Table column heading
            'type' => "select",
            'name' => 'pack_id', // the column that contains the ID of that connected entity;
            'entity' => 'pack', // the method that defines the relationship in your Model
            'attribute' => "name", // foreign key attribute that is shown to user
            'model' => "App\Models\Pack", // foreign key model
        ]);
        $this->crud->addColumn([
        'label' => "Assigner a ", // Table column heading
        'type' => "select",
        'name' => 'user_id', // the column that contains the ID of that connected entity;
        'entity' => 'user', // the method that defines the relationship in your Model
        'attribute' => "name", // foreign key attribute that is shown to user
        'model' => "App\Models\User", // foreign key model
        ]);
//        $this->crud->addColumn([
//        'name' => 'address', // The db column name
//        'label' => "address", // Table column heading
//        'type' => 'array'
//        ]);
    }
    public function assign()
    {
        return view("welcome");
    }
    protected function setupCreateOperation()
    {
        $this->crud->setValidation(TicketRequest::class);

        // TODO: remove setFromDb() and manually define Fields
      //  $this->crud->setFromDb();
        $this->crud->addField([
            'name' => 'name',
            'type' => 'text',
            'label' => "Nom de ticket"  ,
            'tab'   => trans('ticket.general_tab'),

        ]);
        $this->crud->addField([
            'name' => 'description',
            'type' => 'ckeditor',
            'label' => "description"  ,
            'tab'   => trans('ticket.general_tab'),

        ]);
        $this->crud->addField(
            [
                'label' => "Pack",
                'type' => 'select',
                'name' => 'pack_id', // the db column for the foreign key
                'entity' => 'pack', // the method that defines the relationship in your Model
                'attribute' => 'name', // foreign key attribute that is shown to user
                'model' => "App\Models\Pack",
                'tab'   => trans('ticket.general_tab'),

            ]
        );
        $this->crud->addField(
            [
                'label' => "Assigner à",
                'type' => 'select',
                'name' => 'user_id', // the db column for the foreign key
                'entity' => 'user', // the method that defines the relationship in your Model
                'attribute' => 'name', // foreign key attribute that is shown to user
                'model' => "App\User",
                'tab'   => trans('ticket.general_tab'),

            ]
        );
        $this->crud->addField([   // select_and_order
            'name' => 'contacts',
            'label' => "Listes des contacts",
            'type' => 'select_and_order',
            'options' => Contact::get()->pluck('name','id')->toArray(),
            'tab'   => trans('ticket.contact_tab'),

        ]);
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
