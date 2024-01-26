<?php

wLog("REQUIRED", "cargado put.controller");

require_once "./models/put.model.php";
require_once "./util/plural.php";
require_once "./util/lista.php";


class PutController
{
    static public function putData(string $table)
    {

        $data = array();
        $data = json_decode(file_get_contents('php://input'), true);

        if ($data === null) {
            wLog("ERROR", "ERROR en los datos enviados por PUT");
            // Manejar el caso en el que los datos no son JSON válido
            http_response_code(400); // Bad Request
            echo json_encode(array("mensaje" => "Los datos no son válidos."));
            return;
        }
        wLog("INFO", "Datos correctos enviados por PUT id:" . $data['id']);
        wLog("INFO", "Datos correctos enviados por PUT name:" . $data['name_user']);
        wLog("INFO", "Datos correctos enviados por PUT id:" . $data);


        try {
            $keys = array_keys($data);
            //8$values = array_values($data);

            

            PutModel::putData($table, $keys, $data, $data['id']);

            // Devolver una respuesta en formato JSON
            header('Content-Type: application/json');
            echo json_encode(array("mensaje" => "Datos actualizados correctamente."));
        } catch (Exception $e) {
            // Excepción: se produjo un error en el proceso
            $respuesta = array(
                'resultado' => 'error',
                'mensaje' => 'Error: ' . $e->getMessage(),
            );
            echo json_encode($respuesta);
        }
    }
}
