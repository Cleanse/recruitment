<?php

namespace Cleanse\Recruitment\Components;

use Auth;
use Redirect;
use Cms\Classes\ComponentBase;

use Cleanse\Recruitment\Classes\HelperDatacenter;
use Cleanse\Recruitment\Models\Player;

class CreatePlayer extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'Recruitment Create Player',
            'description' => 'Create a player for the recruitment board.'
        ];
    }

    public function onRun()
    {
        $this->page['servers'] = $this->getServerList();

        $this->addCss('assets/css/recruitment.css');
    }

    public function onCreatePlayer()
    {
        $post = post();
        $player = $this->createPlayer($post);

        return Redirect::to('/recruitment/player/' . $player->slug . '/manage');
    }

    private function createPlayer($post)
    {
        $newPlayer = new Player;

        $newPlayer->name           = $post['name'];
        $newPlayer->user_id        = Auth::getUser()->id;
        $newPlayer->server         = $post['server'];
        $newPlayer->datacenter     = strtolower($this->serverToDatacenter($post['server']));
        $newPlayer->roles          = $post['roles'];
        $newPlayer->contact_method = $post['contact'];
        $newPlayer->profile        = $post['description'];
        $newPlayer->recruited      = 0;

        $newPlayer->save();

        return $newPlayer;
    }

    private function getServerList()
    {
        $datacenters = new HelperDatacenter;

        $servers = [];
        foreach ($datacenters->datacenters as $dc) {
            foreach ($dc as $server) {
                $servers[] = $server;
            }
        }

        return collect($servers)->sort();
    }

    private function serverToDatacenter($server)
    {
        $helper = new HelperDatacenter;
        return $helper->getDC(ucfirst($server));
    }
}
