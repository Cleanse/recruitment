<?php

namespace Cleanse\Recruitment\Components;

use Auth;
use Redirect;
use Cms\Classes\ComponentBase;

use Cleanse\Recruitment\Models\Team;

class CreateTeam extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'Recruitment Create Team',
            'description' => 'Create a team for the recruitment board.'
        ];
    }

    public function onRun()
    {
        //add check to see when the last team was created by user
        //Initial idea, after 10 teams run the check or report said user.
    }

    public function onCreateTeam()
    {
        $post = post();
        $team = $this->createTeam($post);

        return Redirect::to('/recruitment/team/' . $team->slug . '/manage');
    }

    private function createTeam($post)
    {
        $newTeam = new Team;

        $newTeam->name           = $post['name'];
        $newTeam->user_id        = Auth::getUser()->id;
        $newTeam->datacenter     = $post['datacenter'];
        $newTeam->contact_method = $post['contact'];
        $newTeam->description    = $post['description'];
        $newTeam->availability   = $post['roles'];
        $newTeam->recruiting     = 1;

        $newTeam->save();

        return $newTeam;
    }
}
