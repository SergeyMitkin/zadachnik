<?php

require_once('../config/config.php');

// Клас для работы с БД через PDO
class SQL{
    protected static $_instance; // экземпляр класса
    protected $connect_str;
    protected $db;

    private function __construct(){
        setlocale(LC_ALL, 'ru_RU'.'UTF8'); // Устанавливаем локаль и кодировку
        $this->connect_str = $connect_str = DB_DRIVER . ':host='. DB_HOST . ';dbname=' . DB_NAME; // Строка для подключения к БД
        $this->db = new PDO($connect_str,DB_USER,DB_PASS); // Подключаемся к БД
        $this->db->exec("SET names UTF-8"); // Устанавливаем кодировку
        }

    // Создаём метод для обращения к БД, если ещё не создан
    public static function getInstance(){
        if(empty(self::$_instance)){
            self::$_instance = new SQL;
        }
        return self::$_instance;
    }

    // Read
    public function Select($query){
        $q = $this->db->prepare($query);
        $q->execute();
        return $q->fetchAll();
    }

    // Create
    public function Insert($table, $object){
        $columns = array();
        foreach($object as $key=>$value) {
            $columns[] = $key;
            $masks[] = ":$key";
        }
            $columns_s = implode(',' ,$columns);
            $masks_s = implode(',' , $masks);
            $query = "INSERT INTO $table ($columns_s) VALUES ($masks_s)";
            $q = $this->db->prepare($query);
            $q->execute($object);
        if($q->errorCode() != PDO::ERR_NONE){
            $info = $q->errorInfo();
            die($info[2]);
        }
            return $this->db->lastInsertId();
        }

        // Update
    public function Update($table,$object,$where){
        $sets = array();

        foreach($object as $key => $value){
            $sets[] = "$key=:$key";
            if($value === NULL){
                $object[$key]='NULL';
            }
        }

        $sets_s = implode(',',$sets);
        $query = "UPDATE $table SET $sets_s WHERE $where";

        $q = $this->db->prepare($query);
        $q->execute($object);

        if($q->errorCode() != PDO::ERR_NONE){
            $info = $q->errorInfo();
            die($info[2]);
        }
        return $q->rowCount();
    }

    //Delete
    public function Delete($table, $where){
        $query = "DELETE FROM $table WHERE $where";
        $q = $this->db->prepare($query);
        $q->execute();

        if($q->errorCode() != PDO::ERR_NONE){
            $info = $q->errorInfo();
            die($info[2]);
        }

        return $q->rowCount();
    }
}
