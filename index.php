<?php
echo "hola";

class QueryMethod{
    public $connect, $table, $operation, $query;
  public function __construct($connect, $table, $operation, $values=[], $identifier="")
  {
  $this->connect = $connect;
  $this->table = $table;
  $this->values = $values;
  $this->condition = $condition;

  //CRUD = C:0, R:1, U:2, D:3
  switch ($operation) {
    case 0:
        create_function();
        break;
    case 1:

        break;
    case 2:

        break;
    
    case 3:

        break;

}

  }

  private function insert_function(){
    
    $string = '';

    //transforma el array de values en un string ideal para usarlo en sql
    foreach ($this->values as $element) {
        $string .= "'$element', ";

    }
    
    $string = rtrim($string, ', ');

    if ($result = $mysqli -> query("INSERT INTO $this->table VALUES ($string)")) {
        return $result -> fetch_all();

    }
  }


  private function read_function(){

    if ($result = $mysqli -> query("SELECT * FROM $this->table")) {
        return $result -> fetch_all();

    }
  }


  private function update_function(){

    $string = '';
    for($i=0; $i<count($columns);$i++){
        $string .= "'$value =$this->values[$i]'='$column=$this->columns[$i]', ";

    }

    $string = rtrim($string, ', ');
    $identifier= "'$columns[0]'='$values[0]'";
        if ($result = $mysqli -> query("UPDATE $this->table SET $string WHERE $string")) {
        return $result -> fetch_all();
    }

  }
  private function delete_function(){
    if ($result = $mysqli -> query("SELECT * FROM $this->table")) {
        return $result -> fetch_all();
    }

  }
  }


?>