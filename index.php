<?php
echo "hola";

class QueryMethod{
  private $connect, $table, $values, $columns, $identifiers;
  public function __construct($connect, $table, $operation, $values=[], $identifiers=[], $columns=[])
  {
  $this->connect = $connect;
  $this->table = $table;
  $this->values = $values; 
  $this->columns = $columns; 
  //values y columns siempre seran listas, sin duda
  $this->identifiers = $identifiers;

  //CRUD = C:0, R:1 (varia si hay o no identifier), U:2, D:3
  switch ($operation) {
    case 0:
        break;
    case 1:

        break;
    case 2:

        break;
    
    case 3:

        break;

}

  }

  //ej: QueryCreator($mySqli, $table, )->insert__function();
  private function insert_function(){
    
    $string = '';

    //transforma el array de values en un string ideal para usarlo en sql
    foreach ($this->values as $element) {
        $string .= "'$element', ";

    }
    
    $string = rtrim($string, ', ');

    if ($result = $this->connect -> query("INSERT INTO $this->table VALUES ($string)")) {
      $response  = $result;
      $this->connect->close();  
      return $response;

    }
  }


  private function read_function(){
  
    if ($this->identifiers){
      $condition='';
      for ($i=0;$i<count($this->identifiers); $i++){
      $condition.= "'$this->identifiers[$i]'='$this->values[$i], '";
  }
  $condition = rtrim($condition, ', ');

      if ($result = $this->connect -> query("SELECT * FROM $this->table WHERE $condition")) {
        $response  = $result -> fetch_all();
        $this->connect->close();  
        return $response;

    }
    }
    else{
    if ($result = $this->connect -> query("SELECT * FROM $this->table")) {
      $response  = $result -> fetch_all();
      $this->connect->close();  
      return $response;

  }
    }

  }


  private function update_function($pkeys){
    // Esta es medio un embole ya que necesita los valores a cambiar, las casillas a cambiar, el identificador
    //que sera una cantidad de casillas pk, y el valor que han de tener, el cual es parte de columnas y valores
    $string = '';
    for($i=0; $i<count($this->columns);$i++){
        $string .= "'$this->values[$i]'='$this->columns[$i]', ";

    }

    $string = rtrim($string, ', ');
    
    $condition ='';
    for ($i=0;$i<count($this->identifiers); $i++){
    $condition.= "'$this->identifiers[$i]'='$this->values[$i], '";
}
$condition = rtrim($condition, ', ');
        if ($result = $this->connect -> query("UPDATE $this->table SET $string WHERE $condition")) {
          $this->connect->close();  
          $response  = $result;
          $this->connect->close();  
          return $response;
    }

  }
  private function delete_function(){
    $condition ='';
    for ($i=0;$i<count($this->identifiers); $i++){
    $condition.= "'$this->identifiers[$i]'='$this->values[$i], '";
}
$condition = rtrim($condition, ', ');
    if ($result = $this->connect -> query("DELETE FROM $this->table WHERE $condition")) {
      $this->connect->close();  
      $response  = $result;
      $this->connect->close();  
      return $response;
    }

  }
  }
?>