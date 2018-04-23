<?php 

class Feed {
    private $id;
    private $user_id;
    private $message;
    private $post_time;
    
    public function __construct($id, $user_id, $message, $post_time){
        $this->id = $id;
        $this->user_id = $user_id;
        $this->message = $message;
        $this->post_time = $post_time;
    }
    private function __clone(){
        //code
    }
    
    public function getId() {
        return $this->id;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function getPostTime()
    {
        return $this->post_time;
    }

    
    
    
}

?>