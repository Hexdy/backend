<?php
echo "hola";

class Query{
  private $connect;
  public function __construct($connect, $table, $values=[], $identifiers=[], $columns=[])
  {
  $this->connect = $connect;

  //CRUD = C:0, R:1 (varia si hay o no identifier), U:2, D:3


  }

  //ej: QueryCreator($mySqli, $table, )->insert__function();
  private function insert_function($table, $values=[], $columns=[]){
    
    $string = '';

    //transforma el array de values en un string ideal para usarlo en sql
    foreach ($values as $element) {
        $string .= "'$element', ";

    }
    
    $string = rtrim($string, ', '); 
    $set = $table."(".$columns.")";

    if ($result = $this->connect -> query("INSERT INTO $set VALUES ($string)")) {
      $response  = $result;
      $this->connect->close();  
      return $response;

    }
  }


  private function read_function($table, $values=[], $identifiers=[], $columns=[]){
  
    if ($identifiers){
      $condition='';
      for ($i=0;$i<count($identifiers); $i++){
      $condition.= "'$identifiers[$i]'='$values[$i], '";
  }
  $condition = rtrim($condition, ', ');

      if ($result = $this->connect -> query("SELECT * FROM $table WHERE $condition")) {
        $response  = $result -> fetch_all();
        $this->connect->close();  
        return $response;

    }
    }

    else{
    if ($result = $this->connect -> query("SELECT * FROM $table")) {
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
    for($i=0; $i<count($columns);$i++){
        $string .= "'$values[$i]'='$columns[$i]', ";

    }

    $string = rtrim($string, ', ');
    
    $condition ='';
    for ($i=0;$i<count($identifiers); $i++){
    $condition.= "'$identifiers[$i]'='$values[$i], '";
}
$condition = rtrim($condition, ', ');
        if ($result = $connect -> query("UPDATE $table SET $string WHERE $condition")) {
          $connect->close();  
          $response  = $result;
          $connect->close();  
          return $response;
    }

  }
  private function delete_function(){
    $condition ='';
    for ($i=0;$i<count($identifiers); $i++){
    $condition.= "'$identifiers[$i]'='$values[$i], '";
}
$condition = rtrim($condition, ', ');
    if ($result = $connect -> query("DELETE FROM $table WHERE $condition")) {
      $connect->close();  
      $response  = $result;
      $connect->close();  
      return $response;
    }

  }
  }
?>