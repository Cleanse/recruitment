<?php

namespace Cleanse\Recruitment\Components;

use Auth;
use Redirect;
use Cms\Classes\ComponentBase;

use Cleanse\Recruitment\Models\Team;

class ManageTeam extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'Recruitment Manage Team',
            'description' => 'Manage a team for the recruitment board.'
        ];
    }

    public function defineProperties()
    {
        return [
            'slug' => [
                'title' => 'Team Slug',
                'description' => 'Team identification.',
                'default' => '{{ :slug }}',
                'type' => 'string',
            ]
        ];
    }

    public function onRun()
    {
        $slug = $this->property('slug');
        $team = $this->getTeam($slug);

        if (!isset($team)) {
            return Redirect::to('/recruitment/team/' . $slug);
        }

        $this->page['team'] = $team;
    }

    public function onUpdateTeam()
    {
        $post = post();
        $team = $this->updateTeam($post);

        if ($team === false) {
            return Redirect::to('/recruitment');
        }

        return Redirect::to('/recruitment/team/' . $team->slug . '/manage');
    }

    public function onStopRecruiting()
    {
        $post = post();
        $team = $this->stopRecruiting($post);

        if ($team === false) {
            return Redirect::to('/recruitment');
        }

        return Redirect::to('/recruitment/team/' . $team->slug . '/manage');
    }

    private function getTeam($slug)
    {
        return Team::where([
            'slug' => $slug,
            'user_id' => Auth::getUser()->id
        ])->first();
    }

    private function updateTeam($post)
    {
        $updateTeam = Team::where([
            'id' => $post['team_id'],
            'user_id' => Auth::getUser()->id
        ])->first();

        if (!isset($updateTeam)) {
            return false;
        }

        $updateTeam->name = $post['name'];
        $updateTeam->datacenter = $post['datacenter'];
        $updateTeam->contact_method = $post['contact'];
        $updateTeam->description = $post['description'];
        $updateTeam->availability = $post['roles'];

        $updateTeam->save();

        return $updateTeam;
    }

    private function stopRecruiting($post)
    {
        $updateTeam = Team::where([
            'id' => $post['team_id'],
            'user_id' => Auth::getUser()->id
        ])->first();

        if (!isset($updateTeam)) {
            return false;
        }

        if ($updateTeam->recruiting === 0) {
            $updateTeam->recruiting = 1;
        } else {
            $updateTeam->recruiting = 0;
        }

        $updateTeam->save();

        return $updateTeam;
    }
}
