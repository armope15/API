<?php

//echo " hola connect";
/**
 * Class Connection
 *
 * Represents a database connection using PDO (PHP Data Objects).
 */
class Connection{

    /**
     * The name of the database.
     * @var string
     */
    static private string $name = "club_de_lectura_db";

    /**
     * The username for the database connection.
     * @var string
     */
    static private string $user = "root";

    /**
     * The password for the database connection.
     * @var string
     */
    static private string $password = "";

    /**
     * Establishes a database connection using the provided credentials.
     *
     * @return PDO|null Returns a PDO object representing the database connection, or null on failure.
     */
    static public function connect(){
        try
        {
            $conn = new PDO("mysql:host=localhost;dbname=" . Connection::$name, Connection::$user, Connection::$password);
            $conn->exec("set names utf8");
            wLog("CONNECTION","Conexion realizada con exito");

        } catch(PDOException $e) {
            wLog("ERROR","Error en la conexion " . $e->getMessage());
            die("ERROR : " . $e->getMessage());
        }
        return $conn;
    }
}
