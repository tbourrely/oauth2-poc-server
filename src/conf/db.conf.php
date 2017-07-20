<?php
/**
 * File "db.conf.php"
 * @author Thomas Bourrely
 * 17/07/2017
 */

return $conf = array(
    'default' => 'server',

    'connections' => array(

        # Primary connection
        'server' => array(
            'driver' => 'mysql',
            'host' => '127.0.0.1',
            'database' => 'oauth2-poc_server',
            'username' => 'root',
            'password' => 'root',
        ),

        #Secondary
        'users' => array(
            'driver' => 'mysql',
            'host' => '127.0.0.1',
            'database' => 'oauth2-poc_main-app',
            'username' => 'root',
            'password' => 'root',
        )

    )
);