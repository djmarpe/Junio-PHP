<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="../css/all.min.css">
        <link rel="stylesheet" type="text/css" href="../css/miCss.css">
        <script src="../js/miJS.js"></script>
        <title>Seleccionar preferencias</title>
    </head>
    <body class="background-dark-blue">
        <div class="row m-3 d-flex justify-content-center">
            <div class=" col-12 col-md-8 bg-white">
                <form action="../controladores/controlador.php" method="POST">
                    <div class="row m-0 p-0 d-flex justify-content-between">
                        <h2 class="col-12 my-2 text-center">Seleccionar preferencias</h2>
                        <div class="my-3 col-12 col-md-5 text-center">
                            <small class="d-block">-> ¿Relación seria? <-</small>
                            <input id="rel_si" type="radio" name="preferencia_relacionSeria" value="si" selected>
                            <label for="rel_si">Si</label>
                            <input id="rel_no" type="radio" name="preferencia_relacionSeria" value=""no>
                            <label for="rel_no">No</label>
                        </div>
                        <div class="my-3 col-12 col-md-5 text-center">
                            <small class="d-block">-> Fanatismo por el deporte <-</small>
                            <input id="deporte_hidden" type="hidden" name="preferencia_deporte" value="5">
                            <small id="deporte_value" name="preferencia_deporte">5</small>
                            <input id="range_deporte" type="range" min="0" max="10" step="1" onchange="rangeDeporte()">
                        </div>
                        <div class="my-3 col-12 col-md-5 text-center">
                            <small class="d-block">-> Fanatismo por el arte <-</small>
                            <input id="arte_hidden" type="hidden" name="preferencia_arte" value="5">
                            <small id="arte_value" name="preferencia_arte">5</small>
                            <input id="range_arte" type="range" min="0" max="10" step="1" onchange="rangeArte()">
                        </div>
                        <div class="my-3 col-12 col-md-5 text-center">
                            <small class="d-block">-> Intereses políticos <-</small>
                            <input id="politica_hidden" type="hidden" name="preferencia_politica" value="5">
                            <small id="politica_value" name="preferencia_politica">5</small>
                            <input id="range_politica" type="range" min="0" max="10" step="1" onchange="rangePolitica()">
                        </div>
                        <div class="my-3 col-12 col-md-5 text-center">
                            <small class="d-block">-> ¿Quieres tener hijos? <-</small>
                            <input id="hijos_si" type="radio" value="si" name="preferencia_hijos">
                            <label for="hijos_si">Si</label>
                            <input id="hijos_no" type="radio" value="no" name="preferencia_hijos">
                            <label for="hijos_no">No</label>
                        </div>
                        <div class="my-3 col-12 col-md-5 text-center">
                            <small class="d-block">-> Interes en... <-</small>
                            <select name="preferencia_interes">
                                <option selected>Hombres</option>
                                <option>Mujeres</option>
                                <option>Ambos</option>
                            </select>
                        </div>
                        <div class="col-12 text-center">
                            <a href="../controladores/controlador.php?cerrarSesion=cerrarSesion" class="btn btn-outline-primary w-25 mx-2">Página principal</a>
                            <input type="submit" name="btn_completarLogin" value="Terminar" class="btn btn-primary w-25 mx-2">
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <script src="../js/all.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
    </body>
</html>
