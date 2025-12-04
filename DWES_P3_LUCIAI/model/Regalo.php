<?php

class Regalo {
	private $id;
	private $nombre;
	private $descripcion;
	private $precio;

	public function __construct($id, $nombre, $descripcion, $precio) {
    	$this->id = $id;
    	$this->nombre = $nombre;
    	$this->descripcion = $descripcion;
    	$this->precio = $precio;
	}
}


?>