<?php



namespace LKGames\Entity;
class GameEntity{

    private $id_game;
    private $titulo;
    private $fecha_salida;
    private $descripcion;
    private $img;

    public function getId_game()
    {
		return $this->id_game;
	}

    public function getTitulo()
    {
		return $this->titulo;
	}

    public function getFecha_salida()
    {
        return implode('/', array_reverse(explode('-', $this->fecha_salida)));
	}

    public function getDescipcion()
    {
		return $this->descripcion;
	}

	public function getImg(){
		return $this->img;
	}

    public function getImgHTML() {
		if ($this->img !== null) {
			$base64Img = base64_encode($this->img);
			$imgSrc = 'data:image/jpeg;base64,' . $base64Img;
			return '<img src="' . $imgSrc . '" alt="Portada del juego ' . htmlspecialchars($this->titulo) . '" class="img-responsive" style="max-width: 100%; height: auto;">';
		} else {
			return '<img src="ruta/a/imagen/por/defecto.jpg" alt="Imagen no disponible" class="img-responsive" style="max-width: 100%; height: auto;">';
		}
	}

    public function setId_game($value)
	{
		$this->id_game = $value;
	}

    public function setTitulo($value)
	{
		$this->titulo = $value;
	}

	public function setFecha_salida($value)
	{
		$this->fecha_salida = $value;
	}

    public function setDescripcion($value)
	{
		$this->descripcion = $value;
	}

    public function setImg($value)
	{
		$this->img = $value;
	}

}