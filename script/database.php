<?php

class Database extends mysqli {
    public function __construct() {
        $db = parse_ini_file('../database.ini');

        parent::__construct(
            $db['host'], $db['user'], 
            $db['pass'], $db['name']
        );
    }

    function all(string $table, string $columns = '*', string $order_by = 'id') : array {
        $sql = "SELECT $columns FROM $table ORDER BY $order_by;";
        $res = $this->query($sql);

        return $res->fetch_all(MYSQLI_ASSOC);
    }

    function filter(string $table, string $conditions, string $columns = '*', string $order_by = 'id') : array {
        $sql = "SELECT $columns FROM $table WHERE $conditions ORDER BY $order_by;";
        $res = $this->query($sql);

        return $res->fetch_all(MYSQLI_ASSOC);
    }

    function get(int $id, string $table, string $columns = '*') : array {
        $sql = "SELECT $columns FROM $table WHERE id = $id";
        $res = $this->query($sql);
        $record = $res->fetch_assoc();

        if(empty($record)) header(
            'location: 404.php?msg=Record not found!!!'
        );

        return $record;
    }

    function run_query(string $sql) : bool {
        try {
            return $this->query($sql);
        } catch(Exception $e) {
            $delay = 5;
            header('Refresh: '. $delay);
            die(
                $e->getMessage() . '<br><hr>' .
                "<h2>Page will refresh after $delay seconds</h2>"
            );
            return false;
        }        
    }

    function insert_record(string $table, string ...$record_data) : bool {
        $fields = array_keys($record_data);
        $values = array_values($record_data);
        $values = array_map(fn($value) => "'$value'", $values);
        $fields = implode(', ', $fields);
        $values = implode(', ', $values);
        $sql = "INSERT INTO $table($fields) VALUES($values);";

        return $this->run_query($sql);
    }

    function update_record(int $id, string $table, string ...$data) : bool {
        $data = implode(', ', array_map(
            fn($key, $value) => "$key = '$value'", 
            array_keys($data), array_values($data)
        ));

        $sql = "UPDATE $table SET $data WHERE id = $id;";

        return $this->run_query($sql);
    }

    function delete_record(int $id, string $table) : bool {
        $sql = "DELETE FROM $table WHERE id = $id";
        return $this->run_query($sql);
    }
}

$db = new Database();
?>