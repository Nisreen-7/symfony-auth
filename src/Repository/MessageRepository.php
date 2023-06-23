<?php

namespace App\Repository;

use App\Entity\Message;

class MessageRepository {

     /**

     * Récupère tous les messages

     * @return Message[]

     */

    public function findAll():array{

        $list = [];
        $connection = Database::getConnection();
        $query = $connection->prepare("SELECT * FROM message inner join user on user.id = message.id_user");
        $query->execute();
        foreach ( $query->fetchAll() as $line) {
            $list[] = new Message($line['content'], $line['id_user'], $line['id']);
        }

        return $list;

    }

    public function persist(Message $message):void {

        $connection = Database::getConnection();

        $query = $connection->prepare("INSERT INTO message (content,id_user) VALUES (:content,:id_user)");
        $query->bindValue(':content', $message->getContent());
        $query->bindValue(':id_user', $message->getId_user());
        $query->execute();

        $message->setId($connection->lastInsertId());

    }




}