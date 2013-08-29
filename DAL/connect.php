<?php
class connect {
    
    private $db;
    function __construct() {
       // $c = new Mongo("mongodb://diego:123@alex.mongohq.com:10098/findbreak");
        $c = new Mongo("mongodb://dani:enter123@localhost/test");
        $this->db = $c->test; 
    }
    public function getDB(){
        return $this->db;
    }
}

?>
