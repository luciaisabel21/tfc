<?php

abstract class Persona {
	private String $id;
	private $nombre;
	private $email;
	private $contraseña;
    

    function __construct($id, $nombre, $email, $contraseña) {
    	$this->id = $id;
    	$this->nombre = $nombre;
    	$this->email = $email;

        $this->contraseña = $contraseña;
	}


	/**
	 * Get the value of id
	 */ 
	public function getId()
	{
		return $this->id;
	}

	/**
	 * Set the value of id
	 *
	 * @return  self
	 */ 
	public function setId($id)
	{
		$this->id = $id;

		return $this;
	}

	/**
	 * Get the value of nombre
	 */ 
	public function getNombre()
	{
		return $this->nombre;
	}

	/**
	 * Set the value of nombre
	 *
	 * @return  self
	 */ 
	public function setNombre($nombre)
	{
		$this->nombre = $nombre;

		return $this;
	}

	/**
	 * Get the value of email
	 */ 
	public function getEmail()
	{
		return $this->email;
	}

	/**
	 * Set the value of email
	 *
	 * @return  self
	 */ 
	public function setEmail($email)
	{
		$this->email = $email;

		return $this;
	}

	/**
	 * Get the value of contraseña
	 */ 
	public function getContraseña()
	{
		return $this->contraseña;
	}

	/**
	 * Set the value of contraseña
	 *
	 * @return  self
	 */ 
	public function setContraseña($contraseña)
	{
		$this->contraseña = $contraseña;

		return $this;
	}
}



?>