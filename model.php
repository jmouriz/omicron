<?php
namespace ORM;

use \PDO;

$string = 'sqlite:database.db';
$username = null;
$password = null;

class Model {
   protected $fields = array();
   protected $connection;
   protected $table;
   protected $data;
   protected $key;

   public function __construct() {
      global $string, $database, $password;
      $options = array(
         PDO::ATTR_PERSISTENT => true,
         PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
      );
      $this->connection = new PDO($string, $database, $password, $options);
      $this->data = (object) array();
   }

   public function __destruct() {
      $this->connection = null;
   }

   public function __set($key, $value) {
      if (in_array($key, $this->fields)) {
         $this->data->$key = $value;
      }
   }

   public function __get($key) {
      if (property_exists($this->data, $key)) {
         return $this->data->$key;
      }
   }

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

   public function get() {
      return $this->data;
   }

   public function index($key) {
      $this->key = $key;
   }

   public function key($value = null) {
      $key = $this->key;
      if ($value === null) {
         return $this->$key;
      } else {
         $this->$key = $value;
      }
   }

   public function all() {
      $query = $this->query("select * from {$this->table}");
      return $query->fetchAll(PDO::FETCH_OBJ);
   }

   public function select($key) {
      $this->key($key);
      $query = $this->query("select * from {$this->table} where {$this->key} = :{$this->key}");
      $data = $query->fetch(PDO::FETCH_OBJ);
      if ($data) {
         $this->data = $data;
      }
      return $data;
   }

   public function update() {
      $set = array();
      foreach ($this->data as $key => $value) {
         $set[] = "$key = :$key";
      }
      $expression = implode(',', $set);
      $this->query("update {$this->table} set $expression where {$this->key} = :{$this->key}");
   }

   public function insert() {
      $fields = implode(',', $this->fields);
      $values = implode(',:', $this->fields);
      $this->query("insert into {$this->table} ($fields) values (:$values)");
      $this->key($this->connection->lastInsertId());
   }

   public function delete() {
      $this->query("delete from {$this->table} where {$this->key} = :{$this->key}");
   }

   public function save() {
      if ($this->key()) {
         $this->update();
      } else {
         $this->insert();
      }
   }
}
?>
