<?php
$mysqli = new mysqli("localhost","root", "", "prueba", 3306);

if ($mysqli -> connect_errno) {
    echo "Hubo un fallo de conexion: " . $mysqli -> connect_error;
    exit();

}
else {
    echo "<h4 style='color:green;'>Se conecto correctamente.</h4>";
}
class QueryMethod{
  public $connect,$operation, $values, $quantity, $condition, $query;
  private function serQuery(){
    if($this->connect&$this->operation&$this->values&$this->quantity&$this->condition){
      if(strtoupper($this->operation)==="SELECT"){
        $this->operation += " *";
        $value = " FROM";
        foreach($this->values as $part){
          $value += $part . ",";
          //aqui faltan cosas 
        }
        $this->$value;
      }
      // Values es: Array ( [0] => Array ( ) [1] => Array (  ) ) donde el 0 son los values y el 1 es el contenido
      $this->query = "$this->operation  FROM  $this->values ";
    }
  }
public function __construct($connect, $operation, $values, $quantity, $condition)
{
$this->connect = $connect;
$this->operation = $operation;
$this->values = $values;
$this->quantity = $quantity;
$this->condition = $condition;
}

}

if ($result = $mysqli -> query("SELECT * FROM TablaDePrueba")) {
    $rows = $result -> fetch_all();
    echo "<h3>1)-Las lineas devueltas son:</h3>";

    foreach ($rows as $row){
        echo $row[0];
        echo $row[1];
        echo '<br>';
    }

    echo "<h3>2)-Tipo de dato: </h3>" . gettype($rows);
    echo '<br>';

    $result -> free_result();
  }


  echo "<br>";
  echo '<br>';

  if ($result = $mysqli -> query("SELECT * FROM TablaDePrueba WHERE id=3")) {
    $rows = $result -> fetch_all();
    echo "<h3>1)-La linea devuelta es: </h3>"; 
    print_r($rows[0]);
    echo '<br>';
    echo "<h3>2)-Tipo de dato: </h3>" . gettype($rows);

    //Limpia el resultado de la busqueda
    $result -> free_result();
  }

  echo "<br>";
  echo '<br>';

  if ($result = $mysqli -> query("SELECT * FROM TablaDePrueba WHERE id=6")) {
    $rows = $result -> fetch_all();
    echo "<h3>1)-La linea no devuelta es: </h3>"; 
    print_r($rows);
    echo '<br>';

    echo "<h3>2)-Tipo de dato: </h3>" . gettype($rows);

    //Limpia el resultado de la busqueda
    $result -> free_result(); 

    $mysqli -> close();

  }
    




?>
