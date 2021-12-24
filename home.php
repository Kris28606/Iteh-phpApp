<?php

require "dbBroker.php";
require "model/predmet.php";
require "model/ocena.php";
require "model/user.php";

session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
} else {
    $prof=User::getById($_SESSION['user_id'],$conn)->fetch_array();
}

//con se vidi iz dbBroker
$podaci = Ocena::getAll($conn);
if (!$podaci) {
    echo "Nastala je greška pri preuzimanju podataka";
    die();
}
if ($podaci->num_rows == 0) {
    echo "Nema unetih ocena.";
    die();
} else {

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/home.css">
    <title>Pocetna</title>
</head>
<body>
    
<div class="jumbotron" style="color: white;">
        <h1><i>OS Heroj Radmila Siskovic</i></h1>
</div>

    <div class="row" style="background-color: rgba(255, 151, 53, 0.253);">
        <div class="col-md-4">
            <button id="btn-prikaz" class="btn btn-warning" style="background-color: rgb(255, 151, 53) ; border: 2px solid white; " data-toggle="modal" data-target="#myModal"> Unesi ocenu</button>
        </div>
        
        <div class="col-md-4">
            <button id="btn-pretraga" class="btn btn-warning" style="background-color:  rgb(255, 151, 53); border: 2px solid white;"> Pretrazi ocene </button>
            <input type="text" id="myInput" onkeyup="funkcijaZaPretragu()" placeholder="Pretrazi ocene po predmetu" hidden>
        </div>
    </div>
 

    <div id="pregled" class="panel panel-success" style="margin-top: 1%;">
    <div class="panel-body">
            <table id="myTable" class="table" style="color: black; text-align: center; font-size: large; ">
                <thead class="thead" style="border-bottom-style: solid; border-bottom-width: 1px;">
                    <tr>
                        <th>Predmet</th>
                        <th>Ucenik</th>
                        <th>Ocena</th>
                        <th>Profesor</th>
                        <th>Datum</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody class="tbody">
                <?php

                //sam query vraca mnogo podataka iz baze,vraca my sql objekat
                //fetch array je metoda sql objekta koja vraca red po red
                    while ($red = $podaci->fetch_array()) {
                        $predmet=Predmet::getById($red["predmetId"],$conn)->fetch_array();
                        $profesor=User::getById($red["profesorId"],$conn)->fetch_array();
                ?>
                        <tr>
                            <td data-id="id" data-target="predmet"><?php echo $predmet["naziv"] ?></td>
                            <td data-target="ucenik"><?php echo $red["ucenik"] ?></td>
                            <td data-target="ocena"><?php echo $red["ocena"] ?></td>
                            <td data-target="profesor"><?php echo $profesor["imePrezime"] ?></td>
                            <td data-target="datum"><?php echo $red["datum"] ?></td>
                            <td>
                            <button id="<?php echo $red["id"] ?>" class="btn btn-warning editBtn" data-toggle="modal" data-target="#izmeniModal">Izmeni</button>
                            <button id="<?php echo $red["id"] ?>" formmethod="post" name="obrisi" class="btn btn-danger deleteBtn" >Obrisi</button>
                            </td>

                        </tr>
                <?php
                    }
                } 
                ?>
                </tbody>
            </table>
            <div class="col" style="text-align: center;">
                    <button id="btn-sortiraj" class="btn" onclick="sortTable()">Sortiraj</button>
            </div>
        </div>
        
    </div>



    //----------------------MODAL DODAJ--------------------------
    <div  id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- zakazi modal -->
            <!--Sadrzaj modala-->
            <div class="modal-content" style="width: 565px;">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="container prijava-form">
                        <form action="#" method="post" id="izmeniForm">
                            <h2 style="color: black; text-align: center; width: 400px;">Unesi ocenu</h2>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="">Predmet</label>
                                            <select name="predmet" style="border: 1px solid black" class="form-control">
                                                <?php
                                                    $predmeti=Predmet::getAll($conn);
                                                    while($pred=$predmeti->fetch_array()) {
                                                ?>
                                                    <option><?php echo $pred["naziv"]; ?></option>
                                                <?php
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="">Ucenik</label>
                                            <input type="text" style="border: 1px solid black" name="ucenik" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="">Ocena</label>
                                            <input type="number" min="1" max="5" style="border: 1px solid black;" name="ocena" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="">Profesor</label>

                                            <input type="text" value="<?php echo $prof["imePrezime"]; ?>" style="border: 1px solid black;" name="profesor" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="">Datum</label>
                                            <input type="date" style="border: 1px solid black;" name="datum" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for=""></label>
                                            <input type="hidden" id="izmenaId" />
                                            <button id="btnDodaj" type="submit" class="btn btn-success btn-block" style="background-color: orange; border: 1px solid black; font-size: large;">Zakazi</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

    //----------------------MODAL IZMENI---------------------
    
    <div  id="izmeniModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- zakazi modal -->
            <!--Sadrzaj modala-->
            <div class="modal-content" style="width: 565px;">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="container prijava-form">
                        <form action="#" id="form_izmena" method="post" >
                            <h2 style="color: black; text-align: center; width: 400px;">Izmena ocene</h2>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="">Predmet</label>
                                            <select id="Predmet" name="predmet" style="border: 1px solid black" class="form-control">
                                                <?php
                                                    $predmeti=Predmet::getAll($conn);
                                                    while($pred=$predmeti->fetch_array()) {
                                                ?>
                                                    <option><?php echo $pred["naziv"]; ?></option>
                                                <?php
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="">Ucenik</label>
                                            <input type="text" id="Ucenik" style="border: 1px solid black" name="ucenik" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="">Ocena</label>
                                            <input type="number" id="Ocena" min="1" max="5" style="border: 1px solid black;" name="ocena" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="">Profesor</label>

                                            <input type="text" id="Profesor" value="<?php echo $prof["imePrezime"]; ?>" style="border: 1px solid black;" name="profesor" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="">Datum</label>
                                            <input type="date" id="Datum" style="border: 1px solid black;" name="datum" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for=""></label>
                                            <button id="btnIzmeni" name="action" type="submit" class="btn btn-success btn-block" style="background-color: orange; border: 1px solid black; font-size: large;">Izmeni</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
    

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="js/main.js"></script>

    <script type="text/javascript">

        $("#btnIzmeni").click(function() {
            event.preventDefault();
            var Id = +$('#izmenaId').val();
            $.ajax({
                url: 'handler/update.php',
                type:'post',
                data: $("#form_izmena").serialize()+'&action=update_ocena&id=' + Id});
                Swal.fire( {
                            title: 'Izmenjena!',
                            text: 'Ocena je uspešno izmenjena.',
                            confirmButtonColor: 'rgb(255, 142, 37)',
                            icon: 'success',
                            confirmButtonText: 'OK',
                }).then((result) => {
                    if (result.isConfirmed) {
                        location.reload(true);
                    }
                })
        });
                                  


        $("body").on("click",".editBtn", function(e) {
            
            var Id=+this.id;
            var predmet = $(this).closest('tr').children('td[data-target=predmet]').text();
            var ucenik = $(this).closest('tr').children('td[data-target=ucenik]').text();
            var ocena = $(this).closest('tr').children('td[data-target=ocena]').text();
            var profesor = $(this).closest('tr').children('td[data-target=profesor]').text();
            var datum = $(this).closest('tr').children('td[data-target=datum]').text();
            
            $('#Predmet').val(predmet);
            $('#Ucenik').val(ucenik);
            $('#Ocena').val(ocena);
            $('#Profesor').val(profesor);
            $('#Datum').val(datum);
            $('#izmenaId').val(Id);

        })
                                             
        
    
        $(".deleteBtn").click( function (e) {
            e.preventDefault();
                var element = e.target;
                del_id = +e.target.id;
                Swal.fire({
                    title: 'Da li ste sigurni?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: 'rgb(255, 142, 37)',
                    cancelButtonColor: 'rgb(255, 47, 75)',
                    confirmButtonText: 'Obriši',
                    cancelButtonText: 'Otkaži'
                }).then((result) => {
                    if (result.isConfirmed) {
                    $.ajax({
                        url: 'handler/delete.php',
                        method: 'post',
                        data: {
                        'id': del_id
                        },
                        success: function(response) {
                        Swal.fire( {

                            title: 'Obrisana!',
                            text: 'Ocena je uspešno obrisana.',
                            confirmButtonColor: 'rgb(255, 142, 37)',
                            icon: 'success',
                        })
                        element.closest('tr').remove();
                        }
                    });
                    }
                })
            });
    
            
            function sortTable() {
                    var table, rows, switching, i, x, y, shouldSwitch;
                    table = document.getElementById("myTable");
                    switching = true;

                    while (switching) {
                        switching = false;
                        rows = table.rows;
                        for (i = 1; i < (rows.length - 1); i++) {
                            shouldSwitch = false;
                            x = rows[i].getElementsByTagName("TD")[1];
                            y = rows[i + 1].getElementsByTagName("TD")[1];
                            if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                                shouldSwitch = true;
                                break;
                            }
                        }
                        if (shouldSwitch) {
                            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                            switching = true;
                        }
                    }
                }
 
                function funkcijaZaPretragu() {
                    var input, filter, table, tr, td, i, txtValue;
                    input = document.getElementById("myInput");
                    filter = input.value.toUpperCase();
                    table = document.getElementById("myTable");
                    tr = table.getElementsByTagName("tr");
                    for (i = 0; i < tr.length; i++) {
                        td = tr[i].getElementsByTagName("td")[0];
                        if (td) {
                            txtValue = td.textContent || td.innerText;
                            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                                tr[i].style.display = "";
                            } else {
                                tr[i].style.display = "none";
                            }
                        }
                    }
                }
    
    </script>
</body>
</html>