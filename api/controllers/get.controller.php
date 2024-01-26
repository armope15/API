<?php

use LDAP\Result;

wLog("INFO","get.controller");
require_once "./models/get.model.php";
require_once "./util/plural.php";
require_once "./util/log.php";
class GetController
{

    static private array $tables_array = [];
    static private array $fields_array = [];
    static private $tables="";
    static private $select="";
    static private $where="";
    static private $by="";
    static private $limit="";
    static private $join="";


    static public function getData($tables, $select = "", $where = "", $by = "", $limit = "", $join="")
    {
        if (GetController::validate($tables, $select, $where, $by, $limit , $join) == false) {
            return;
        }
        //line("JOIN ENVIADO:" . self::$join);
        $response = GetModel::getData(self::$tables, self::$select, self::$where, self::$by, self::$limit , self::$join);
        GetController::response($response);
    }
    static public function validate($tables, $select, $where = "", $by = "", $limit = "" , $join=""): bool
    {
        if (GetController::validateJoinTables($join) == false) {
            return false;
        }
        if (GetController::validateTables($tables) == false) {
            return false;
        }
        if (GetController::validateSelect($select) == false) {
            return false;
        };
         if (GetController::validateWhere($where) == false) {
            return false;
        };
        if (GetController::validateBy($by) == false) {
            return false;
        }
        if (GetController::validateLimit($limit) == false) {
            return false;
        };
        if (GetController::validateJoin($join) == false) {
            return false;
        }; 

        return true;
    }

    static private function validateJoinTables($joins){
        if($joins==""){
            return true;
        }
        $array_join = explode(",", $joins);
        foreach ($array_join as $joins) {
            $table=plural::toplural(explode("_", $joins)[1]);
            //line ("validate join table: " . $table);
            if (!in_array($table, GetModel::gettables())) {
                return false;
            }
            self::$tables_array[] = $table;
        }
        return true;
    }

    static public function validateTables($tables)
    {
        //line("validate tables");
        $tables_array = explode("_", $tables);
        foreach ($tables_array as $table) {
            if (!in_array($table, GetModel::gettables())) {
                return false;
            }
            self::$tables_array[]=$table;
        }
        //line("tables validadas");
        //self::$tables_array = $tables_array;

        foreach (self::$tables_array as $table) {
            $table_fields = GetModel::getFields($table);
            foreach ($table_fields as $field) {
                self::$fields_array[] = $field;
            }
        }
        self::$tables = str_replace("_" , " , " , $tables);
        //line("fields validados");
        return true;
    } 
    static public function validateSelect($selects)
    {
        if ($selects == "") {
            return true;
        }
        $array_select = explode(",", $selects);
        foreach ($array_select as $select) {
            if (!GetController::exists_field($select)) {
                return false;
            }
            //line("Validado select: $select");
        }
        self::$select=str_replace("," , " , " , $selects);
        return true;
    }  
    static public function validateWhere($where)
    {
        if ($where == "") {
            return true;
        }

        $AND = explode("AND", $where);
        foreach ($AND as $a) {
            $OR = explode("OR", $a);
            foreach ($OR as $o) {
                if (GetController::exists_field(GetController::separateFieldName($o)[0]) == false) {
                    return false;
                }
                //line("Validado el where ".$o);
            }
        }
        $where = str_replace("AND" , " AND " , $where);
        $where = str_replace("OR" , " OR " , $where);
        $where = str_replace("LIKE" , " LIKE " , $where);
        $where = str_replace("<" , " < " , $where);
        $where = str_replace(">" , " > " , $where);
        $where = str_replace("<>" , " <> " , $where);
        $where = str_replace("<=" , " <= " , $where);
        $where = str_replace(">=" , " >= " , $where);
        $where = str_replace("=" , " = " , $where);
        $where = str_replace("  " , "" , $where);  
        self::$where=$where;
        return true;
    }  
     static public function validateBy($by):bool
    {
        if ($by == "") {
            return true;
        }
        $fields = explode(",",$by);
        foreach ($fields as $field){
            $field = explode("ASC", $field)[0];
            $field = explode("DESC", $field)[0];
            if(!GetController::exists_field($field)){
                return false;
            }
            //line("validado by: " . $field );
        }
        $by = str_replace("ASC", " ASC ", $by);
        $by = str_replace("DESC", " DESC ", $by);
        self::$by=$by;
        return true;
    }
    static public function validateLimit($limit)
    {
        if ($limit == "") {
            return true;
        }
        $array = explode(",", $limit);
        if (count($array) == 1) {
            if (!is_numeric($array[0])) {
                return false;
            }
        }
        if (count($array) == 2) {
            if (!is_numeric($array[0]) && is_numeric($array[1])) {
                return false;
            }
        }
        self::$limit=$limit;
        //line("Se envio un limit: " . self::$limit);
        return true;
    }
    static public function validateJoin($joins)
    {
        //line("He recibido el join: " . $joins);
        if ($joins == "") {
            return true;
        }
        $array_join = explode(",", $joins);
        foreach ($array_join as $join) {
            if (!GetController::exists_field($join)) {
                return false;
            }
        }
        
        self::$join=str_replace(",", " , " , $joins);
        return true;
    }
      static public function separateFieldName($string)
    {
        //line("separate: $string");
        $array = [""];
        if (count($array) == 1) {
            $array = explode("LIKE", $string);
        } else {
            return $array;
        }
        if (count($array) == 1) {
            $array = explode("<=", $string);
        } else {
            return $array;
        }
        if (count($array) == 1) {
            $array = explode(">=", $string);
        } else {
            return $array;
        }
        if (count($array) == 1) {
            $array = explode("<", $string);
        } else {
            return $array;
        }
        if (count($array) == 1) {
            $array = explode(">", $string);
        } else {
            return $array;
        }
        if (count($array) == 1) {
            $array = explode("=", $string);
        } else {
            return $array;
        }
        if (count($array) == 1) {
            return "ERROR";
        } else {
            return $array;
        }
        return "ERROR";
    }
    static public function prepareWhere($where)
    {
        //line("Inicio prepare Where");
        $response = "";
        $values = [];
        foreach (explode("AND", $where) as $a) {
            if ($response != "") {
                $response .= " AND ";
            }
            $or = "";
            foreach (explode("OR", $a) as $o) {

                $replaceSymbol = function ($string) {
                    $symbols = ['LIKE', '<>', '<=', '>=', '=', '>', '<'];
                    foreach ($symbols as $s) {
                        $string2 = str_replace($s, " " . $s . " ", $string);
                        if ($string != $string2) {
                            return $string2;
                        }
                    }
                    return "ERROR SYMBOLO !!!";
                };
                $response .= $or . $replaceSymbol($o);
                $or = " OR ";
            }
        }
        line("RESPONSE: $response ");
        return $response;
    }
    static public function response($response)
    {
        //echo "HOLA PEPE";
        if (!empty($response)) {
            $json = [
                'status' => 200,
                'count' => count($response),
                'result' =>  $response
            ];
        } else {
            $json = [
                'status' => 404,
                'count' => 0,
                'result' =>  'Not found'
            ];
        }
        echo json_encode($json, http_response_code($json["status"]));
    }
    static private function exists_field($field)
    {
        if (in_array($field, self::$fields_array) == true) {
            return true;
        }
        return false;
    }   
}
