<?php

namespace App\Providers;

use Illuminate\Routing\Router;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Form;

class HtmlFormServiceProvider extends ServiceProvider
{

    public function boot(Router $router)
    {
        //
        Form::component('bsPassword', 'components.form.horiz-password', ['name', 'attributes' => [], 'class' => null, 'label_class' => null]);
        Form::component('bsHorizSubmit', 'components.form.horiz-submit', ['name', 'class']);
        parent::boot($router);
    }

    public function map()
    {

    }

}
