<?php

namespace Cleanse\Recruitment\Components;

use Cms\Classes\ComponentBase;

use Cleanse\Recruitment\Models\Team;

class CreateTeam extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'Recruitment Create Team',
            'description' => 'Create a team for the recruitment system.'
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
