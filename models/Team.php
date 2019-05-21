<?php

namespace Cleanse\Recruitment\Models;

use Model;

/**
 * Class Team
 * @package Cleanse\Recruitment\Models
 * @property integer user_id
 * @property string  name
 * @property string  slug
 * @property string  datacenter
 * @property string  contact_method
 * @property string  description
 * @property string  availability
 * @property boolean recruiting
 */
class Team extends Model
{
    use \October\Rain\Database\Traits\Sluggable;

    protected $table = 'cleanse_recruitment_teams';

    protected $slugs = ['slug' => ['name', 'datacenter']];

    protected $casts = [
        'availability' => 'array',
    ];
}
