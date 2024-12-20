<?php

// namespace App\Libraries;

use Alresia\LaravelWassenger\Wassenger as WassengerClass;
use Alresia\LaravelWassenger\Messages;
use Alresia\LaravelWassenger\Devices;
use Alresia\LaravelWassenger\Session;

class Wassenger
{
    // protected $wassenger;
    protected $messages;
    protected $devices;
    protected $session;

    public function __construct()
    {
        // Initialize the classes
        $this->wassenger = new WassengerClass();
        $this->messages = new Messages();
        $this->devices = new Devices();
        $this->session = new Session();
    }

    /**
     * Magic method to pass method calls to the respective classes.
     */
    // public function __call($method, $arguments)
    // {
    //     // Forward call to Wassenger class
    //     if (method_exists($this->wassenger, $method)) {
    //         return call_user_func_array([$this->wassenger, $method], $arguments);
    //     }

    //     // Forward call to Messages class
    //     if (method_exists($this->messages, $method)) {
    //         return call_user_func_array([$this->messages, $method], $arguments);
    //     }

    //     // Forward call to Devices class
    //     if (method_exists($this->devices, $method)) {
    //         return call_user_func_array([$this->devices, $method], $arguments);
    //     }

    //     // Forward call to Session class
    //     if (method_exists($this->session, $method)) {
    //         return call_user_func_array([$this->session, $method], $arguments);
    //     }

    //     // If method is not found in any class, throw an exception
    //     throw new \BadMethodCallException("Method {$method} not found in Wassenger classes.");
    // }

    public function sendMessage($phone, $message)
    {

        if (WassengerClass::numberExist($phone)) {
            Messages::message($phone, $message)->send();
        }
    }
}
