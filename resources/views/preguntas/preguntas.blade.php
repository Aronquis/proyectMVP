<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  </head>
<style>
.header {
    color: #36A0FF;
    font-size: 27px;
    padding: 10px;
}

.bigicon {
    font-size: 35px;
    color: #36A0FF;
}
</style>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="well well-sm">
                    <form class="form-horizontal" method="post">
                        <fieldset>
                            <legend class="text-center header">Preguntas</legend>
                            <div class="form-group">
                                <div class="col-md-12">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        @if($pregunta==1 || $pregunta==3 || $pregunta==6 || $pregunta==8 || $pregunta==5 || $pregunta==7)
                                        <th>Nombre</th>
                                        <th>Apellido</th>
                                        <th>Region</th>
                                        <th>total</th>
                                        @endif
                                        @if($pregunta==2 || $pregunta==4)
                                        <th>idVino</th>
                                        <th>Nombre</th>
                                        <th>Grado</th>
                                        <th>año</th>
                                        
                                        @endif
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if($tipo_db==2)
                                        @foreach($sql as $result)
                                        <tr>
                                            @if($pregunta==1 || $pregunta==6 || $pregunta==5)
                                            <td><?php print_r($result->nombre); ?></td>
                                            <td><?php print_r($result->apellido); ?></td>
                                            <td><?php print_r($result->region); ?></td>
                                            <td><?php print_r(@$result->total); ?></td>
                                            @endif
                                            @if($pregunta==2 || $pregunta==4)
                                            <td><?php print_r($result->idVino); ?></td>
                                            <td><?php print_r($result->nombre); ?></td>
                                            <td><?php print_r($result->grado); ?></td>
                                            <td><?php print_r($result->año); ?></td>
                                            @endif
                                            @if($pregunta==3)
                                                @if($result->vinos_idVino==null)
                                                <td><?php print_r($result->nombre); ?></td>
                                                <td><?php print_r($result->apellido); ?></td>
                                                <td><?php print_r($result->region); ?></td>
                                                <?php ?>
                                                @endif
                                            @endif
                                            @if($pregunta==7)
                                                @if($result->idProductor!=$input)
                                                    <td><?php print_r($result->nombre); ?></td>
                                                    <td><?php print_r($result->apellido); ?></td>
                                                    <td><?php print_r($result->region); ?></td>
                                                    <td><?php print_r($result->total); ?></td>
                                                @endif
                                            @endif

                                            @if($pregunta==8)
                                                @if(@$result->total==NULL && $result->nombre=="")
                                                    <td><?php print_r($result->nombre); ?></td>
                                                    <td><?php print_r($result->apellido); ?></td>
                                                    <td><?php print_r($result->region); ?></td>
                                                    <td><?php print_r(0); ?></td>
                                                @endif
                                            @endif
                                        </tr>
                                        @endforeach
                                    @else
                                        <?php
                                            switch($pregunta){
                                                case 1:
                                                    foreach($rows as $row){
                                                        foreach($row->produccion as $produccion){
                                                           if($produccion->Cantidad>$input){
                                                                print_r('<tr>');
                                                                print_r('<td>'.@$row->nombre.'</td>');
                                                                print_r('<td>'.@$row->apellido.'</td>');
                                                                print_r('<td>'.@$row->region.'</td>');
                                                                print_r('<td>'.@$produccion->Cantidad.'</td>');
                                                                print_r('</tr>');        
                                                            break;
                                                            }
                                                        }
                                                    }
                                                break;
                                                case 2:
                                                    foreach($rows as $row){
                                                        if((Int)$row->idProductor==$input){
                                                            foreach($row->produccion as $produccion){
                                                                print_r('<tr>');
                                                                print_r('<td>'.@$produccion->vinos->idVino.'</td>');
                                                                print_r('<td>'.@$produccion->vinos->nombre.'</td>');
                                                                print_r('<td>'.@$produccion->vinos->grado.'</td>');
                                                                print_r('<td>'.@$produccion->vinos->año.'</td>');
                                                                print_r('</tr>'); 
                                                            }
                                                        }
                                                    }
                                                break;
                                                case 3:
                                                    foreach($rows as $row){
                                                        if(count(@$row->produccion)==0){
                                                                print_r('<tr>');
                                                                print_r('<td>'.@$row->nombre.'</td>');
                                                                print_r('<td>'.@$row->apellido.'</td>');
                                                                print_r('<td>'.@$row->region.'</td>');
                                                                print_r('<td>'.'</td>');
                                                                print_r('</tr>');
                                                        }
                                                    }
                                                break;
                                                case 4:
                                                    $cantidad=0;
                                                    $id_vino=0;
                                                    $nombre_vino="";
                                                    $grado_vino=0;
                                                    $año_vino="";

                                                    $i=0;
                                                    foreach($rows as $row){
                                                        foreach($row->produccion as $produccion){
                                                            if($i==0){
                                                                $cantidad=$produccion->Cantidad;
                                                                $id_vino=@$produccion->vinos->idVino;
                                                                $nombre_vino=@$produccion->vinos->nombre;
                                                                $grado_vino=@$produccion->vinos->grado;
                                                                $año_vino=@$produccion->vinos->año;
                                                            }
                                                            else{
                                                                if($produccion->Cantidad>$cantidad){
                                                                    $cantidad=$produccion->Cantidad;
                                                                    $id_vino=@$produccion->vinos->idVino;
                                                                    $nombre_vino=@$produccion->vinos->nombre;
                                                                    $grado_vino=@$produccion->vinos->grado;
                                                                    $año_vino=@$produccion->vinos->año;
                                                                }
                                                            }
                                                            $i+=1;
                                                        }
                                                    }
                                                    print_r('<tr>');
                                                    print_r('<td>'.$id_vino.'</td>');
                                                    print_r('<td>'.$nombre_vino.'</td>');
                                                    print_r('<td>'.$grado_vino.'</td>');
                                                    print_r('<td>'.$año_vino.'</td>');
                                                    print_r('<td>'.$cantidad.'</td>');
                                                    print_r('</tr>'); 
                                                break;
                                                case 5:
                                                    foreach($rows as $row){
                                                        $vinos=[];
                                                        foreach($row->produccion as $produccion){
                                                            array_push($vinos,$produccion->vinos->idVino);
                                                            $vinos = array_unique($vinos);
                                                        }
                                                        if(count($vinos)>=$input){
                                                            print_r('<tr>');
                                                            print_r('<td>'.@$row->nombre.'</td>');
                                                            print_r('<td>'.@$row->apellido.'</td>');
                                                            print_r('<td>'.@$row->region.'</td>');
                                                            print_r('<td>'.'</td>');
                                                            print_r('</tr>');

                                                        }
                                                    }

                                                break;
                                                case 6:
                                                    foreach($rows as $row){
                                                        $cont=0;
                                                        foreach($row->produccion as $produccion){
                                                            if($produccion->Cantidad>=$input){
                                                                $cont+=1;
                                                            }
                                                        }
                                                        if($cont>0){
                                                            print_r('<tr>');
                                                            print_r('<td>'.@$row->nombre.'</td>');
                                                            print_r('<td>'.@$row->apellido.'</td>');
                                                            print_r('<td>'.@$row->region.'</td>');
                                                            print_r('<td>'.$cont.'</td>');
                                                            print_r('</tr>');
                                                        }
                                                    }
                                                break;
                                                case 7:
                                                    $vinos=[];
                                                    foreach($rows as $row){
                                                        if($row->idProductor==$input){
                                                            foreach($row->produccion as $produccion){
                                                                array_push($vinos,$produccion->vinos->idVino);
                                                                $vinos = array_unique($vinos);
                                                            }
                                                        }
                                                        else{
                                                            $vinos_aux=[];
                                                            foreach($row->produccion as $produccion){
                                                                array_push($vinos_aux,$produccion->vinos->idVino);
                                                                $vinos_aux = array_unique($vinos_aux);
                                                            }
                                                            if(count(@array_intersect($vinos, $vinos_aux))>0){
                                                                print_r('<tr>');
                                                                print_r('<td>'.@$row->nombre.'</td>');
                                                                print_r('<td>'.@$row->apellido.'</td>');
                                                                print_r('<td>'.@$row->region.'</td>');
                                                                print_r('<td>'.'</td>');
                                                                print_r('</tr>');
                                                            }
                                                        }
                                                    }

                                                break;
                                                case 8:
                                                    foreach($rows as $row){
                                                        if($row->nombre=="" && count($row->produccion)==0){
                                                            print_r('<tr>');
                                                            print_r('<td>'.@$row->nombre.'</td>');
                                                            print_r('<td>'.@$row->apellido.'</td>');
                                                            print_r('<td>'.@$row->region.'</td>');
                                                            print_r('<td>'.'</td>');
                                                            print_r('</tr>');
                                                        }
                                                    }
                                                break;
                                            }  
                                        ?>
                                    
                                    @endif
                                    </tbody>
                                </table>
                                </div>
                                <div class="form-group">
                                  <div class="col-md-12">
                                    <button type="button" onclick="location.href='/'" class="btn btn-primary btn-lg">Atras</button>
                                  </div>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</body>