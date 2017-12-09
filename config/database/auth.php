<?php

use Cartalyst\Sentinel\Native\Facades\Sentinel;
use Cartalyst\Sentinel\Native\SentinelBootstrapper;
use Illuminate\Database\Capsule\Manager;
use Illuminate\Database\Schema\Blueprint;

$sentinel = (new Sentinel(new SentinelBootstrapper(__DIR__.'/../sentinel.php')))->getSentinel();

Manager::schema()->create('user', function (Blueprint $table) {
    $table->increments('id');
    $table->string('username')->unique();
    $table->string('email')->unique();
    $table->string('password');
    $table->string('last_name')->nullable();
    $table->string('first_name')->nullable();
    $table->text('permissions');
    $table->timestamp('last_login');
    $table->timestamps();
});

Manager::schema()->create('activations', function (Blueprint $table) {
    $table->increments('id');
    $table->unsignedInteger('user_id');
    $table->string('code');
    $table->boolean('completed')->default(0);
    $table->timestamp('completed_at')->nullable();
    $table->timestamps();
    $table->foreign('user_id')->references('id')->on('user');
});

Manager::schema()->create('persistences', function (Blueprint $table) {
    $table->increments('id');
    $table->unsignedInteger('user_id');
    $table->string('code')->unique();
    $table->timestamps();
    $table->foreign('user_id')->references('id')->on('user');
});

Manager::schema()->create('reminders', function (Blueprint $table) {
    $table->increments('id');
    $table->unsignedInteger('user_id');
    $table->string('code');
    $table->boolean('completed')->default(0);
    $table->timestamp('completed_at')->nullable();
    $table->timestamps();
    $table->foreign('user_id')->references('id')->on('user');
});

Manager::schema()->create('roles', function (Blueprint $table) {
    $table->increments('id');
    $table->string('slug')->unique();
    $table->string('name');
    $table->text('permissions');
    $table->timestamps();
});

Manager::schema()->create('role_users', function (Blueprint $table) {
    $table->unsignedInteger('user_id');
    $table->unsignedInteger('role_id');
    $table->timestamps();
    $table->primary(['user_id', 'role_id']);
    $table->foreign('user_id')->references('id')->on('user');
    $table->foreign('role_id')->references('id')->on('roles');
});

Manager::schema()->create('throttle', function (Blueprint $table) {
    $table->increments('id');
    $table->integer('user_id')->unsigned()->nullable();
    $table->string('type');
    $table->string('ip')->nullable();
    $table->timestamps();
    $table->foreign('user_id')->references('id')->on('user');
});

$sentinel->getRoleRepository()->createModel()->create([
    'name' => 'Admin',
    'slug' => 'admin',
    'permissions' => [
        'user.create' => true,
        'user.update' => true,
        'user.delete' => true
    ]
]);

$sentinel->getRoleRepository()->createModel()->create([
    'name' => 'User',
    'slug' => 'user',
    'permissions' => [
        'user.update' => true
    ]
]);
