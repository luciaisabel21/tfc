<?php

class Invitado extends Persona {
	private $relacion;
	

	public function __construct($id, $nombre, $email, $contraseña, $relacion) {
    	parent::__construct($id, $nombre, $email,  $contraseña);
    	$this->relacion = $relacion;
    	
	}
   


	/**
	 * Get the value of relacion
	 */ 
	public function getRelacion()
	{
		return $this->relacion;
	}

	/**
	 * Set the value of relacion
	 *
	 * @return  self
	 */ 
	public function setRelacion($relacion)
	{
		$this->relacion = $relacion;

		return $this;
	}
}


?>