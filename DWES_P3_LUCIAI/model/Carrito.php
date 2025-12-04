<?php

class Carrito {
	private Usuario $usuarioId;
	private $productos = [];
	private $viajes = [];


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
	 * Get the value of productos
	 */ 
	public function getProductos()
	{
		return $this->productos;
	}

	/**
	 * Set the value of productos
	 *
	 * @return  self
	 */ 
	public function setProductos($productos)
	{
		$this->productos = $productos;

		return $this;
	}

	/**
	 * Get the value of viajes
	 */ 
	public function getViajes()
	{
		return $this->viajes;
	}

	/**
	 * Set the value of viajes
	 *
	 * @return  self
	 */ 
	public function setViajes($viajes)
	{
		$this->viajes = $viajes;

		return $this;
	}
}


?>