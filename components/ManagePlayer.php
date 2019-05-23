<?php

namespace Cleanse\Recruitment\Components;

use Auth;
use Redirect;
use Cms\Classes\ComponentBase;

use Cleanse\Recruitment\Classes\HelperDatacenter;
use Cleanse\Recruitment\Models\Player;

class ManagePlayer extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'Recruitment Manage Player',
            'description' => 'Manage a player for the recruitment board.'
        ];
    }

    public function defineProperties()
    {
        return [
            'slug' => [
                'title' => 'Player Slug',
                'description' => 'Player identification.',
                'default' => '{{ :slug }}',
                'type' => 'string',
            ]
        ];
    }

    public function onRun()
    {
        $slug = $this->property('slug');
        $player = $this->getPlayer($slug);

        if (!isset($player)) {
            return Redirect::to('/recruitment/player/' . $slug);
        }

        $this->page['player'] = $player;
        $this->page['servers'] = $this->getServerList();

        $this->addCss('assets/css/recruitment.css');
    }

    public function onUpdatePlayer()
    {
        $post = post();
        $player = $this->updatePlayer($post);

        if ($player === false) {
            return Redirect::to('/recruitment');
        }

        return Redirect::to('/recruitment/player/' . $player->slug . '/manage');
    }

    public function onStopRecruiting()
    {
        $post = post();
        $player = $this->stopRecruiting($post);

        if ($player === false) {
            return Redirect::to('/recruitment');
        }

        return Redirect::to('/recruitment/player/' . $player->slug . '/manage');
    }

    public function onDeletePlayer()
    {
        $post = post();
        $this->deletePlayer($post);

        return Redirect::to('/recruitment');
    }

    private function getPlayer($slug)
    {
        return Player::where([
            'slug' => $slug,
            'user_id' => Auth::getUser()->id
        ])->first();
    }

    private function updatePlayer($post)
    {
        $updatePlayer = Player::where([
            'id' => $post['player_id'],
            'user_id' => Auth::getUser()->id
        ])->first();

        if (!isset($updatePlayer)) {
            return false;
        }

        $updatePlayer->name           = $post['name'];
        $updatePlayer->server         = $post['server'];
        $updatePlayer->datacenter     = strtolower($this->serverToDatacenter($post['server']));
        $updatePlayer->roles          = $post['roles'];
        $updatePlayer->contact_method = $post['contact'];
        $updatePlayer->profile        = $post['description'];

        $updatePlayer->save();

        return $updatePlayer;
    }

    private function stopRecruiting($post)
    {
        $updatePlayer = Player::where([
            'id' => $post['player_id'],
            'user_id' => Auth::getUser()->id
        ])->first();

        if (!isset($updatePlayer)) {
            return false;
        }

        if ($updatePlayer->recruited === 0) {
            $updatePlayer->recruited = 1;
        } else {
            $updatePlayer->recruited = 0;
        }

        $updatePlayer->save();

        return $updatePlayer;
    }

    private function deletePlayer($post)
    {
        $deletePlayer = Player::where([
            'id' => $post['player_id'],
            'user_id' => Auth::getUser()->id
        ])->first();

        if (!isset($deletePlayer)) {
            return false;
        }

        $deletePlayer->delete();
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
