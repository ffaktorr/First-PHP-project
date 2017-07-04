<?php

class usernamePassword
{
    private $username;
    private $password;

    public function __construct($username,$password)
    {
        $this->username=$username;
        $this->password=$password;

    }
    

    public function __get($name)
    {
        return isset($this->$name) ? $this->$name : "";
    }


    public static function dohvati($id_korisnika)
    {
        $sql = "SELECT username,password FROM korisnici WHERE id_korisnika=$id_korisnika";
        $dbh = new mysqli("localhost", "root", "", "rt_4714_stefan_petrovic");
        $res = $dbh->query($sql);
        $result = mysqli_fetch_array($res);
        $temp = new usernamePassword($result['username'], $result['password']);

        return $temp;

    }

}