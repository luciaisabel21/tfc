<?php
class Usuario extends Persona {

	private String $telefono;
	private String $genero;

	private $listaBoda = [];
	private $listaViaje = [];
	private $listaProducto = [];

	public function __construct($id, $nombre, $email, $contraseña, $telefono, $genero) {
    	parent::__construct($id, $nombre, $email,  $contraseña);
    	$this->telefono = $telefono;
		$this->genero = $genero;
    	
	}



	

	/**
	 * Get the value of telefono
	 */ 
	public function getTelefono()
	{
		return $this->telefono;
	}

	/**
	 * Set the value of telefono
	 *
	 * @return  self
	 */ 
	public function setTelefono($telefono)
	{
		$this->telefono = $telefono;

		return $this;
	}

	/**
	 * Get the value of genero
	 */ 
	public function getGenero()
	{
		return $this->genero;
	}

	/**
	 * Set the value of genero
	 *
	 * @return  self
	 */ 
	public function setGenero($genero)
	{
		$this->genero = $genero;

		return $this;
	}

	/**
	 * Get the value of listaBoda
	 */ 
	public function getListaBoda()
	{
		return $this->listaBoda;
	}

	/**
	 * Set the value of listaBoda
	 *
	 * @return  self
	 */ 
	public function setListaBoda($listaBoda)
	{
		$this->listaBoda = $listaBoda;

		return $this;
	}

	/**
	 * Get the value of listaViaje
	 */ 
	public function getListaViaje()
	{
		return $this->listaViaje;
	}

	/**
	 * Set the value of listaViaje
	 *
	 * @return  self
	 */ 
	public function setListaViaje($listaViaje)
	{
		$this->listaViaje = $listaViaje;

		return $this;
	}

	/**
	 * Get the value of listaProducto
	 */ 
	public function getListaProducto()
	{
		return $this->listaProducto;
	}

	/**
	 * Set the value of listaProducto
	 *
	 * @return  self
	 */ 
	public function setListaProducto($listaProducto)
	{
		$this->listaProducto = $listaProducto;

		return $this;
	}
}

?>