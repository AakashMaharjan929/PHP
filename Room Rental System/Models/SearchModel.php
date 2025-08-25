<?php

class SearchModel
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }
    
    public function searchPosts($location)
    {
        $query = "SELECT * FROM posts WHERE location = ?";
        $stmt = $this->db->prepare($query);
    
        if ($stmt === false) {
            die('Prepare failed: ' . $this->db->error);
        }
    
        $stmt->bind_param('s', $location);
        $stmt->execute();
        
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    

}