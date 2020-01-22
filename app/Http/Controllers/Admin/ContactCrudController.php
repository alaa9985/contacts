<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ContactRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ContactCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ContactCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\RevisionsOperation;


    public function setup()
    {
        $this->crud->setModel('App\Models\Contact');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/contact');
        $this->crud->setEntityNameStrings('contact', 'contacts');
    }

    protected function setupListOperation()
    {
        // TODO: remove setFromDb() and manually define Columns, maybe Filters
//        $this->crud->setFromDb();

        $this->crud->addColumn([
            'name' => 'profilePicture', // The db column name
            'label' => "Profile image", // Table column heading
            'type' => 'image',
             'height' => '30px',
             'width' => '30px',
        ]);
        $this->crud->addColumn([
            'name' => 'name', // The db column name
            'label' => "name", // Table column heading
            'type' => 'text'
        ]);
        $this->crud->addColumn([
            'name' => 'phoneNumber', // The db column name
            'label' => "Phone number", // Table column heading
            'type' => 'phone',
        ]);
        $this->crud->addColumn([
            'name' => 'email', // The db column name
            'label' => "Email Address", // Table column heading
            'type' => 'email',
            // 'limit' => 500, // if you want to truncate the text to a different number of cha
        ]);
        $this->crud->addColumn([
            'name' => "birthday", // The db column name
            'label' => "Date de naissance", // Table column heading
            'type' => "date",
        ]);
    }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(ContactRequest::class);

        // TODO: remove setFromDb() and manually define Fields
        // $this->crud->setFromDb();

        $this->crud->addField([
            'name' => 'name',
            'type' => 'text',
            'label' => "Tag name"  ,
        ]);
        $this->crud->addField([
            'name' => 'email',
            'label' => 'Address mail',
            'type' => 'email'
        ]);
        $this->crud->addField([
            'name' => 'phoneNumber',
            'label' => 'phoneNumber',
            'type' => 'number',
        ]);
        $this->crud->addField([
            'label' => "Profile Image",
            'name' => "profilePicture",
            'filename' => "image_filename", // set to null if not needed
            'type' => 'base64_image',
            'aspect_ratio' => 1, // set to 0 to allow any aspect ratio
            'crop' => true, // set to true to allow cropping, false to disable
            'src' => NULL, // null to read straight from DB, otherwise set to model accessor function
        ]);
        $this->crud->addField([
            'name' => 'address',
            'label' => 'Address',
            'type' => 'address_algolia',
            // optional
            'store_as_json' => true
        ]);
        $this->crud->addField(
            [
                'name' => 'birthday',
                'type' => 'date_picker',
                'label' => 'Date',
                // optional:
                'date_picker_options' => [
                    'todayBtn' => 'linked',
                    'format' => 'dd-mm-yyyy',
                    'language' => 'fr'
                ],
            ]
        );


    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
    protected function ShowOperation()
    {
        $this->setupListOperation();
    }
}
