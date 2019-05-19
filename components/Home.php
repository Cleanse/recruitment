<?php

namespace Cleanse\Recruitment\Components;

use Cms\Classes\ComponentBase;

class Home extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'Recruitment Home',
            'description' => 'Gateway to the recruitment system.'
        ];
    }

    public function onRun()
    {
        //
    }
}
