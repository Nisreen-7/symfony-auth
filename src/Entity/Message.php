<?php
namespace App\Entity;

class Message
{
    private string $content;
    // private int $id_user;
    private User $user;
    private ?int $id;

    public function __construct(string $content, User $user, ?int $id = null)
    {
        $this->content = $content;
        // $this->id_user = $id_user;
        $this->user = $user;
        $this->id = $id;
    }



	/**
	 * @return string
	 */
	public function getContent(): string {
		return $this->content;
	}
	
	/**
	 * @param string $content 
	 * @return self
	 */
	public function setContent(string $content): self {
		$this->content = $content;
		return $this;
	}
	
	/**
	 * @return User
	 */
	public function getUser(): User {
		return $this->user;
	}
	
	/**
	 * @param User $user 
	 * @return self
	 */
	public function setUser(User $user): self {
		$this->user = $user;
		return $this;
	}
	
	/**
	 * @return 
	 */
	public function getId(): ?int {
		return $this->id;
	}
	
	/**
	 * @param  $id 
	 * @return self
	 */
	public function setId(?int $id): self {
		$this->id = $id;
		return $this;
	}


    
}