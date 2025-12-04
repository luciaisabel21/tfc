<?php

abstract class Venta {
	private String $id;
	private  $precio;
	private String $descripcion;

	public function __construct($id, $precio, $descripcion) {
    	$this->id = $id;
    	$this->precio = $precio;
    	$this->descripcion = $descripcion;
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
	 * Get the value of precio
	 */ 
	public function getPrecio()
	{
		return $this->precio;
	}

	/**
	 * Set the value of precio
	 *
	 * @return  self
	 */ 
	public function setPrecio($precio)
	{
		$this->precio = $precio;

		return $this;
	}

	/**
	 * Get the value of descripcion
	 */ 
	public function getDescripcion()
	{
		return $this->descripcion;
	}

	/**
	 * Set the value of descripcion
	 *
	 * @return  self
	 */ 
	public function setDescripcion($descripcion)
	{
		$this->descripcion = $descripcion;

		return $this;
	}
}



?>