<?php 


namespace LKGames\Entity;
class UserEntity
{
    protected $id_user;
    protected $nombre;
    protected $email;
    protected $password;
	protected $status;
	protected $id_permissions;

    public function getId_user()
    {
		return $this->id_user;
	}
    public function getName()
    {
		return $this->nombre;
	}
    public function getEmail()
    {
		return $this->email;
	}
    public function getPassword()
    {
		return $this->password;
	}

	public function getStatus()
    {
		return $this->status;
	}

	public function getPermissions()
    {
		return $this->id_permissions;
	}

    public function setId_user($value)
	{
		$this->id_user = $value;
	}

    public function setNombre($value)
	{
		$this->nombre = $value;
	}

    public function setEmail($value)
	{
		$this->email = $value;
	}

    public function setPassword($value)
	{
		$this->password = $value;
	}

	public function setStatus($value)
	{
		$this->status = $value;
	}

}