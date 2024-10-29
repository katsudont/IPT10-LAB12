<?php

namespace App\Models;

use App\Models\BaseModel;
use \PDO;

class User extends BaseModel
{
    public function save($data) {
        $sql = "INSERT INTO users 
                SET
                    complete_name=:complete_name,
                    email=:email,
                    `password_hash`=:password_hash";        
        $statement = $this->db->prepare($sql);
        $password_hash = $this->hashPassword($data['password_hash']);
        $statement->execute([
            'complete_name' => $data['complete_name'],
            'email' => $data['email'],
            'password_hash' => $password_hash
        ]);
        return $statement->rowCount();
        // Return the ID of the new user
        /*$lastInsertId = $this->db->lastInsertId();

        return [
            'row_count' => $statement->rowCount(),
            'last_insert_id' => $lastInsertId->lastInsertId()
        ];*/
    }

    protected function hashPassword($password_hash) {
        return password_hash($password_hash, PASSWORD_DEFAULT);
    }

    public function verifyAccess($email, $password_hash) {
        $sql = "SELECT password_hash FROM users WHERE email = :email";
        $statement = $this->db->prepare($sql);
        $statement->execute([
            'email' => $email
        ]);
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        if (empty($result)) {
            return false;
        }

        return password_verify($password_hash, $result['password_hash']);
    }

    public function getAllUsers() {
        $sql = "SELECT * FROM users";
        $statement = $this->db->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

}