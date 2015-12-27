<?php


namespace Tim\TimServer;


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
            $server->error($msg);
        });
        return $this;
    }

}
