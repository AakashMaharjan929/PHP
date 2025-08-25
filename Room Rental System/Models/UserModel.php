<?php

class UserModel
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function GetUsers()
    {
        $query = "SELECT * FROM users";
        $stmt = $this->db->prepare($query);
        
        if ($stmt === false) {
            die('Prepare failed: ' . $this->db->error);
        }
        
        $stmt->execute();

        $result = $stmt->get_result();
        
        $users = [];

        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
        
        $stmt->close();
        
        return $users;
    }

    public function DeleteUser($id){
        $query = "DELETE FROM users WHERE id = ?";
        $stmt = $this->db->prepare($query);
        
        if ($stmt === false) {
            die('Prepare failed: ' . $this->db->error);
        }
        
        $stmt->bind_param('i', $id);
        $stmt->execute();
        
        if ($stmt->affected_rows === 0) {
            die('Delete failed: ' . $this->db->error);
        }
        
        $stmt->close();
    }


    public function setUserStatus($id, $status)
{
    // Convert inputs to integers
    $id = intval($id);
    $status = intval($status);

    if (!is_int($id) || !is_int($status)) {
        throw new InvalidArgumentException('ID and status must be integers.');
    }

    try {
        // Prepare the SQL query
        $query = "UPDATE users SET status = ? WHERE id = ?";
        $stmt = $this->db->prepare($query);

        if (!$stmt) {
            throw new Exception("Failed to prepare statement: " . $this->db->error);
        }

        // Bind parameters (use `bind_param` for mysqli)
        $stmt->bind_param("ii", $status, $id); // "ii" indicates two integers

        // Execute the query
        $stmt->execute();

        if ($stmt->affected_rows === 0) {
            throw new Exception("No rows were updated. Check if the user exists.");
        }

        $stmt->close();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}



    
    

}



?>