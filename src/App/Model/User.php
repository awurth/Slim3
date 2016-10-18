<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Capsule\Manager;
use Illuminate\Database\Schema\Blueprint;

class User extends Model
{
    protected $table = 'user';

    protected $primaryKey = 'id';

    public static function createTable()
    {
        Manager::schema()->create('user', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamps();
        });
    }
}