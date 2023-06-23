<?php
namespace App\Repository;
use App\Entity\User;


/**
 * @return User[]| null;
 */
class UserRepository
{

    public function persist(User $data)
    {


        $connection = Database::getConnection();
        $query = $connection->prepare("insert into user (email,password)VALUES(:email,:password)");
       
        $query->bindValue(':email', $data->getEmail());
        $query->bindValue(':password', $data->getPassword());


        $query->execute();
        //  pour prend id en la main 
        $data->setId($connection->lastInsertId());

    }

    public function findByEmail(string $email): ?User
    {
        $connection = Database::getConnection();
        $query = $connection->prepare("select * from user  where email=:email");
        $query->bindValue(':email', $email);
        $query->execute();
        foreach ($query->fetchAll() as $line) {
            return new User($line['email'], $line['password'], $line['id']);
        }
        return null;
    }
   


}