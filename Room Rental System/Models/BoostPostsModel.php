<?php

class BoostPosts
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function CreateBoostPost($post_id, $post_name, $transaction_screenshot){
        $query = "INSERT INTO boostedposts (post_id, post_name, transaction_screenshot) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($query);
        
        if ($stmt === false) {
            die('Prepare failed: ' . $this->db->error);
        }
        
        $stmt->bind_param('iss', $post_id, $post_name, $transaction_screenshot);
        $stmt->execute();
        
        if ($stmt->affected_rows === 0) {
            die('Insert failed: ' . $this->db->error);
        }
        
        $stmt->close();
    }

    public function getBoostedPosts(){
        $query = "SELECT * FROM boostedposts";
        $stmt = $this->db->prepare($query);
        
        if ($stmt === false) {
            die('Prepare failed: ' . $this->db->error);
        }
        
        $stmt->execute();
        
        $result = $stmt->get_result();
        
        $stmt->close();
        
        return $result;
    }

    public function BoostPost($post_id, $post_name, $post_section){
        $status = 0;
        if($post_section == 'featured') {
            $status = 1;
        } elseif($post_section == 'bestdeals') {
            $status = 2;
        }
    
        $update_query = "UPDATE posts SET status = ? WHERE id = ?";
        $update_stmt = $this->db->prepare($update_query);
        $update_stmt->bind_param('ii', $status, $post_id); 
        $update_stmt->execute();
    
        $insert_query = "INSERT INTO BoostPost (post_id, post_name, post_section) VALUES (?, ?, ?)";
        $insert_stmt = $this->db->prepare($insert_query);
        $insert_stmt->bind_param('iss', $post_id, $post_name, $post_section); 
        $insert_stmt->execute();

        session_start();

        $_SESSION['boostedPostCount']++;

    }
    
    public function getBoostPost(){
        $query = "SELECT * FROM BoostPost";
        $stmt = $this->db->prepare($query);
        
        if ($stmt === false) {
            die('Prepare failed: ' . $this->db->error);
        }
        
        $stmt->execute();
        
        $result = $stmt->get_result();
        
        $stmt->close();
        
        return $result;
    }

    public function deleteBoostPost($post_id){
        $delete_query = "DELETE FROM BoostPost WHERE post_id = ?";
        $delete_stmt = $this->db->prepare($delete_query);
        $delete_stmt->bind_param('i', $post_id); 
        $delete_stmt->execute();

        $update_query = "UPDATE posts SET status = 0 WHERE id = ?";
        $update_stmt = $this->db->prepare($update_query);
        $update_stmt->bind_param('i', $post_id);
        $update_stmt->execute();
    }
    
    public function deleteBoostedPost($id){
        $query = "SELECT transaction_screenshot FROM boostedposts WHERE id = ?";
        $stmt = $this->db->prepare($query);
    
        if ($stmt === false) {
            die('Prepare failed: ' . $this->db->error);
        }
    
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->bind_result($transaction_screenshot);
        $stmt->fetch();
        $stmt->close();
    

            if (!empty($transaction_screenshot)) {
                if (file_exists($transaction_screenshot)) {
                    unlink($transaction_screenshot);
                }
            }



        $query = "DELETE FROM boostedposts WHERE id=?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
    }

    public function getTotalEarnings()
{
    $query = "SELECT Total FROM adminearnings";
    $result = $this->db->query($query);

    if ($result) {
        $row = $result->fetch_assoc();
        return $row['Total'] ?? 0; 
    } else {
        return 0;
    }
}

public function addAmountToEarnings($amount = 250)
{
    $currentTotal = $this->getTotalEarnings();
    $newTotal = $currentTotal + $amount;

    $query = "UPDATE adminearnings SET Total = ?"; 
    $stmt = $this->db->prepare($query);
    $stmt->bind_param('d', $newTotal); 
    $stmt->execute();

    return $stmt->affected_rows > 0;
}

}

?>