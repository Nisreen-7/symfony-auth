<?php

namespace App\Entity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;


class User implements UserInterface,PasswordAuthenticatedUserInterface
{

    private string $email;
    private string $password;
    private ?int $id;

    public function __construct(string $email, string $password, ?int $id = null)
    {
        $this->email = $email;
        $this->password = $password;
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email 
     * @return self
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return int
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param int $password 
     * @return self
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return 
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param  $id 
     * @return self
     */
    public function setId(?int $id): self
    {
        $this->id = $id;
        return $this;
    }
 public function getUserIdentifier():string{

    return $this->getEmail();
 }
 public function eraseCredentials(){

    
 }
 public function getRoles ():string{

    return "(['ROLE_USER'])";
 }

 


}