<?php
require_once "./models/connection.php";
require_once "./util/plural.php";
require_once "./util/lista.php";

class PostModel
{
    static public function putData(string $table, array $fields, array $values)
    {
        $query = "INSERT INTO $table("
            . lista($fields, false)
            . ") VALUES ("
            . lista($values, true)
            . ");";
        wLog("QUERY", $query);
        try {
            $connection = Connection::connect();

            // Ejecutar la consulta de inserción
            $stmt = $connection->query($query);

            if ($stmt !== false) {
                // Obtener el último ID generado
                $lastInsertedId = $connection->lastInsertId();

                // Construir la respuesta con el último ID y los datos insertados
                $respuesta = array(
                    'resultado' => 'exito',
                    'mensaje' => 'Inserción exitosa',
                    'lastInsertedId' => $lastInsertedId,
                    'datosInsertados' => $_POST // Puedes usar $_POST o cualquier otra fuente de datos
                );
            } else {
                // Error: la consulta no se ejecutó correctamente
                $errorInfo = $connection->errorInfo();
                $respuesta = array(
                    'resultado' => 'error',
                    'mensaje' => 'Error en la inserción: ' . $errorInfo[2]
                );
            }
        } catch (PDOException $e) {
            // Excepción: se produjo un error en el proceso
            $respuesta = array(
                'resultado' => 'error',
                'mensaje' => 'Error: ' . $e->getMessage()
            );
        }

        echo json_encode($respuesta);
    }
}
