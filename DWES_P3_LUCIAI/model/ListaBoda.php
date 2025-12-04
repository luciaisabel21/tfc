<?php

class ListaBoda {
	private String $id;
	private Usuario $usuarioId;
	private String $nombreLista;
	private DateTime $fechaCreacion;
	private $regalos = [];
	private $invitados = [];

	public function __construct($id, $usuarioId, $nombreLista, $fechaCreacion) {
    	$this->id = $id;
    	$this->usuarioId = $usuarioId;
    	$this->nombreLista = $nombreLista;
    	$this->fechaCreacion = $fechaCreacion;
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
	 * Get the value of usuarioId
	 */ 
	public function getUsuarioId()
	{
		return $this->usuarioId;
	}

	/**
	 * Set the value of usuarioId
	 *
	 * @return  self
	 */ 
	public function setUsuarioId($usuarioId)
	{
		$this->usuarioId = $usuarioId;

		return $this;
	}

	/**
	 * Get the value of nombreLista
	 */ 
	public function getNombreLista()
	{
		return $this->nombreLista;
	}

	/**
	 * Set the value of nombreLista
	 *
	 * @return  self
	 */ 
	public function setNombreLista($nombreLista)
	{
		$this->nombreLista = $nombreLista;

		return $this;
	}

	/**
	 * Get the value of fechaCreacion
	 */ 
	public function getFechaCreacion()
	{
		return $this->fechaCreacion;
	}

	/**
	 * Set the value of fechaCreacion
	 *
	 * @return  self
	 */ 
	public function setFechaCreacion($fechaCreacion)
	{
		$this->fechaCreacion = $fechaCreacion;

		return $this;
	}

	/**
	 * Get the value of regalos
	 */ 
	public function getRegalos()
	{
		return $this->regalos;
	}

	/**
	 * Set the value of regalos
	 *
	 * @return  self
	 */ 
	public function setRegalos($regalos)
	{
		$this->regalos = $regalos;

		return $this;
	}

	/**
	 * Get the value of invitados
	 */ 
	public function getInvitados()
	{
		return $this->invitados;
	}

	/**
	 * Set the value of invitados
	 *
	 * @return  self
	 */ 
	public function setInvitados($invitados)
	{
		$this->invitados = $invitados;

		return $this;
	}
}



?>