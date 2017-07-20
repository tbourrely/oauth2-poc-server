<?php
/**
 * File "DatabaseFactory.php"
 * @author Thomas Bourrely
 * 17/07/2017
 */

namespace mainApp;

use Illuminate\Database\Capsule\Manager as DB;

class DatabaseFactory
{
    private static $dbConfig;

    /**
     * Chargement du fichier de configuration
     */
    public static function setConfig()
    {
        if (is_null(self::$dbConfig)) {
            $conf = require(__DIR__ . DIRECTORY_SEPARATOR . 'conf' . DIRECTORY_SEPARATOR . 'db.conf.php');

            self::$dbConfig = $conf;
        }
    }

    /**
     * Creation de la connexion a la base de donnees
     */
    public static function makeConnection()
    {
        if (!is_null(self::$dbConfig)) {
            $db = new DB();

            $connections = self::$dbConfig['connections'];

            foreach ( $connections as $key => $connection ) {
                $more_settings = array(
                    'charset' => 'utf8',
                    'collation' => 'utf8_unicode_ci',
                    'prefix' => ''
                );

                $connection_settings = array_merge($connection, $more_settings);

                $db->addConnection(
                    $connection_settings,
                    $key
                );
            }

            $db->setAsGlobal();
            $db->bootEloquent();
        }

    }
}