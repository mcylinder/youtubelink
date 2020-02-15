<?php

namespace App\Models;


use A17\Twill\Models\Model;

class Link extends Model
{


    protected $fillable = [

        'title',
        'hash',
        'count'
    ];

}
