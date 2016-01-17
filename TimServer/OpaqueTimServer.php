<?php


namespace Tim\TimServer;

use Tim\Exception\TransparentException;


/**
 * OpaqueTimServer
 * @author Lingtalfi
 * 2014-12-26
 *
 */
class OpaqueTimServer extends TimServer
{

    public function setOpaqueMessage($msg)
    {
        $this->setOnExceptionCaughtCb(function (\Exception $e, TimServerInterface $server) use ($msg) {
            if ($e instanceof TransparentException) {
                $server->error($e->getMessage());
            }
            else {
                $server->error($msg);
            }
        });
        return $this;
    }

}
