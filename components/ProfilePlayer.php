<?php

namespace Cleanse\Recruitment\Components;

use Cms\Classes\ComponentBase;

use Cleanse\Recruitment\Models\Player;

class ProfilePlayer extends ComponentBase
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
            'character' => [
                'title'       => 'Player Slug',
                'description' => 'Player identification.',
                'default'     => '{{ :character }}',
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

        $this->addCss('assets/css/recruitment.css');
    }

    private function getPlayerData()
    {
        $slug = $this->property('character');

        $player = Player::where([
            'slug'      => $slug,
            'recruited' => 0
        ])->first();

        return $player;
    }
}
