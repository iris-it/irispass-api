<?php


return [

    /*
    |--------------------------------------------------------------------------
    | Model Configuration
    |--------------------------------------------------------------------------
    |
    | Because JWT auth read the sub in the jwt and it's not
    | the id column but the sub column so..
    |
    */

    'user_primary_key' => 'sub',

];
