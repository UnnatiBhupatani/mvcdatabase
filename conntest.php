<?php

class Conntest{
public $conn;
    public function __construct(){
        $servername = 'localhost';
        $username   = 'root';
        $pass       = '';
        $dbname     = 'studentdata';

        $this->conn = new mysqli($servername, $username, $pass, $dbname);

        if ($this->conn->connect_error) {
            die("connection failed");
        }
        echo "connection sucessfully";

        
}
    
}

