<?php

namespace App\Models;

use App\Models\BaseModel;
use \PDO;

class Question extends BaseModel
{
    public function save($data) {
        $sql = "INSERT INTO questions 
                SET
                    item_number=:item_number,
                    question=:question,
                    choices=:choices,
                    correct_answer=:correct_answer";        
        $statement = $this->db->prepare($sql);
        $statement->execute([
            'item_number' => $data['item_number'],
            'question' => $data['question'],
            'choices' => $data['choices'],
            'correct_answer' => $data['correct_answer']
        ]);

        return $statement->rowCount();
    }

    public function getQuestion($item_number)
    {
        $sql = "SELECT * FROM questions WHERE item_number = :item_number";
        $statement = $this->db->prepare($sql);
        $statement->execute([
            'item_number' => $item_number
        ]);
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getAllQuestions()
    {
        $sql = "SELECT * FROM questions";
        $statement = $this->db->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

}