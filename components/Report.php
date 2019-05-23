<?php

namespace Cleanse\Recruitment\Components;

use Cms\Classes\ComponentBase;

class Report extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'Recruitment Report Component',
            'description' => 'Report system for recruitment board.'
        ];
    }

    public function onRun(){}
}
