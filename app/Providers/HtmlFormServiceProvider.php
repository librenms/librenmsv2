<?php

namespace App\Providers;

use Illuminate\Routing\Router;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Form;

class HtmlFormServiceProvider extends ServiceProvider
{

    public function boot()
    {
        Form::component('bsPassword', 'components.form.horiz-password', ['name', 'attributes' => []]);
        Form::component('bsSelect', 'components.form.horiz-select', ['name', 'values' => [], 'selected' => null, 'attributes' => []]);
        Form::component('bsSubmit', 'components.form.horiz-submit', ['name', 'attributes' => []]);
        Form::component('bsText', 'components.form.horiz-text', ['name', 'value', 'attributes' => []]);

        Form::component('ajaxDynamicText', 'components.form.ajax-dynamic-text', ['name', 'values' => [], 'attributes' => []]);
        Form::component('ajaxRadio', 'components.form.ajax-radio', ['setting', 'label'=>null, 'items' => []]);
        Form::component('ajaxSortable', 'components.form.ajax-sortable', ['setting', 'label'=>null, 'default' => []]);

        parent::boot();
    }

    public function map()
    {

    }

}
