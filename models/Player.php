<?php

namespace Cleanse\Recruitment\Models;

use Model;

/**
 * Class Player
 * @package Cleanse\Recruitment\Models
 * @property integer user_id
 * @property string  name
 * @property string  server
 * @property string  datacenter
 * @property string  roles
 * @property string  contact_method
 * @property string  profile
 * @property boolean recruited
 */
class Player extends Model
{
    use \October\Rain\Database\Traits\Sluggable;

    protected $table = 'cleanse_recruitment_players';

    protected $slugs = ['slug' => ['name', 'server']];

    protected $casts = [
        'roles' => 'array',
    ];
}
