<?php
/**
 * @package ORM
 * @author Juan Manuel Mouriz <jmouriz@gmail.com>
 * @copyright 2017 Juan Manuel Mouriz
 * @license https://opensource.org/licenses/mit-license.php The MIT License
 */
namespace ORM;

use \PDO;

$string = 'sqlite:database.db';
$username = null;
$password = null;

/**
 * Clase que representa un modelo de datos
 */
class Model {
   /**
    * @ignore
    */
   protected $connection;

   /**
    * @property array $fields Los campos de la tabla
    */
   protected $fields = array();

   /**
    * @property string $table El nombre de la tabla
    */
   protected $table;

   /**
    * @ignore
    */
   protected $data;

   /**
    * @property string $key La llave primaria que identifica cada fila
    */
   protected $key;

   /**
    * @ignore
    */
   public function __construct() {
      global $string, $database, $password;
      $options = array(
         PDO::ATTR_PERSISTENT => true,
         PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
      );
      $this->connection = new PDO($string, $database, $password, $options);
      $this->data = (object) array();
   }

   /**
    * @ignore
    */
   public function __destruct() {
      $this->connection = null;
   }

   /**
    * @ignore
    */
   public function __set($key, $value) {
      if (in_array($key, $this->fields)) {
         $this->data->$key = $value;
      }
   }

   /**
    * @ignore
    */
   public function __get($key) {
      if (property_exists($this->data, $key)) {
         return $this->data->$key;
      }
   }

   /**
    * Ejecuta una sentencia SQL
    *
    * @param string $sql La sentencia a ejecutar
    */
   protected function query($sql) {
      $query = $this->connection->prepare($sql);
      foreach ($this->data as $key => $value) {
         if (preg_match("/:$key/", $sql)) {
            $query->bindValue(":$key", $value);
         }
      }
      $query->execute();
      return $query;
   }

   /**
    * Devuelve la fila actual
    *
    * @return object La fila actual
    */
   public function get() {
      return $this->data;
   }

   /**
    * Establece una columna de búsqueda diferente a la llave primaria
    *
    * @param string $key La columna de búsqueda
    */
   public function index($key) {
      $this->key = $key;
   }

   /**
    * Establece o devuelve el valor único que identifica una fila,
    * es decir, el valor de la llave primaria
    *
    * @param string|null $key El valor único que identifica la fila
    *
    * @return mixed El valor único que identifica la fila
    */
   public function key($value = null) {
      $key = $this->key;
      if ($value === null) {
         return $this->$key;
      } else {
         $this->$key = $value;
      }
   }

   /**
    * Selecciona todos los registros de la tabla
    *
    * @return array Todos los registros de la tabla
    */
   public function all() {
      $query = $this->query("select * from {$this->table}");
      return $query->fetchAll(PDO::FETCH_OBJ);
   }

   /**
    * Selecciona un registro
    *
    * @param mixed $key El valor de la clave primaria que identifica al registro
    *
    * @return object El registro cuya clave primaria sea $key
    */
   public function select($key) {
      $this->key($key);
      $query = $this->query("select * from {$this->table} where {$this->key} = :{$this->key}");
      $data = $query->fetch(PDO::FETCH_OBJ);
      if ($data) {
         $this->data = $data;
      }
      return $data;
   }

   /**
    * Actualiza una fila
    */
   public function update() {
      $set = array();
      foreach ($this->data as $key => $value) {
         $set[] = "$key = :$key";
      }
      $expression = implode(',', $set);
      $this->query("update {$this->table} set $expression where {$this->key} = :{$this->key}");
   }

   /**
    * Inserta una fila
    */
   public function insert() {
      $fields = implode(',', $this->fields);
      $values = implode(',:', $this->fields);
      $this->query("insert into {$this->table} ($fields) values (:$values)");
      $this->key($this->connection->lastInsertId());
   }

   /**
    * Elimina una fila
    */
   public function delete() {
      $this->query("delete from {$this->table} where {$this->key} = :{$this->key}");
   }

   /**
    * Actualiza o inserta una fila según exista un valor para la llave primaria.
    * Si existe un valor para la llave primaria, el registro se actualiza, en
    * caso contrario, se inserta
    */
   public function save() {
      if ($this->key()) {
         $this->update();
      } else {
         $this->insert();
      }
   }
}
?>
