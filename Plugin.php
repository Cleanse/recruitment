<?php

namespace Cleanse\Recruitment;

use System\Classes\PluginBase;

/**
 * Recruitment Plugin Information File
 */
class Plugin extends PluginBase
{
    public $require = ['Cleanse.User'];

    public function pluginDetails()
    {
        return [
            'name'        => 'Recruitment Plugin',
            'description' => 'Provides a recruitment board for users.',
            'author'      => 'Paul E. Lovato',
            'icon'        => 'icon-address-card-o'
        ];
    }

    public function registerComponents()
    {
        return [
            //public
            'Cleanse\Recruitment\Components\Home'          => 'cleanseRecruitmentHome',
            'Cleanse\Recruitment\Components\Report'        => 'cleanseRecruitmentReport',
            'Cleanse\Recruitment\Components\ProfilePlayer' => 'cleanseRecruitmentProfilePlayer',
            'Cleanse\Recruitment\Components\ListPlayers'   => 'cleanseRecruitmentListPlayers',
            'Cleanse\Recruitment\Components\ProfileTeam'   => 'cleanseRecruitmentProfileTeam',
            'Cleanse\Recruitment\Components\ListTeams'     => 'cleanseRecruitmentListTeams',

            //Requires Auth
            'Cleanse\Recruitment\Components\Profile'       => 'cleanseRecruitmentProfile',
            'Cleanse\Recruitment\Components\CreateTeam'    => 'cleanseRecruitmentCreateTeam',
            'Cleanse\Recruitment\Components\ManageTeam'    => 'cleanseRecruitmentManageTeam',
            'Cleanse\Recruitment\Components\CreatePlayer'  => 'cleanseRecruitmentCreatePlayer',
            'Cleanse\Recruitment\Components\ManagePlayer'  => 'cleanseRecruitmentManagePlayer'
        ];
    }
}
