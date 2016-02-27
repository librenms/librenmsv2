Developing
==========


[Laravel Documentation](https://laravel.com/docs)



Overview
--------

### Data flow
Database->Model->API Controller->Web Controller


### Structure
We follow [Laravel's file structure](https://laravel.com/docs/structure)


#### Database
Use the same schema as the current LibreNMS so we can co-exist.
If changes need to be made, the need to be made in both.

#### Model
The models reside in _/app_ and use [Eloquent ORM](https://laravel.com/docs/eloquent) for database access.

#### API Controller
The API controllers reside in _/app/Api/Controllers_.
Routes are defined in the same file as the web interface _/app/Http/routes.php_. TODO
The API uses [Dingo](https://github.com/dingo/api/wiki) to service the API requests.

#### Web Controller
The web controllers reside in _/app/Http/Controllers_.
Routes are defined in the _/app/Http/routes.php_ file.
The connects to the API for all data requests, do not access the Models or Database from the Web Controler.
Accessing data from the API should use [internal requests](https://github.com/dingo/api/wiki/Internal-Requests) to avoid a web server round trip.

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
WIP: There is single file _js/util.js_ at this time.  It encapsulates all methods in a Util object to provide a namespace to avoid conflicts.


Rendering Data
--------------
There are several points along the data flow that you have opportunities to modify the data.
This is some guidance on where might be best to perform these operations.


### Model
Required simple data transforms like ip and datetime.
Use [Eloquent Accessors/Mutators](https://laravel.com/docs/eloquent-mutators#accessors-and-mutators)

### API
Data that will be displayed in a table (especially with ajax)
Use _requestFormat_ to determine if html should be sent.
Inject into the current data along side the raw data if requested.

### Web Controller
For data that is just a single entity (non-tabular).


### Javascript / Datatables
Use javascript to make simple data human readable such as bits per second
[Datatables](https://www.datatables.net/manual/index) can be used to hide raw data, yet make it searchable/sortable and apply JS formatting.

