<?php

namespace Cleanse\Recruitment\Components;

use Redirect;
use Cms\Classes\ComponentBase;

use Cleanse\Recruitment\Models\Team;

class ListTeams extends ComponentBase
{
    private $filter;
    private $value;

    public function componentDetails()
    {
        return [
            'name' => 'Recruitment Team List',
            'description' => 'Team list in the recruitment system.'
        ];
    }

    public function defineProperties()
    {
        return [
            'filter' => [
                'title'       => 'Filter By',
                'description' => 'Filter identification.',
                'default'     => '{{ :filter }}',
                'type'        => 'string',
            ],
            'value' => [
                'title'       => 'Filter Value',
                'description' => 'The team filter value.',
                'default'     => '{{ :value }}',
                'type'        => 'string',
            ]
        ];
    }

    public function onRun()
    {
        $this->filter = $this->property('filter');
        $this->checkFilter();

        $this->addCss('assets/css/recruitment.css');
    }

    private function checkFilter()
    {
        $filters = ['role', 'datacenter', 'region'];

        if (!$this->filter && !in_array($this->filter, $filters)) {
            return $this->page['teams'] = $this->getTeamList();
        }

        $runFilter = 'getBy' . ucfirst($this->filter);

        $this->$runFilter();
    }
    
    private function getTeamList()
    {
        return Team::where([
            'recruiting' => 1
        ])->get();
    }

    private function getByRole()
    {
        $this->value = $this->property('value');
        $roles = ['tank', 'healer', 'melee', 'ranged'];

        if ($this->value && !in_array($this->value, $roles)) {
            return false;
        }

        return $this->page['teams'] = Team::where('recruiting', '=', 1)
            ->where('availability', 'like', '%'.$this->value.'%')->get();
    }

    private function getByDatacenter()
    {
        $this->value = $this->property('value');
        $dcs = [
            'aether',
            'chaos',
            'crystal',
            'elemental',
            'gaia',
            'light',
            'mana',
            'primal'
        ];

        if ($this->value && !in_array($this->value, $dcs)) {
            return false;
        }

        return $this->page['teams'] = Team::where('recruiting', '=', 1)
            ->where('datacenter', '=', $this->value)->get();
    }

    private function getByRegion()
    {
        $this->value = $this->property('value');
        $regionKeys = ['eu', 'jp', 'na'];

        if ($this->value && !in_array($this->value, $regionKeys)) {
            return false;
        }

        $regions = [
            'eu' => ['chaos', 'light'],
            'jp' => ['elemental', 'gaia', 'mana'],
            'na' => ['aether', 'crystal', 'primal']
        ];

        return $this->page['teams'] = Team::where('recruiting', '=', 1)
            ->whereIn('datacenter', $regions[$this->value])->get();
    }
}
