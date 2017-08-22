<?php
/**
 * Created by PhpStorm.
 * User: kvark
 * Date: 22/08/17
 * Time: 15:30
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserTime extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'action',
    ];

}