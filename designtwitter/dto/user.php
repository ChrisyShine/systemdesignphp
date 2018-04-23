<?php 

class User {
    private $id;
    private $update_time;
    
    public function __construct($id, $update_time){
        $this->id = $id;
        $this->update_time = $update_time;
    }
    private function __clone(){
        //code
    }
    
    public function getId() {
        return $this->id;
    }
    
    public function getUpdateTime() {
        return $this->update_time;
    }
    
}

?>