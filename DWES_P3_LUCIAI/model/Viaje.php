<?php
class Viaje extends Venta {
	private String $destino;
	private DateTime $fechaDisponible;

	public function __construct($id, $precio, $descripcion, $destino, $fechaDisponible) {
    	parent::__construct($id, $precio, $descripcion);
    	$this->destino = $destino;
    	$this->fechaDisponible = $fechaDisponible;
	}



	/**
	 * Get the value of destino
	 */ 
	public function getDestino()
	{
		return $this->destino;
	}

	/**
	 * Set the value of destino
	 *
	 * @return  self
	 */ 
	public function setDestino($destino)
	{
		$this->destino = $destino;

		return $this;
	}

	/**
	 * Get the value of fechaDisponible
	 */ 
	public function getFechaDisponible()
	{
		return $this->fechaDisponible;
	}

	/**
	 * Set the value of fechaDisponible
	 *
	 * @return  self
	 */ 
	public function setFechaDisponible($fechaDisponible)
	{
		$this->fechaDisponible = $fechaDisponible;

		return $this;
	}
}
?>
