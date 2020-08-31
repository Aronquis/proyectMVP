<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    /*
    $mng = new MongoDB\Driver\Manager("mongodb://localhost:27017");
    $listdatabases = new MongoDB\Driver\Command(["listDatabases" => 1]);
    $res = $mng->executeCommand("admin", $listdatabases);
    $query = new MongoDB\Driver\Query([]); 
    $rows = $mng->executeQuery("db_productores.productores", $query);
    foreach($rows as $row){
        dd($row);
    }*/
    return view('preguntas.index');
});
Route::get('/pregunta', function (Request $request){
    $pregunta=$request->get('pregunta');
    $input=$request->get('input');
    $tipo_db=$request->get('base_datos');
    //////////
    $mng = new MongoDB\Driver\Manager("mongodb://localhost:27017");
    $listdatabases = new MongoDB\Driver\Command(["listDatabases" => 1]);
    $res = $mng->executeCommand("admin", $listdatabases);
    $query = new MongoDB\Driver\Query([]); 
    $rows = $mng->executeQuery("db_productores.productores", $query);
    ////////////////////conect MYSQL ///////////
    define('DB_SERVER', 'localhost');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', '');
    define('DB_NAME', 'db_productores');
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
    /////////////////////////////
    if($tipo_db==1){
        return view('preguntas.preguntas', \compact('rows','pregunta','input','tipo_db'));
    }
    else{
        $result = $link->query($sql);
        return view('preguntas.preguntas', \compact('result','pregunta','input','tipo_db'));
    }
    
});