<?php

namespace Tim\TimServer;

/*
 * LingTalfi 2016-01-18
 * 
 * 
 * 
 * service name
 * -----------------
 * The name of the targeted service, or the asterisk (*) to target all services globally.
 * 
 * 
 * 
 * 
 * 
 */
class TimServerGlobal
{


    private static $logCbs = [];
    private static $opaqueMsgs = [];


    public static function setLogCb(callable $cb, $serviceName = null)
    {
        self::$logCbs[$serviceName] = $cb;
    }

    public static function getLogCb($serviceName)
    {
        if (array_key_exists($serviceName, self::$logCbs)) {
            return self::$logCbs[$serviceName];
        }
        elseif (array_key_exists('*', self::$logCbs)) {
            return self::$logCbs['*'];
        }
        return false;
    }

    public static function setOpaqueMessage($msg, $serviceName = null)
    {
        self::$opaqueMsgs[$serviceName] = $msg;
    }

    public static function getOpaqueMessage($serviceName)
    {
        if (array_key_exists($serviceName, self::$opaqueMsgs)) {
            return self::$opaqueMsgs[$serviceName];
        }
        elseif (array_key_exists('*', self::$logCbs)) {
            return self::$opaqueMsgs['*'];
        }
        return 'An error occurred! Please retry later';
    }

}
