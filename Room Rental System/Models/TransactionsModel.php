<?php
class TransactionsModel {
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    //get all transactions
    public function getTransactions(){
        $query = "SELECT * FROM transactions ORDER BY priority DESC;";
        $stmt = $this->db->prepare($query);
        
        if ($stmt === false) {
            die('Prepare failed: ' . $this->db->error);
        }
        
        $stmt->execute();

        $result = $stmt->get_result();
        
        $transactions = [];

        while ($row = $result->fetch_assoc()) {
            $transactions[] = $row;
        }
        
        $stmt->close();
        
        return $transactions;
    }
    

    //get all records where status is confirmed
    public function getConfirmedTransactions() {
        $query = "SELECT * FROM transactions WHERE status = 'confirmed' ORDER BY priority DESC";
        $stmt = $this->db->prepare($query);
        
        if ($stmt === false) {
            die('Prepare failed: ' . $this->db->error);
        }
        
        $stmt->execute();
        $result = $stmt->get_result();
        
        $transactions = [];
        $total_amount = 0;
    
        while ($row = $result->fetch_assoc()) {
            $transactions[] = $row;
            $total_amount += (float) $row['transact_amount'];
        }
        
        $transaction_count = count($transactions);
        
        $stmt->close();
        
        return [
            'transactions' => $transactions,
            'transaction_count' => $transaction_count,
            'total_amount' => $total_amount
        ];
    }

    public function confirmPost($id, $tranc_id) {
        // Start a transaction for atomic updates
        $this->db->begin_transaction();
    
        try {
            // Step 1: Update the transactions table and get the affected transaction ID
            $query1 = "UPDATE transactions SET status = 'confirmed', priority = 1 WHERE post_id = ? AND id = ?";
            $stmt1 = $this->db->prepare($query1);
            if ($stmt1 === false) {
                throw new Exception('Prepare failed for transactions: ' . $this->db->error);
            }
            $stmt1->bind_param('ii', $id, $tranc_id);
            $stmt1->execute();
            if ($stmt1->affected_rows === 0) {
                throw new Exception('No transactions updated for post_id ' . $id);
            }
    
            // Get the transaction ID that was just updated
            $trans_id = $this->db->insert_id; // If it's not an insert, fetch it explicitly
            if (!$trans_id) {
                $query_id = "SELECT id FROM transactions WHERE post_id = ? AND status = 'confirmed' LIMIT 1";
                $stmt_id = $this->db->prepare($query_id);
                $stmt_id->bind_param('i', $id);
                $stmt_id->execute();
                $stmt_id->bind_result($trans_id);
                $stmt_id->fetch();
                $stmt_id->close();
                if (!$trans_id) {
                    throw new Exception('Could not retrieve transaction ID for post_id ' . $id);
                }
            }
            $stmt1->close();
    
            // Step 2: Update booktourrequests where tranc_id matches the transaction ID
            $query2 = "UPDATE booktourrequests SET status = 'Approved' WHERE uid = ?";
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
    
            // Step 3: Update posts (still based on post_id, assuming it’s the intent)
            $query3 = "UPDATE posts SET booking_status = 'Booked' WHERE id = ?";
            $stmt3 = $this->db->prepare($query3);
            if ($stmt3 === false) {
                throw new Exception('Prepare failed for posts: ' . $this->db->error);
            }
            $stmt3->bind_param('i', $id);
            $stmt3->execute();
            if ($stmt3->affected_rows === 0) {
                throw new Exception('No posts updated for id ' . $id);
            }
            $stmt3->close();
    
            // Commit the transaction if all updates succeed
            $this->db->commit();
        } catch (Exception $e) {
            // Roll back if any update fails
            $this->db->rollback();
            die($e->getMessage());
        }
    }

    public function refund($id, $tranc_id) {
        // Start a transaction for atomic updates
        $this->db->begin_transaction();
    
        try {
            // Step 1: Update the transactions table and get the affected transaction ID
            $query1 = "UPDATE transactions SET status = 'refunded', priority = 0 WHERE post_id = ? AND id =?";
            $stmt1 = $this->db->prepare($query1);
            if ($stmt1 === false) {
                throw new Exception('Prepare failed for transactions: ' . $this->db->error);
            }
            $stmt1->bind_param('ii', $id, $tranc_id);
            $stmt1->execute();
            if ($stmt1->affected_rows === 0) {
                throw new Exception('No transactions updated for post_id ' . $id);
            }
    
            // Get the transaction ID that was just updated
            $query_id = "SELECT id FROM transactions WHERE post_id = ? AND status = 'refunded' LIMIT 1";
            $stmt_id = $this->db->prepare($query_id);
            if ($stmt_id === false) {
                throw new Exception('Prepare failed to fetch transaction ID: ' . $this->db->error);
            }
            $stmt_id->bind_param('i', $id);
            $stmt_id->execute();
            $stmt_id->bind_result($trans_id);
            $stmt_id->fetch();
            $stmt_id->close();
            if (!$trans_id) {
                throw new Exception('Could not retrieve transaction ID for post_id ' . $id);
            }
            $stmt1->close();
    
            // Step 2: Update posts (still based on post_id, assuming it’s tied to the transaction)
            $query3 = "UPDATE posts SET booking_status = 'Available' WHERE id = ?";
            $stmt3 = $this->db->prepare($query3);
            if ($stmt3 === false) {
                throw new Exception('Prepare failed for posts: ' . $this->db->error);
            }
            $stmt3->bind_param('i', $id);
            $stmt3->execute();
            if ($stmt3->affected_rows === 0) {
                throw new Exception('No posts updated for id ' . $id);
            }
            $stmt3->close();
    
            // Commit the transaction if all updates succeed
            $this->db->commit();
        } catch (Exception $e) {
            // Roll back if any update fails
            $this->db->rollback();
            die($e->getMessage());
        }
    }

   //get transactions by id
    public function getTransactionsById($id){
        $query = "SELECT * FROM transactions WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $transactions = [];
        
        while ($row = $result->fetch_assoc()) {
            $transactions[] = $row;
        }
        
        $stmt->close();
        
        return $transactions;
    }
    
 
}
?>