<?php
require_once "./models/post.model.php";
require_once "./util/plural.php";

class PostController
{
    static public function putData(string $table)
    {
       
         $keys = array();
         $values = array();

         $keys = array_keys($_POST);
         $values = array_values($_POST);

         PostModel::putData($table , $keys , $values);
        
        
         // $form_data = array();
        // Iterar sobre los datos POST y agregarlos al nuevo array
        // foreach ($_POST as $key => $value) {
        //     $form_data[$key] = $value;
        // }
        // print_r ($form_data);
        // Generar dos arrays y pasarlos al modelo
    }
}