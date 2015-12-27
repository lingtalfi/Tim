Tim
===========
2015-12-11




Tim is a simple protocol to help with communication between a client and a server.
Upon a server's response, the client knows whether or not the server's response was a success or a failure.



Tim protocol
--------------

This is actually just an idea:

the client sends its request,
the server must respond with a json array containing two keys:

- t: string(e|s), the message type, e means error, s means success 
- m: mixed, the server's answer. The data can be a string or an array, or a bool, anything... 



Note: The name tim comes from the letters t and m.



Tools
----------

### TimServer (php)

TimServer is a php implementation of a tim server.
It helps you creating a php service.


#### Example code

The code below showcases the TimServer features.
It uses the [bigbang technique](https://github.com/lingtalfi/TheScientist/blob/master/convention.portableAutoloader.eng.md) to autoload 
the classes.


 
```php  
<?php

require_once "bigbang.php";


use Tim\TimServer\TimServer;
use Tim\TimServer\TimServerInterface;


TimServer::create()
    ->start(function (TimServerInterface $server) {
        if (isset($_POST['id'])) {
            // ...
            if ('valid') {
                $server->success("Congrats!");
            }
            else {
                throw new \Exception("division by zero!");
            }
        }
        else {
            $server->error("Oops");
        }
    })
    ->output();

```


Also, since 1.1.0, we can use the OpaqueTimServer which accepts a default message that is returned
every time an uncaught exception is thrown.
Using the OpaqueTimServer, you can log the original exception message while having a standard user message
displayed to the front user.


```php
<?php


require_once __DIR__ . "/../../../../../init.php";


use Tim\TimServer\OpaqueTimServer;
use Tim\TimServer\TimServerInterface;


OpaqueTimServer::create()
    ->setOpaqueMessage("An internal error has occurred, please retry later")
    ->start(function (TimServerInterface $server) {
            // do your things...
})->output();
```






### tim functions (js)

Tim functions is a mini library of functions for a javascript client.
Just include the tim-functions.js script in your head and you're ready to go.


#### How to use?

tim functions depends on [jquery](https://jquery.com/).


The main function is timPost, which is a wrapper to the [jquery's post](http://api.jquery.com/jquery.post/) method.

```
jqXHR       timPost ( str:url, arrayObject:data, callback:onSuccess, callback:onFailure=null )
```


********

- Simple call:

```js
timPost("/service/event.php", {
    id: 20
}, function (msg) {
    console.log("timpost success");
});
```

If a tim error occurs (t=e), then by default the timError function is called, 
which alerts the error message to the user.
It is recommended that if you want to improve the error 
message appearance (fancy popup?) you simply override the timError function.

********

- Call with control on error:

You can also define the error handler on a per call basis.
```js
timPost("/service/event.php", {
    id: 20
}, function (msg) {
    console.log("timpost success");
}, function(msg){
    // note that the msg should be an array or a string, you can use the _timErrorToString function to create a string
    console.log("timpost error");
});
``` 
 
********
 
- Use Jquery jqXHR:


Since timPost returns a jqXHR object, you can still use its [methods](http://api.jquery.com/category/deferred-object/).
For instance, you can chain the timPost function to the always method of the jqXHR object.


```js 
timPost("/service/event.php", {
    id: 20
}, function (msg) {
    console.log("timpost success");
})
.always(function(){
    console.log("I'm always executed");
});
```



 
 
 
 
 
History Log
------------------
    
- 1.1.0 -- 2015-12-27

    - add OpaqueTimServer
    - add TimServer->setOnExceptionCaughtCb method

- 1.0.0 -- 2015-12-11

    - initial commit
    
     
 
 
 







