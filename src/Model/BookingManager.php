<?php

namespace App\Model;

class BookingManager extends AbstractManager
{
    public const TABLE_A = 'reservation';
    public const TABLE_B = 'clients';
    public const TABLE_C = 'room';

    // initializes this class
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function login(array $login)
    {
        $query = "SELECT * FROM " . self::TABLE . " WHERE email = (:email) AND password= (:password)";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':email', $login['email'], \PDO::PARAM_STR);
        $statement->bindValue(':password', $login['password'], \PDO::PARAM_STR);
        $statement->execute();
        return $statement->fetch();
    }

    public function book(array $booking)
    {   
        // Retrieving client ID
        $clientID = "SELECT id FROM " . self::TABLE_B . " WHERE firstname = (:firstname) AND lastname= (:lastname)";
        $statement = $this->pdo->prepare($clientID);
        $statement->bindValue(':firstname', $booking['firstname'], \PDO::PARAM_STR);
        $statement->bindValue(':lastname', $booking['lastname'], \PDO::PARAM_STR);
        $statement->execute();
        $clientID = $statement->fetch();

        // Retrieving room ID
        $roomID = "SELECT id FROM " . self::TABLE_C . " WHERE room_name = (:roomSelect)";
        $statement = $this->pdo->prepare($roomID);
        $statement->bindValue(':roomSelect', $booking['roomSelect'], \PDO::PARAM_STR);
        $statement->execute();
        $roomID = $statement->fetch();


        $query = "INSERT INTO " . self::TABLE_A . " VALUES (null, ".$clientID.", :arrival, :departure, ".$roomID.", :nb_adult, :nb_child, :nb_nights, :paid_price, :nights_number)";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':arrival', $booking['arrival'], \PDO::PARAM_STR);
        $statement->bindValue(':departure', $booking['departure'], \PDO::PARAM_STR);
        $statement->bindValue(':nb_adult', $booking['guestSelect'], \PDO::PARAM_INT);
        $statement->bindValue(':nb_child', $booking['childGuestSelect'], \PDO::PARAM_INT);
        $statement->bindValue(':nb_nights', $booking['nightsNumber'], \PDO::PARAM_INT);
        $statement->bindValue(':paid_price', $booking['paidPrice'], \PDO::PARAM_INT);

        
        $statement->execute();
    }
}
