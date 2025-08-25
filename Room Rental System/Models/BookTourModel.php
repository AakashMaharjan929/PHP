<?php


class BookTour
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function CreateTourRequest($post_id, $TourDate, $user_id, $name, $RequestType, $transaction_screenshot) {
        // Start a transaction to ensure both inserts succeed or fail together
        $this->db->begin_transaction();
    
        try {
            //set status of post as booked              
            $query3 = "UPDATE posts SET booking_status = 'Booked' WHERE id = ?";
            $stmt3 = $this->db->prepare($query3);
            if ($stmt3 === false) {
                throw new Exception('Prepare failed for posts: ' . $this->db->error);
            }
            $stmt3->bind_param('i', $post_id);
            $stmt3->execute();
            if ($stmt3->affected_rows === 0) {
                throw new Exception('No posts updated for id ' . $post_id);
            }
            $stmt3->close();
            
            // Query 1: Insert into transactions
            $query1 = "INSERT INTO transactions (request_type, transaction_screenshot, post_id) VALUES (?, ?, ?)";
            $stmt1 = $this->db->prepare($query1);
    
            if ($stmt1 === false) {
                throw new Exception('Prepare failed for transactions: ' . $this->db->error);
            }
    
            // Bind parameters for transactions
            $stmt1->bind_param('ssi', $RequestType, $transaction_screenshot, $post_id);
    
            if (!$stmt1->execute()) {
                throw new Exception('Insert failed for transactions: ' . $stmt1->error);
            }
    
            // Get the inserted transaction uid (assuming it's auto-incremented)
            $tranc_uid = $stmt1->insert_id; // This will get the last inserted ID for transactions table
    
            $stmt1->close();
    
            // Convert TourDate to proper format if necessary
            if (!empty($TourDate)) {
                $TourDate = date('Y-m-d', strtotime($TourDate));
            }
    
            // Query 2: Insert into booktourrequests with matching uid
            $query2 = "INSERT INTO booktourrequests (post_id, TourDate, user_id, tenantName, uid) VALUES (?, ?, ?, ?, ?)";
            $stmt2 = $this->db->prepare($query2);
    
            if ($stmt2 === false) {
                throw new Exception('Prepare failed for booktourrequests: ' . $this->db->error);
            }
    
            // Bind parameters (including the same uid for booktourrequests)
            $stmt2->bind_param('isisi', $post_id, $TourDate, $user_id, $name, $tranc_uid);
    
            if (!$stmt2->execute()) {
                throw new Exception('Insert failed for booktourrequests: ' . $stmt2->error);
            }
    
            $stmt2->close();
    
            // Commit the transaction if both queries succeed
            $this->db->commit();
        } catch (Exception $e) {
            // Roll back if any query fails
            $this->db->rollback();
            die($e->getMessage());
        }
    }
    
    
    
    public function getTourRequests($user_id) {
        $query = "SELECT b.bookTour_id, b.TourDate, b.status, b.user_id, b.post_id, p.title,b.uid
                  FROM booktourrequests b
                  JOIN posts p ON b.post_id = p.id
                  WHERE b.user_id = ?";
    
        $stmt = $this->db->prepare($query);
        
        if ($stmt === false) {
            die('Prepare failed: ' . $this->db->error);
        }
    
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $requests = [];
        while ($row = $result->fetch_assoc()) {
            $requests[] = $row;
        }
    
        $stmt->close();
        return $requests;
    }

    public function DeleteTourRequest($bookTour_id) {
        $query = "DELETE FROM booktourrequests WHERE bookTour_id = ?";
        $stmt = $this->db->prepare($query);
    
        if ($stmt === false) {
            die('Prepare failed: ' . $this->db->error);
        }
    
        $stmt->bind_param('i', $bookTour_id); 
    
        if (!$stmt->execute()) {
            die('Delete failed: ' . $stmt->error);
        }
    
        $stmt->close();
    }
    
    //get all posts
    public function getAllPosts(){
        $query = "SELECT * FROM booktourrequests";
        $stmt = $this->db->query($query);
    
        if ($stmt === false) {
            die('Query failed: ' . $this->db->error);
        }
    
        $posts = [];
    
        while ($row = $stmt->fetch_assoc()) {
            $posts[] = $row;
        }
    
        return $posts;
    }


    //reject post status
    public function rejectPost($post_id, $tranc_id) {
        // Start a transaction for atomic updates
        $this->db->begin_transaction();
    
        try {
            // Step 1: Update the transactions table and get the affected transaction ID
            $query1 = "UPDATE transactions SET status = 'Refund Request', priority = 3 WHERE post_id = ? AND id =?";
            $stmt1 = $this->db->prepare($query1);
            if ($stmt1 === false) {
                throw new Exception('Prepare failed for transactions: ' . $this->db->error);
            }
            $stmt1->bind_param('ii', $post_id, $tranc_id);
            $stmt1->execute();
            if ($stmt1->affected_rows === 0) {
                throw new Exception('No transactions updated for post_id ' . $post_id);
            }
    
            // Get the transaction ID that was just updated
            $query_id = "SELECT id FROM transactions WHERE post_id = ? AND status = 'Refund Request' LIMIT 1";
            $stmt_id = $this->db->prepare($query_id);
            if ($stmt_id === false) {
                throw new Exception('Prepare failed to fetch transaction ID: ' . $this->db->error);
            }
            $stmt_id->bind_param('i', $post_id);
            $stmt_id->execute();
            $stmt_id->bind_result($trans_id);
            $stmt_id->fetch();
            $stmt_id->close();
            if (!$trans_id) {
                throw new Exception('Could not retrieve transaction ID for post_id ' . $post_id);
            }
            $stmt1->close();
    
            // Step 2: Update booktourrequests where tranc_id matches the transaction ID
            $query2 = "UPDATE booktourrequests SET status = 'Rejected' WHERE uid = ?";
            $stmt2 = $this->db->prepare($query2);
            if ($stmt2 === false) {
                throw new Exception('Prepare failed for booktourrequests: ' . $this->db->error);
            }
            $stmt2->bind_param('i', $trans_id);
            $stmt2->execute();
            if ($stmt2->affected_rows === 0) {
                throw new Exception('No booktourrequests updated for transaction ID ' . $trans_id);
            }
            $stmt2->close();
    
            // Commit the transaction if all updates succeed
            $this->db->commit();
        } catch (Exception $e) {
            // Roll back if any update fails
            $this->db->rollback();
            die($e->getMessage());
        }
    }
    
    public function rejectPostNew($post_id, $tranc_id) {
        // Start a transaction for atomic updates
        $this->db->begin_transaction();
    
        try {

            //set status of post as available
            $query3 = "UPDATE posts SET booking_status = 'Available' WHERE id = ?";
            $stmt3 = $this->db->prepare($query3);
            if ($stmt3 === false) {
                throw new Exception('Prepare failed for posts: ' . $this->db->error);
            }
            $stmt3->bind_param('i', $post_id);
            $stmt3->execute();
            if ($stmt3->affected_rows === 0) {
                throw new Exception('No posts updated for id ' . $post_id);
            }
            $stmt3->close();

    
            // Step 2: Update booktourrequests where tranc_id matches the transaction ID
            $query2 = "UPDATE booktourrequests SET status = 'Rejected' WHERE uid = ?";
            $stmt2 = $this->db->prepare($query2);
            if ($stmt2 === false) {
                throw new Exception('Prepare failed for booktourrequests: ' . $this->db->error);
            }
            $stmt2->bind_param('i', $trans_id);
            $stmt2->execute();
            if ($stmt2->affected_rows === 0) {
                throw new Exception('No booktourrequests updated for transaction ID ' . $trans_id);
            }
            $stmt2->close();
    
            // Commit the transaction if all updates succeed
            $this->db->commit();
        } catch (Exception $e) {
            // Roll back if any update fails
            $this->db->rollback();
            die($e->getMessage());
        }
    }
        
}
?>