<?php
Class Connection{

    private static $dbh;

    public static function get(){
        require(__DIR__.'/../config/db_config.php');
        if (is_null(self::$dbh)) {
            try {
                self::$dbh = new PDO(
                    'mysql:host=' . $db_config['host'] . ':' . $db_config['port'] . ';dbname=' . $db_config['schema'] . ";charset=" . $db_config['charset'],
                    $db_config['user'],
                    $db_config['password']
                );
                //print_r(self::$dbh);
            } catch (Exception $e) {
                echo('Exception');
                print_r($e);
            }
            return self::$dbh;
        }else{
            return self::$dbh;
        }
    }
}