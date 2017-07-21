<?php

return [

    /**
     * Authentication Model table name
     */

    'authTable' => 'users',

    /**
     * The authentication model class
     */

    'user' => \App\User::class,

    /**
     * Model definitions.
     * You can extend the models in the package
     * or leave the defaults. Just update the paths.
     */

    'level' => \z1haze\Acl\Models\Level::class,
    'permission' => \z1haze\Acl\Models\Permission::class,

    /**
     * Cache Minutes
     * Set the minutes that levels and permissions will be cached.
     */

    'cacheMinutes' => 1,
];