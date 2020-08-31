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
                    <form class="form-horizontal"  method="get" action="/pregunta" autocomplete="false" accept-charset="UTF-8" enctype="multipart/form-data">
                        <fieldset>
                            <legend class="text-center header">Preguntas</legend>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <select class="form-control" id="pregunta" name="pregunta">
                                        <option value="1">Pregunta1</option>
                                        <option value="2">Pregunta2</option>
                                        <option value="3">Pregunta3</option>
                                        <option value="4">Pregunta4</option>
                                        <option value="5">Pregunta5</option>
                                        <option value="6">Pregunta6</option>
                                        <option value="7">Pregunta7</option>
                                        <option value="8">Pregunta8</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <select class="form-control" id="base_datos" name="base_datos">
                                        <option value="1">NoSql</option>
                                        <option value="2">SQL</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <input class="form-control" id="input" name="input">
                                </div>
                            </div>
                            

                            <div class="form-group">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary btn-lg">Consultar</button>
                                </div>
                            </div>
                            
                        </fieldset>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</body>