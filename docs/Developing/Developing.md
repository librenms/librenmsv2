Developing
==========


[Laravel Documentation](https://laravel.com/docs)

### Notes
When new depencies are added, you will need to run composer to install them:


Overview
--------

### Data flow
```
Database -> Model -> API Controller -> Web Controller
```


### Structure
* We follow [Laravel's file structure](https://laravel.com/docs/structure)


#### Database
*Use the same schema as the current LibreNMS so we can co-exist.  Migrations codify the schema in _/database/migrations_.
*If schema changes need to be made, they need to be made in both.

#### Model
* The models reside in _/app_ and use [Eloquent ORM](https://laravel.com/docs/eloquent) for database access.

#### API Controller
* The API controllers reside in _/app/Api/Controllers_.
* Routes are defined in the same file as the web interface _/app/Http/routes.php_. TODO
* The API uses [Dingo](https://github.com/dingo/api/wiki) to service the API requests.
* The API use [Fractal Transformers](http://fractal.thephpleague.com/transformers/) to format the responses.  This does not apply to internal requests.

#### Web Controller
* The web controllers reside in _/app/Http/Controllers_.
* Routes are defined in the _/app/Http/routes.php_ file.
* The connects to the API for all data requests, do not access the Models or Database from the Web Controler.

### Blade Templating Engine
[Blade Templates](https://laravel.com/docs/blade)
__Non-trivial (maybe even trivial) HTML should be contained within a blade template file.__
Template files are in _/resources/views_
#### Subfolders
WIP / TODO
* _layout_: the main layout of the website
* _general_: general templates
* _devices_: device related templates
* _ports_: port related templates
* _includes_: generic templates that are used in other templates to save code duplication

### Javascript
* Shared javascript functions should be kept in _js/util.js_ .  It encapsulates all methods in a Util object to provide a namespace to avoid conflicts.
* You can include scripts in page by use the _scripts_ section.


Rendering Data
--------------
There are several points along the data flow that you have opportunities to modify the data.
This is some guidance on where might be best to perform these operations.


### Model
* Required simple data transforms like ip and datetime.
* Use [Eloquent Accessors/Mutators](https://laravel.com/docs/eloquent-mutators#accessors-and-mutators)

### API
* Data that will be displayed in a table (especially with ajax)
* Accessing data from the API should use [internal requests](https://github.com/dingo/api/wiki/Internal-Requests) to avoid a web server round trip.
* WIP (is this useful) Use _requestFormat_ to determine if html should be sent. Inject into the current data along side the raw data if requested.

### Web Controller
* For data that is just a single entity (non-tabular).


### Javascript / Datatables
* Use javascript to make simple data human readable such as bits per second
* [Datatables](https://www.datatables.net/manual/index) can be used to hide raw data, yet make it searchable/sortable and apply JS formatting.
* You can activate datatables on a blade template with `@include('includes.datatables')`  optioninally specifying a table as follows `@include('includes.datatables', $datatables=['mytable'])`


### Web UI
We are using the AdminLTE template.
You can view an example of almost all the widgets available at [https://almsaeedstudio.com](https://almsaeedstudio.com/themes/AdminLTE/index2.html)

PHP Storm
---------

* Follow the [PhpStorm Documentation](https://confluence.jetbrains.com/display/PhpStorm/Laravel+Development+using+PhpStorm) to install the laravel plugin and configure command window completion for composer and artisan.
* Set APP_ENV=development in your .env file. If you need to have separate settings, you can use .env.development.
* Run `php artisan ide-helper` to set up autocomplete. [Laravel IDE Helper](https://github.com/barryvdh/laravel-ide-helper)
* Edit the Copyright and PHP header templates to include your copyright
