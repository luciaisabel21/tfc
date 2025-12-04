<?php

class Producto extends Venta {
	private $nombre;
	private $cantidad;

	public function __construct($id, $precio, $descripcion, $nombre, $cantidad) {
    	parent::__construct($id, $precio, $descripcion);
    	$this->nombre = $nombre;
    	
    	$this->cantidad = $cantidad;
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
	 * Get the value of cantidad
	 */ 
	public function getCantidad()
	{
		return $this->cantidad;
	}

	/**
	 * Set the value of cantidad
	 *
	 * @return  self
	 */ 
	public function setCantidad($cantidad)
	{
		$this->cantidad = $cantidad;

		return $this;
	}
}



?>