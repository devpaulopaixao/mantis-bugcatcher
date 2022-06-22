<?php

namespace Devpaulopaixao\MantisBugcatcher;

use Illuminate\Support\ServiceProvider;

class MantisServiceProvider extends ServiceProvider
{
    /**
    * Register services.
    *
    * @return void
    */
    public function register()
    {        
        //RETRIEVE LOADER INSTANCE
        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        
        //REGISTER ALL HELPERS FROM THIS PACKAGE
        $loader->alias('MantisBugcatcher',         'Devpaulopaixao\MantisBugcatcher\Helpers\Mantis');
    }
}