<?php

namespace App\Model;

/**
 *
 */
class UserManager extends AbstractManager
{
    const TABLE = 'clients';

    // initializes this class
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function login(array $login)
    {
        $statement = $this->pdo->prepare("SELECT * FROM " . self::TABLE . " WHERE email = (:email) AND password= (:password)");
        $statement->bindValue(':email', $login['email'], \PDO::PARAM_STR);
        $statement->bindValue(':password', $login['password'], \PDO::PARAM_STR);
        $statement->execute();
        return $statement->fetch();
    }
}
