<?php

class RouteController{

    private string $method="";
    private int $params=0;
    private array $routeArray=[];
    private string $resource="";
    private array $paramsArray;
    private string $select="";
    private string $where=""; //funciones curl_scape y curl_unscape
    private string $by=""; // order By
    private string $limit=""; // limit="start,end"
    private string $join=""; //


	

    public function start() {
        wLog("START","-----");
        //Cláusula de guarda. Se utilizan para evitar los errores más generales.
        if($_SERVER['REQUEST_URI']=="" && isset ($_SERVER['REQUEST_METHOD'])){
            $this->not_found_response();
            return;
        }
        $this->read_request();
        wLog("METHOD",$this->method);
		//include "routes/routes.php";
        if($this->method == "GET"){
            
            //$this->custom_response(200,"GET");
            include "get.controller.php";
            GetController::getData($this->resource , $this->select , $this->where, $this->by , $this->limit , $this->join);

        }
        if ($this->method == "POST"){
            //$this->custom_response(200,"POST");
            if($this->method == "POST"){
                include "post.controller.php";
                PostController::putData($this->resource);
                //$this->custom_response(200,"POST");
                /* include "post.controller.php";
                PostController::createData($this->resource, $this->data); */
            }
        } 
        if ($this->method== "PUT"){
            include "put.controller.php";
            PutController::putData($this->resource);
            //$this->custom_response(200,"PUT");
            /* if($this->method == "PUT"){
                //$this->custom_response(200,"PUT");
                include "update.controller.php";
                UpdateController::updateData($this->resource, $this->data, $this->where);
            } */
        }
        if ($this->method == "DELETE"){
            $this->custom_response(200,"DELETE");
           /*  if($this->method == "DELETE"){
                //$this->custom_response(200,"DELETE");
                include "delete.controller.php";
                DeleteController::deleteData($this->resource, $this->where);
            } */
        }
        wLog("END","-----");
    }




    private function read_request(){
        $this->routeArray = array_filter(explode("/", $_SERVER['REQUEST_URI']));
        $this->params = count($this->routeArray);
        $this->method = $_SERVER['REQUEST_METHOD'];
        //puede llevar parámetros dentro del resource. se separan por el signo ?
        $this->resource = explode('?' , $this->routeArray[RESOURCE])[0];        
        $this->select = $_GET['SELECT'] ?? "*" ;
        $this->where = $_GET['WHERE'] ?? "";
        $this->by = $_GET['BY'] ?? "";
        $this->limit = $_GET['LIMIT'] ?? "";
        $this->join = $_GET['JOIN'] ?? "";

        
        //$curl = curl_init(); //necesario para enciar peticiones correctamente como parámetro
        //echo curl_escape($curl,"pepe=15");
        //echo " --- $this->where   --- "; //la url devuelve el valor correctamente!!!
    }



    private function not_found_response()
    {
        $this->custom_response(404,"Not found");
    }

    private function ok_response(){
        $this->custom_response(200,"Ok");
    }

    private function custom_response( int $status , string $result){
        $json = [
            'status' => $status,
            'result' => $result
        ];
        echo json_encode($json , http_response_code($json["status"]));
    }

}