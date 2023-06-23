<?php

namespace App\Repository;

use App\Entity\Message;
use App\Entity\User;

class MessageRepository
{

    /**

    * Récupère tous les messages

    * @return Message[]

    */
    public function persist(Message $message): void
    {

        $connection = Database::getConnection();

        $query = $connection->prepare("INSERT INTO message (content,id_user) VALUES (:content,:id_user)");
        $query->bindValue(':content', $message->getContent());
        // $query->bindValue(':id_user', $message->getId_user());
        $query->bindValue(':id_user', $message->getUser()->getId());
        $query->execute();

        $message->setId($connection->lastInsertId());

    }
    public function findAll(): array
    {
        $list = [];
        $connection = Database::getConnection();
        $query = $connection->prepare('SELECT *,user.id userId,message.id messageId FROM message INNER JOIN user ON message.id_user=user.id');
        $query->execute();
        foreach ($query->fetchAll() as $line) {
            $user = new User($line['email'], '', $line['userId']);
            $list[] = new Message($line['content'], $user, $line['messageId']);
        }
        return $list;
    }



    public function findById(int $id): ?Message
    {
        $connection = Database::getConnection();
        $query = $connection->prepare("select *,user.id userId,message.id messageId from message inner join user on user.id = message.id_user where message.id=:id");
        $query->bindValue(':id', $id);
        $query->execute();
        foreach ($query->fetchAll() as $line) {
            $user = new User($line['email'], ' ', $line['userId']);

            return new Message($line['content'], $user, $line['messageId']);
        }
        return null;
    }

    public function delete(int $id)
    {
        $connection = Database::getConnection();
        $query = $connection->prepare("delete from message where id =:id");
        $query->bindValue(':id', $id);
        $query->execute();
    }

}