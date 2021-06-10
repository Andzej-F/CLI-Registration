<?php
class User
{
    public $name;
    public $email;
    public $phone;
    public $nin;
    public $date;
    public $time;


    public function __construct($name, $email, $phone, $nin, $date, $time)
    {
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
        $this->nin = $nin;
        $this->date = $date;
        $this->time = $time;
    }
}
