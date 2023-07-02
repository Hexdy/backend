<?php


class QueryCall
{
  private $connect, $query;
  public function __construct($connect)
  {
    $this->connect = $connect;

    //CRUD = C:0, R:1 (varia si hay o no identifier), U:2, D:3

  }

  //ej: QueryCall($mySqli, $table, )->insert();

  ///////////////////////////////////////////////////////////////////////////CREACION//////////////////////////////////////////////////////////////////////////////////C

  public function insert($table, $values = [], $columns = [])
  {

    $string = "";
    $columns_str = "";
    //transforma el array de values en un string ideal para usarlo en sql
    for ($i = 0; $i < count($columns); $i++) {
      $string .= "'$values[$i]', ";
      $columns_str .= "$columns[$i], ";
    }

    $string = rtrim($string, ', ');
    $columns_str = rtrim($columns_str, ', ');
    $set = $table . "(" . $columns_str . ")";
    $this->query = "INSERT INTO $set VALUES ($string) ";
    return $this;
  }

  ///////////////////////////////////////////////////////////////////////////LECTURA/BUSQUEDA////////////////////////////////////////////////////////////////////////R

  public function select($table, $values = [], $identifiers = [], $columns = [])
  {

    $string = '';
    for ($i = 0; $i < count($columns); $i++) {
      $string .= "$columns[$i], ";
    }
    $string = rtrim($string, ', ');


    if ($identifiers) {
      $condition = '';

      for ($i = 0; $i < count($identifiers); $i++) {
        $condition .= "$identifiers[$i]='$values[$i]' AND ";
        $condition = rtrim($condition, 'AND ');
      }

      $this->query = "SELECT $string FROM $table WHERE $condition";
    } else {
      $this->query = "SELECT $string FROM $table";
    }
    return $this;
  }

  ///////////////////////////////////////////////////////////////////////////ACTUALIZACION///////////////////////////////////////////////////////////////////////////U
  public function update($table, $values = [], $identifiers = [], $columns = [])
  {
    // Esta es medio un embole ya que necesita los valores a cambiar, las casillas a cambiar, el identificador
    //que sera una cantidad de casillas pk, y el valor que han de tener, el cual es parte de columnas y valores
    $string = '';
    for ($i = 0; $i < count($columns); $i++) {
      $string .= "$columns[$i]='$values[$i]', ";
    }

    $string = rtrim($string, ', ');

    $condition = '';
    for ($i = 0; $i < count($identifiers); $i++) {
      $condition .= "$identifiers[$i]='$values[$i], '";
    }
    $condition = rtrim($condition, ', ');
    $this->query = "UPDATE $table SET $string WHERE $condition";

    return $this;
  }

  ///////////////////////////////////////////////////////////////////////////ELIMINACION////////////////////////////////////////////////////////////////////////D

  public function delete($table, $values = [], $identifiers = [])
  {
    $condition = '';
    for ($i = 0; $i < count($identifiers); $i++) {
      $condition .= "$identifiers[$i]='$values[$i]', ";
    }
    $condition = rtrim($condition, ', ');

    $this->query = "DELETE FROM $table WHERE $condition";
    return $this;
  }
  ////////////////////////////////////////////////////////////////////////////Query Setter/////////////////////////////////////////////////////////////////////
  public function setQuery($query)
  {
    $this->query = $query;
    return $this;
  }
  ///////////////////////////////////////////////////////////////////////////Calling///////////////////////////////////////////////////////////////////////////
  public function call()
  {
    if ($this->query) {
      $result = $this->connect->query($this->query);
      $response  = strtoupper(explode(" ", $this->query)[0]) == "SELECT" ? $result->fetch_all() : $result;
      $this->connect->close();
      return $response;
    }
  }
}

/*
Puedes bien enviar los datos basicos con insert, select, update y delete, o determinar el query a enviar con setQuery, despues usando call() para
enviar el query directamente, porfavor usa el insert, select, update y delete de la forma correcta, sin florituras, si quieres usar un join no hay lío si usas
el setter de query, pero los demas son lo más basico.
select tiene 2 modos, uno con el identifier y otro sin, el sin te traerá los datos sin discriminacion, el otro que seria el search te da la opcion de usar los
identificadores para buscar de forma discriminada, identificador es un array, donde cada identificador debe corresponder a un valor ($values[n]) en su orden, 
el primer identificador usara siempre el primer valor, y así, por ahora no podemos usar OR, usara siempre un AND
*/