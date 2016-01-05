<?php


namespace Tim\TimServer;


/**
 * TimServer
 * @author Lingtalfi
 * 2014-10-24
 *
 */
class TimServer implements TimServerInterface
{

    private $type;
    private $message;
    private $onExceptionCaughtCb;

    public function __construct()
    {
        $this->message = 'tim server not started yet';
        $this->type = 'e';
        $this->onExceptionCaughtCb = function (\Exception $e, TimServerInterface $server) {
            $server->error($e->getMessage());
        };
    }

    public static function create()
    {
        return new static();
    }


    //------------------------------------------------------------------------------/
    // IMPLEMENTS TimServerInterface
    //------------------------------------------------------------------------------/
    public function output()
    {
        echo json_encode([
            't' => $this->type,
            'm' => $this->message,
        ]);
    }


    public function error($msg)
    {
        $this->type = 'e';
        $this->message = $msg;
        return $this;
    }

    public function success($msg)
    {
        $this->type = 's';
        $this->message = $msg;
        return $this;
    }

    public function setOnExceptionCaughtCb(callable $onExceptionCaughtCb)
    {
        $this->onExceptionCaughtCb = $onExceptionCaughtCb;
        return $this;
    }


    //------------------------------------------------------------------------------/
    // 
    //------------------------------------------------------------------------------/
    public function start($callable)
    {
        if (is_callable($callable)) {
            try {
                call_user_func($callable, $this);
            } catch (\Exception $e) {
                call_user_func($this->onExceptionCaughtCb, $e, $this);
                $this->log($e);
            }
        } else {
            throw new \InvalidArgumentException("callable must be a callable");
        }
        return $this;
    }


    protected function log(\Exception $e)
    {

    }


}
