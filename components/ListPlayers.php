<?php

namespace Cleanse\Recruitment\Components;

use Redirect;
use Cms\Classes\ComponentBase;

use Cleanse\Recruitment\Models\Player;

class ListPlayers extends ComponentBase
{
    private $roles;
    private $dcs;
    private $regions;

    public function componentDetails()
    {
        return [
            'name' => 'Recruitment Player List',
            'description' => 'Player list in the recruitment system.'
        ];
    }

    public function onRun()
    {
        $this->page['players'] = $this->checkFilter();

        $this->addCss('assets/css/recruitment.css');
        $this->addJs('assets/js/recruitment.js');
    }

    public function onFilterPlayers()
    {
        $this->page['players'] = $this->checkFilter();
    }

    private function checkFilter()
    {
        $this->roles   = get('roles');
        $this->regions = get('regions');
        $this->dcs     = get('datacenters');

        if (!$this->roles && !$this->regions && !$this->dcs) {
            return $this->page['players'] = $this->getPlayerList();
        }

        return $this->createFromURL();
    }

    private function createFromURL()
    {
        $players = Player::where('recruited', '=', 0);

        if (!is_null(get('roles')) && !empty(get('roles'))) {
            $jobs = explode(",", get('roles'));

            $i = 1;
            foreach ($jobs as $job) {
                if ($i === 1) {
                    $players->where("roles", "like", "%\"{$job}\"%");
                } else {
                    $players->orWhere("roles", "like", "%\"{$job}\"%");
                }

                $i++;
            }
        }

        $regionsList = [];
        if (!is_null(get('datacenters')) && !empty(get('datacenters'))) {
            $regionsList[] = explode(",", get('datacenters'));
        }

        if (!is_null(get('regions')) && !empty(get('regions'))) {
            $regions = explode(",", get('regions'));

            foreach ($regions as $region) {
                $regionsList[] = $this->getByRegion($region);
            }
        }

        if (count($regionsList) > 0) {
            $a = [];
            foreach ($regionsList as $r) {
                foreach ($r as $key => $value) {
                    $a[] = $value;
                }
            }

            $players->whereIn('datacenter', array_unique($a));
        }

        return $players->get();
    }
    
    private function getPlayerList()
    {
        return Player::where([
            'recruited' => 0
        ])->get();
    }

    private function getByRegion($region)
    {
        $regionKeys = ['eu', 'jp', 'na'];

        if ($region && !in_array($region, $regionKeys)) {
            return false;
        }

        $regions = [
            'eu' => ['chaos', 'light'],
            'jp' => ['elemental', 'gaia', 'mana'],
            'na' => ['aether', 'crystal', 'primal']
        ];

        return $regions[$region];
    }
}
