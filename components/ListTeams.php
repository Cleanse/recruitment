<?php

namespace Cleanse\Recruitment\Components;

use Cms\Classes\ComponentBase;

use Cleanse\Recruitment\Models\Team;

class ListTeams extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'Recruitment Team List',
            'description' => 'Team list in the recruitment system.'
        ];
    }

    public function onRun()
    {
        $this->page['teams'] = $this->getTeamList();
    }
    
    private function getTeamList()
    {
        return [];
        return Team::all();
    }
}
