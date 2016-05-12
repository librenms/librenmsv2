<?php

namespace App\Providers;

use Illuminate\Routing\Router;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Form;

class HtmlFormServiceProvider extends ServiceProvider
{

    public function boot(Router $router)
    {
        Form::component('bsPassword', 'components.form.horiz-password', ['name', 'attributes' => [], 'class' => null, 'label' => null]);
        Form::component('bsSelect', 'components.form.horiz-select', ['name', 'values' => [], 'selected' => null, 'label' => null]);
        Form::component('bsSubmit', 'components.form.horiz-submit', ['name', 'class']);
        Form::component('bsText', 'components.form.horiz-text', ['name', 'value', 'attributes' => [], 'class' => null, 'label' => null]);

        parent::boot($router);
    }

    public function map()
    {

    }

}
