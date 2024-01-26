<?php
require_once "./models/connection.php";
require_once "./util/plural.php";
require_once "./util/lista.php";
wLog("require", "cargado put.model.php");
class PutModel
{
    static public function putData(string $table, array $keys, array $values, int $id)
    {
        wLog("INFO", "inicio PutModel::putData");
        try {
            // Construir la consulta SQL para la actualización
            $updateQuery = "UPDATE $table SET ";

            foreach ($keys as $index => $key) {
                if ($key !== "id") {
                    $updateQuery .= "$key = :$key";
                    if ($index < count($keys) - 1) {
                        $updateQuery .= ", ";
                    }
                }
            }
            $table = Plural::toSingular($table); 
            $updateQuery .= " WHERE id_$table = :id";

            wLog("query" , $updateQuery);
            wLog("query", "ID: " . $id);

            // Preparar la consulta
            $stmt = Connection::connect()->prepare($updateQuery);

            // Bind de los valores
            foreach ($keys as $key) {
                if ($key !== "id") {
                    $stmt->bindValue(":$key", $values[$key]);
                    wLog("bindVALUE" , $key . " = " . $values[$key],2);

                }
            }

            // Bind del ID
            $stmt->bindValue(":id", $id);

            // Ejecutar la consulta
            $stmt->execute();
        } catch (PDOException $e) {
            $json = [
                'status' => 400,
                'result' => "Error"
            ];
            echo json_encode($json, http_response_code($json["status"]));
            return;
        }
        wLog("INFO", "RESULTADO CORRECTO DEL METODO PUT");
        $json = [
            'status' => 200,
            'result' => "correcto",
            'query'  => $updateQuery
        ];
        echo json_encode($json, http_response_code($json["status"]));
    }
}
