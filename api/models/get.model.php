<?php
require_once "./models/connection.php";
require_once "./util/plural.php";
//echo " hola model ";
class GetModel
{


    static public function getData($tables, $select, $where = "", $by = "", $limit = "", $join = "")
    {
        // line("model");
        // line("tables: " . $tables);
        // line("select: " . $select);
        // line("where: " . $where);
        // line("by: " . $by);
        // line("limit: " . $limit);
        // line("join: " . $join);
        // line("=======================================================query");
        // //======================================================query
        $query = "SELECT $select FROM $tables ";
        $wherePrepared = GetModel::whereStringGenerate($where);
        // line($wherePrepared["string"]);
        //var_dump($wherePrepared["values"]);
        // line(" JOIN: " . $join);
        if ($join != "") {
            $query .= self::generate_joins($join);
        }
        if ($where != "") {
            $query .= " WHERE " . $wherePrepared["string"];
        }
        if ($by != "") {
            $query .= " ORDER BY " . $by;
        }
        if ($limit != "") {
            $query .= " LIMIT " . $limit;
        }
        $query .= ";";
        // line("La query es -->: " . $query);
        //======================================================final de la query
        $stmt = Connection::connect()->prepare($query);
        //tambien se puede hacer con bind param.
        //$stmt->execute(['value'=>$where[1]]);
        $stmt->execute($wherePrepared['values']);
        $resultado = $stmt->fetchAll(PDO::FETCH_CLASS);

        // Devolver la respuesta en formato JSON
        header('Content-Type: application/json');
        echo json_encode($resultado);
    }

    static public function gettables()
    {
        $stmt = Connection::connect()->query("SHOW tables");
        return $stmt->fetchAll(PDO::FETCH_COLUMN); //array con los resultados
    }
    static public function getFields($tables)
    {
        $stmt = Connection::connect()->query("DESCRIBE $tables");
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    static public function whereStringGenerate($where)
    {
        line("La linea es:" . $where);
        $array_where = explode(" ", $where);
        $string = "";
        $values = array();
        $symbols = ['LIKE', '<>', '<=', '>=', '=', '>', '<'];
        $count = count($array_where) - 1;

        for ($i = 1; $i < $count; $i++) {
            if (in_array($array_where[$i], $symbols)) {
                $string .= $array_where[$i - 1] . " " . $array_where[$i] . " ? ";
                $values[] = $array_where[$i + 1];
                continue;
            }
            if ($array_where[$i] == "OR") {
                $string .= " OR ";
                continue;
            }
            if ($array_where[$i] == "AND") {
                $string .= " AND ";
                continue;
            }
        }

        $string .= " ";



        return ['string' => $string, 'values' => $values];
    }

    static public function generate_joins($join)
    {
        line("estamos en el join");
        $result = "";
        $array_join = explode(" , ", $join);
        line("el array tiene: " . count($array_join) . " elementos");

        foreach ($array_join as $tables) {
            $fields = explode("_", $tables);
            if (count($fields) != 3) {
                return false;
            }
            $result .= " INNER JOIN ";
            $result .= plural::toPlural($fields[1]);
            $result .= " ON ";
            $result .= plural::toPlural($fields[2]) . ".id_" . $fields[1] . "_" . $fields[2];
            $result .= " = ";
            $result .= plural::toPlural($fields[1]) . ".id_" . $fields[1];
            $result .= " ";
        }
        //line("RESULT: $result");
        return $result;
    }
}
