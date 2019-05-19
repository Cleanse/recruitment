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
            'name' => 'Recruitment Plugin',
            'description' => 'Provides a recruitment board for users.',
            'author' => 'Paul E. Lovato',
            'icon' => 'icon-address-card-o'
        ];
    }

    public function registerComponents()
    {
        return [
            //public
            'Cleanse\Recruitment\Components\Home' => 'cleanseRecruitmentHome',
            
            'Cleanse\Recruitment\Components\PlayerCreate' => 'cleanseRecruitmentCreatePlayer',
            'Cleanse\Recruitment\Components\PlayerProfile' => 'cleanseRecruitmentProfilePlayer',
            'Cleanse\Recruitment\Components\ListPlayers' => 'cleanseRecruitmentListPlayers',

            'Cleanse\Recruitment\Components\CreateTeam' => 'cleanseRecruitmentCreateTeam',
            'Cleanse\Recruitment\Components\TeamProfile' => 'cleanseRecruitmentProfileTeam',
            'Cleanse\Recruitment\Components\ListTeams' => 'cleanseRecruitmentListTeams',

            //user
            'Cleanse\Recruitment\Components\ManageTeam' => 'cleanseRecruitmentManageTeam',
            'Cleanse\Recruitment\Components\ManagePlayer' => 'cleanseRecruitmentManagePlayer',

            //admin - move into /backend?
            'Cleanse\Recruitment\Components\AdminTeams' => 'cleanseRecruitmentAdminTeams',
            'Cleanse\Recruitment\Components\AdminPlayers' => 'cleanseRecruitmentAdminPlayers',
        ];
    }
}
