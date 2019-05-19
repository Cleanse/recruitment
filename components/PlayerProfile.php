<?php

namespace Cleanse\Recruitment\Components;

use Cms\Classes\ComponentBase;

use Cleanse\Recruitment\Models\Player;

class PlayerProfile extends ComponentBase
{
    private $player;

    public function componentDetails()
    {
        return [
            'name' => 'View Player Profile',
            'description' => 'Displays a player profile.'
        ];
    }

    public function defineProperties()
    {
        return [
            'player' => [
                'title'       => 'Player Slug',
                'description' => 'Player identification.',
                'default'     => '{{ :player }}',
                'type'        => 'string',
            ]
        ];
    }

    public function onRun()
    {
        $this->player = $this->page['player'] = $this->getPlayerData();

        if (!$this->player) {
            return Redirect::to('/recruitment/players');
        }
    }

    private function getPlayerData()
    {
        $slug = $this->property('player');

        $player = Player::where('slug', '=', $slug)->first();

        return $player;
    }
}
