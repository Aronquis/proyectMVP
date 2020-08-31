<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class CuestionarioController extends Controller
{
    //
    private $server;
    private $username;
    private $password;
    private $db_name;
    public function __construct() {
        $this->server = 'localhost';
        $this->username = 'root';
        $this->password = '';
        $this->db_name = 'db_productores';
    }
    public function Pregunta(Request $request){
        $pregunta=$request->get('pregunta');
        $input=$request->get('input');
        define('DB_SERVER', $this->server);
        define('DB_USERNAME', $this->username);
        define('DB_PASSWORD', $this->password);
        define('DB_NAME', $this->db_name);
        $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
        $sql="";
        switch ($pregunta) {
            case 1:
                $sql = "SELECT productores.* FROM productores INNER JOIN produccion ON produccion.productores_idProductor=productores.idProductor WHERE produccion.cantidadBotellas>".$input;
                break;
            case 2:
                $sql = "SELECT vinos.* FROM vinos INNER JOIN produccion ON produccion.vinos_idVino=vinos.idVino INNER JOIN productores ON produccion.productores_idProductor=productores.idProductor WHERE productores.idProductor=".$input;
                break;
            case 3:
                $sql = "SELECT productores.*,produccion.vinos_idVino FROM productores LEFT JOIN produccion ON produccion.productores_idProductor=productores.idProductor";
                break;
            case 4:
                $sql = "SELECT MAX(produccion.cantidadBotellas),vinos.* FROM vinos INNER JOIN produccion ON produccion.vinos_idVino=vinos.idVino ";
                break;
            case 5:
                $sql = "SELECT COUNT(produccion.vinos_idVino) AS total,productores.idProductor,productores.apellido,productores.nombre,productores.region FROM productores LEFT JOIN produccion ON produccion.productores_idProductor=productores.idProductor GROUP BY productores.idProductor HAVING total>=".$input;
                break;
            case 6:
                $sql = "SELECT SUM(produccion.cantidadBotellas) AS total,productores.idProductor,productores.apellido,productores.nombre,productores.region FROM productores INNER JOIN produccion ON produccion.productores_idProductor=productores.idProductor GROUP BY productores.idProductor HAVING total>".$input;
                break;
            case 7:
                $sql_aux="SELECT COUNT(produccion.vinos_idVino) AS total,productores.idProductor,productores.apellido,productores.nombre,productores.region FROM productores LEFT JOIN produccion ON produccion.productores_idProductor=productores.idProductor GROUP BY productores.idProductor HAVING productores.idProductor=".$input;
                $result_aux = $link->query($sql_aux);
                $total=0;
                while($row = $result_aux->fetch_assoc()){
                    $total=$row['total'];
                }
                $sql="SELECT COUNT(produccion.vinos_idVino) AS total,productores.idProductor,productores.apellido,productores.nombre,productores.region FROM productores LEFT JOIN produccion ON produccion.productores_idProductor=productores.idProductor GROUP BY productores.idProductor HAVING total>=".$total;
                break;
            case 8:
                $sql = "SELECT SUM(produccion.vinos_idVino) AS total,productores.idProductor,productores.apellido,productores.nombre,productores.region FROM productores LEFT JOIN produccion ON produccion.productores_idProductor=productores.idProductor GROUP BY productores.idProductor";
                break;
        }
        //////
        $result = $link->query($sql);
        return view('preguntas.preguntas', \compact('result','pregunta','input'));
    }
    
}
