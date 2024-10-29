<?php

namespace App\Models;

use App\Models\BaseModel;
use \PDO;

class UserAnswer extends BaseModel
{
    public function save($data) {
        $sql = "INSERT INTO users_answers
                SET
                    user_id=:user_id,
                    answers=:answers";        
        $statement = $this->db->prepare($sql);
        $statement->execute([
            'user_id' => $data['user_id'],
            'answers' => $data['answers']
        ]);
    
        return $statement->rowCount();
    }

}