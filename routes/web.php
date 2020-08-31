<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Vino;
use App\Productor;
use App\Produccion;
use Illuminate\Support\Facades\DB;
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
    //////////Coneccion a Mongo DB
    $mng = new MongoDB\Driver\Manager("mongodb://localhost:27017");
    $listdatabases = new MongoDB\Driver\Command(["listDatabases" => 1]);
    $res = $mng->executeCommand("admin", $listdatabases);
    $query = new MongoDB\Driver\Query([]); 
    $rows = $mng->executeQuery("db_productores.productores", $query);
    /////////
    $sql=NULL;
    switch ($pregunta) {
        case 1:
            $sql=Productor::join('produccions','produccions.productores_idProductor','=','productors.idProductor')->where('produccions.cantidadBotellas','>',@$input)->get();
            break;
        case 2:
            $sql=Vino::join('produccions','produccions.vinos_idVino','=','vinos.idVino')->join('productors','productors.idProductor','=','produccions.productores_idProductor')->where('productors.idProductor','>',@$input)->get();
            break;
        case 3:
            $sql=Productor::leftjoin('produccions','produccions.productores_idProductor','=','productors.idProductor')->select('productors.*','produccions.vinos_idVino')->get();
            break;
        case 4:
            $sql=Produccion::join('vinos','vinos.idVino','=','produccions.vinos_idVino')
                ->select('vinos.idVino','vinos.nombre','vinos.grado','vinos.año')
                ->where('produccions.cantidadBotellas', \DB::raw("(select max(`cantidadBotellas`) from produccions)"))
                ->groupBy('vinos.idVino')
                ->groupBy('vinos.nombre')
                ->groupBy('vinos.grado')
                ->groupBy('vinos.año')
                ->get();
            break;
        case 5:
            $sql=Productor::leftjoin('produccions','produccions.productores_idProductor','=','productors.idProductor')
                        ->select('productors.idProductor','productors.apellido','productors.nombre','productors.region',\DB::raw("COUNT(produccions.vinos_idVino) as total"))
                        ->groupBy('productors.idProductor')
                        ->groupBy('productors.apellido')
                        ->groupBy('productors.nombre')
                        ->groupBy('productors.region')
                        ->get();
            break;
        case 6:
            $sql=Productor::join('produccions','produccions.productores_idProductor','=','productors.idProductor')
                        ->select('productors.idProductor','productors.apellido','productors.nombre','productors.region',\DB::raw("SUM(produccions.cantidadBotellas) as total"))
                        ->groupBy('productors.idProductor')
                        ->groupBy('productors.apellido')
                        ->groupBy('productors.nombre')
                        ->groupBy('productors.region')
                        ->having('total','>',$input)
                        ->get();
            break;
        case 7:
            $sql_aux=Productor::leftjoin('produccions','produccions.productores_idProductor','=','productors.idProductor')
                    ->select('productors.idProductor','productors.apellido','productors.nombre','productors.region',\DB::raw("COUNT(produccions.vinos_idVino) as total"))
                    ->groupBy('productors.idProductor')
                    ->groupBy('productors.apellido')
                    ->groupBy('productors.nombre')
                    ->groupBy('productors.region')
                    ->where('productors.idProductor',$input)
                    ->get();
            $total=0;
            foreach($sql_aux as $resu){
                $total=$resu->total;
            }
            $sql=Productor::leftjoin('produccions','produccions.productores_idProductor','=','productors.idProductor')
                    ->select('productors.idProductor','productors.apellido','productors.nombre','productors.region',\DB::raw("COUNT(produccions.vinos_idVino) as total"))
                    ->groupBy('productors.idProductor')
                    ->groupBy('productors.apellido')
                    ->groupBy('productors.nombre')
                    ->groupBy('productors.region')
                    ->having('total','>=',$total)
                    ->get();
            break;
        case 8:
            $sql=Productor::leftjoin('produccions','produccions.productores_idProductor','=','productors.idProductor')
                    ->select('productors.idProductor','productors.apellido','productors.nombre','productors.region',\DB::raw("SUM(produccions.vinos_idVino) as total"))
                    ->groupBy('productors.idProductor')
                    ->groupBy('productors.apellido')
                    ->groupBy('productors.nombre')
                    ->groupBy('productors.region')
                    ->get();
            break;
    }
    /////////////////////////////
    if($tipo_db==1){
        return view('preguntas.preguntas', \compact('rows','pregunta','input','tipo_db'));
    }
    else{
        return view('preguntas.preguntas', \compact('sql','pregunta','input','tipo_db'));
    }
    
});