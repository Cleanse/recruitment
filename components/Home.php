<?php

namespace Cleanse\Recruitment\Components;

use Auth;
use Cms\Classes\ComponentBase;

use Cleanse\Recruitment\Models\Player;
use Cleanse\Recruitment\Models\Team;

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
        if (isset(Auth::getUser()->id)) {
            $this->page['user_teams'] = $this->getUserTeams();
            $this->page['user_characters'] = $this->getUserPlayers();
        }

        $this->addCss('assets/css/recruitment.css?v2');
    }

    private function getUserTeams()
    {
        return Team::where('user_id', '=', Auth::getUser()->id)->get();
    }

    private function getUserPlayers()
    {
        return Player::where('user_id', '=', Auth::getUser()->id)->get();
    }
}
