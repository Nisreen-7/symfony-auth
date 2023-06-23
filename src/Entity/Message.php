<?php
namespace App\Entity;

class Message
{
    private string $content;
    private int $id_user;
    private ?int $id;

    public function __construct(string $content, int $id_user, ?int $id = null)
    {
        $this->content = $content;
        $this->id_user = $id_user;
        $this->id = $id;
    }





    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content 
     * @return self
     */
    public function setContent(string $content): self
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return int
     */
    public function getId_user(): int
    {
        return $this->id_user;
    }

    /**
     * @param int $id_user 
     * @return self
     */
    public function setId_user(int $id_user): self
    {
        $this->id_user = $id_user;
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