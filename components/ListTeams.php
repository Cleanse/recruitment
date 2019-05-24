<?php

namespace Cleanse\Recruitment\Components;

use Redirect;
use Cms\Classes\ComponentBase;

use Cleanse\Recruitment\Models\Team;

class ListTeams extends ComponentBase
{
    private $roles;
    private $dcs;
    private $regions;

    public function componentDetails()
    {
        return [
            'name' => 'Recruitment Team List',
            'description' => 'Team list in the recruitment system.'
        ];
    }

    public function onRun()
    {
        $this->page['teams'] = $this->checkFilter();

        $this->addCss('assets/css/recruitment.css');
        $this->addJs('assets/js/recruitment.js');
    }

    public function onFilterTeams()
    {
        $this->page['teams'] = $this->checkFilter();
    }

    private function checkFilter()
    {
        $this->roles   = get('roles');
        $this->regions = get('regions');
        $this->dcs     = get('datacenters');

        if (!$this->roles && !$this->regions && !$this->dcs) {
            return $this->page['teams'] = $this->getTeamList();
        }

        return $this->createFromURL();
    }

    private function getTeamList()
    {
        return Team::where(['recruiting' => 1])
            ->orderBy('name', 'asc')
            ->get();
    }

    private function createFromURL()
    {
        $teams = Team::where('recruiting', '=', 1);

        if (!is_null(get('roles')) && !empty(get('roles'))) {
            $jobs = explode(",", get('roles'));

            $i = 1;
            foreach ($jobs as $job) {
                if ($i === 1) {
                    $teams->where('availability', 'like', '%'.$job.'%');
                } else {
                    $teams->orWhere(function($query) use ($job)
                    {
                        $query->where('recruiting', '=', 1)
                              ->where('availability', 'like', '%'.$job.'%');
                    });
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

            $teams->whereIn('datacenter', array_unique($a));
        }

        $teams->orderBy('name', 'asc');
        return $teams->get();
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
