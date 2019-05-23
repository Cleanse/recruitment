<?php

namespace Cleanse\Recruitment\Components;

use Redirect;
use Cms\Classes\ComponentBase;

use Cleanse\Recruitment\Models\Team;

class ProfileTeam extends ComponentBase
{
    private $team;

    public function componentDetails()
    {
        return [
            'name' => 'View Team Profile',
            'description' => 'Displays a team profile.'
        ];
    }

    public function defineProperties()
    {
        return [
            'slug' => [
                'title'       => 'Team Slug',
                'description' => 'Team identification.',
                'default'     => '{{ :slug }}',
                'type'        => 'string',
            ]
        ];
    }

    public function onRun()
    {
        $this->team = $this->page['team'] = $this->getTeamData();

        if (!$this->team) {
            return Redirect::to('/recruitment/teams');
        }

        $this->addCss('assets/css/recruitment.css');
    }

    private function getTeamData()
    {
        $slug = $this->property('slug');

        $team = Team::where([
            'slug' => $slug,
            'recruiting' => 1
        ])->first();

        return $team;
    }
}
