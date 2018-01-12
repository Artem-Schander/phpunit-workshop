<?php
namespace App;

class UsersController
{
    protected function getPDO()
    {
        $DB = new DB('127.0.0.1', 'live', 'root', 'root');
        return $DB->pdo();
    }

    public function createUser($data = [])
    {
        $sql = '
        INSERT INTO users 
            (email, first_name, last_name, created_at, updated_at) 
        VALUES 
            (:email, :first_name, :last_name, :created_at, :updated_at)
        ';
        $stmt = $this->getPDO()->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':first_name', $first_name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':created_at', $created_at);
        $stmt->bindParam(':updated_at', $updated_at);

        // zeile schreiben
        $email = $data['email'];
        $first_name = $data['first_name'];
        $last_name = $data['last_name'];
        $created_at = date('Y-m-d H:i:s');
        $updated_at = date('Y-m-d H:i:s');

        $stmt->execute();
    }
}
