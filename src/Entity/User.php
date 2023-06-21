<?php

namespace App\Entity;


class User
{

    private string $email;
    private int $password;
    private ?int $id;

    public function __construct(string $email, int $password, ?int $id = null)
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
    public function getPassword(): int
    {
        return $this->password;
    }

    /**
     * @param int $password 
     * @return self
     */
    public function setPassword(int $password): self
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
}