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

    public function login(array $login){
        $statement = $this->pdo->prepare("SELECT * FROM " . self::TABLE . " WHERE email = (:email) AND password= (:password)");
        $statement->bindValue(':email', $login['email'], \PDO::PARAM_STR);
        $statement->bindValue(':password', $login['password'], \PDO::PARAM_STR);
        $statement->execute();
        return $statement->fetch();
    }

    // public function insert(array $user): int
    // {
    //     // prepared request
    //     $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . " (`title`) VALUES (:title)");
    //     $statement->bindValue('title', $user['title'], \PDO::PARAM_STR);

    //     if ($statement->execute()) {
    //         return (int)$this->pdo->lastInsertId();
    //     }
    // }


    // /**
    //  * @param int $id
    //  */
    // public function delete(int $id): void
    // {
    //     // prepared request
    //     $statement = $this->pdo->prepare("DELETE FROM " . self::TABLE . " WHERE id=:id");
    //     $statement->bindValue('id', $id, \PDO::PARAM_INT);
    //     $statement->execute();
    // }


    // /**
    //  * @param array $item
    //  * @return bool
    //  */
    // public function update(array $item):bool
    // {

    //     // prepared request
    //     $statement = $this->pdo->prepare("UPDATE " . self::TABLE . " SET `title` = :title WHERE id=:id");
    //     $statement->bindValue('id', $item['id'], \PDO::PARAM_INT);
    //     $statement->bindValue('title', $item['title'], \PDO::PARAM_STR);

    //     return $statement->execute();
    // }
}