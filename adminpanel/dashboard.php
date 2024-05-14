<?php

 require_once 'config.php';

 if (!isset($_SESSION['adminId'])) { 
    header("Location: index.php");
    exit();
 }

if (isset($_SESSION['message'])) { 
    echo $_SESSION['message'];
    unset($_SESSION['message']);
}


 $member_id;
?>

 <html lang="en">
    <head>
        <style>
                .form-select {
                    width: 100%; 
                    height: calc(2.25rem + 2px); 
                    font-size: 1rem !important;     
                    line-height: 1.5;   
                }


                .kontejner {
                    position : absolute;
                    top : 15vh;
                    left: 75vh;
                    width: 100%;
                    max-width: 400px;
                    text-align: center;
                    display : none;
                    font-family: Arial, sans-serif;
                    justify-content: center;
                    align-items: center;
                    height: 100vh;
                    margin: 0;
                    filter: blur(0px);
                }

                .menu {
                    background-color: #ffffff;
                    box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.1);
                    border-radius: 10px;
                    padding: 20px;
                }

                .toggle {
                    display: flex;
                    align-items: center;
                    margin-bottom: 20px;
                }

                .switch {
                    position: relative;
                    display: inline-block;
                    width: 60px;
                    height: 30px;
                }

                .switch input {
                    opacity: 0;
                    width: 0;
                    height: 0;
                }

                .slider {
                    position: absolute;
                    cursor: pointer;
                    top: 0;
                    left: 0;
                    right: 0;
                    bottom: 0;
                    background-color: #d63c0c;
                    -webkit-transition: .4s;
                    transition: .4s;
                    border-radius: 30px;
                }

                .slider:before {
                    position: absolute;
                    content: "";
                    height: 22px;
                    width: 22px;
                    left: 4px;
                    bottom: 4px;
                    background-color: white;
                    -webkit-transition: .4s;
                    transition: .4s;
                    border-radius: 50%;
                }

                input:checked + .slider {
                    background-color: #4CAF50;
                }

                input:checked + .slider:before {
                    -webkit-transform: translateX(26px);
                    -ms-transform: translateX(26px);
                    transform: translateX(26px);
                }

                .label-text {
                    margin-left: 10px;
                    font-size: 16px;
                }

                .color-picker {
                    margin-top: 20px;
                }

                .color-picker input {
                    width: 100%;
                    height: 40px;
                    border: none;
                    border-radius: 5px;
                }


        </style>

        <title>Admin Dashboard</title>
        <meta charset="utf-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no"
        />

        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
            crossorigin="anonymous"
        />
    </head>
 
    <body>

    <div class = "dashboardfull" style = "filter: blur(0px);">
        <form action="create_member.php" method="post">
                <div class="container" style = "position : relative; left : 12vh;">
                    <form>
                        <div class="mb-3 row">
                            <div
                                class="col-8"
                            >
                            <br>
            
                                 <h4 class="card-title" style = "text-align : center;">Kreiraj Korisnika</h4> <br>
            
                            
                                <input
                                    type="text"
                                    class="form-control"
                                    name="first_name"
                                    id="inputName"
                                    placeholder="Ime"
                                />
                                 <br>
                                <input
                                    type="text"
                                    class="form-control"
                                    name="last_name"
                                    id="inputName"
                                    placeholder="Prezime"
                                />
                                <br>
                                <input
                                    type="text"
                                    class="form-control"
                                    name="phone_number"
                                    id="inputName"
                                    placeholder="Broj Telefona"
                                />
                                <br>
                                <input
                                    type="text"
                                    class="form-control"
                                    name="email"
                                    id="inputName"
                                    placeholder="E-mail"
                                />
                                <br>

                                    <select
                                        class="form-select form-select-lg"
                                        name="plan_id"
                                        id=""
                                    >
        
                                    <?php
                                        $sql = "SELECT * FROM training_plans";
                                        $run = $conn->query($sql);
                                        $results = $run->fetch_all(MYSQLI_ASSOC);

                                        foreach($results as $rezultat) { 
                                            echo "<option value=" . $rezultat['plan_id'] . '>' . $rezultat['name'] . '</option>';
                                        }

                                    ?>
                                    </select>
        


                            </div>
                        </div>
                        <div class="mb-3 row" style = "position : relative; right : 8vh;">
                            <div class="offset-sm-4 col-sm-8">
                                <button type="submit" class="btn btn-primary">
                                    Kreiraj Korisnika
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                



        </form>
                                             
             <h4 class="card-title" style ="position : relative; text-align : center; right : 10vh;">Korisnici</h4> <Br>

             <form method="POST" id="forma">
                 <input type="text" class="form-control" name="pretrazivac" id="pretraga" placeholder="Pretraži Korisnika po Prezimenu" value="<?php if(isset($_POST['pretrazivac'])) { echo htmlspecialchars($_POST['pretrazivac']); } ?>">
            </form>


              <div
                class="table-responsive"
              >
                <table
                    class="table table-primary"
                >
                    <thead>
                        <tr>
                            <th scope="col">Ime</th>
                            <th scope="col">Prezime</th>
                            <th scope="col">E-mail</th>
                            <th scope ='col'>Broj Telefona</th>
                            <th scope ='col'>Broj Ulaza</th>
                            <th scope = "col">Akcija</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php

                                if ($_SERVER["REQUEST_METHOD"] == "POST") { 
                                    if ($_POST['pretrazivac'] != '') { 
                                        $sql = "SELECT * FROM members";
                                        $run = $conn->query($sql);
                                        $results = $run->fetch_all(MYSQLI_ASSOC);

                                        foreach($results as $rezultat) { 

                                            if (strpos($_POST['pretrazivac'], $rezultat['last_name']) !== false) {     
                                                echo '<tr class = "">';
                                                echo "<td>" . $rezultat['first_name'] . "</td>";
                                                echo "<td>" . $rezultat['last_name'] . "</td>";
                                                echo "<td>" . $rezultat['email'] . "</td>";
                                                echo "<td>" . $rezultat['phone_number'] . "</td>";
                                                echo "<td>" . $rezultat['sessions'] . "</td>";

                                                
                                                echo '<td> <div class="mb-3 row" style = "position : relative; right : 10vh;">
                                                <div class="offset-sm-4 col-sm-8">
                                                    <button name = ' . $rezultat['member_id'] . ' onClick = "OtvoriAkcije( ' . $rezultat['member_id'] . ')" type="submit" class="btn btn-primary">
                                                        Akcija
                                                    </button>
                                                </div>
                                                </div> </td>';
                                                echo "</tr>";
                                            }
                                        }
                                    
                                }else { 
                                        $sql = "SELECT * FROM members";
                                        $run = $conn->query($sql);
                                        $results = $run->fetch_all(MYSQLI_ASSOC);
    
                                        foreach($results as $rezultat) { 
                                            echo '<tr class = "">';
                                            echo "<td>" . $rezultat['first_name'] . "</td>";
                                            echo "<td>" . $rezultat['last_name'] . "</td>";
                                            echo "<td>" . $rezultat['email'] . "</td>";
                                            echo "<td>" . $rezultat['phone_number'] . "</td>";
                                            echo "<td>" . $rezultat['sessions'] . "</td>";
        
                                            
                                            echo '<td> <div class="mb-3 row" style = "position : relative; right : 10vh;">
                                            <div class="offset-sm-4 col-sm-8">
                                                <button name = ' . $rezultat['member_id'] . ' onClick = "OtvoriAkcije( ' . $rezultat['member_id'] . ')" type="submit" class="btn btn-primary">
                                                    Akcija
                                                </button>
                                            </div>
                                            </div> </td>';
                                            echo "</tr>";
                                        }
                                    }
                            
                                }else {

                                    $sql = "SELECT * FROM members";
                                    $run = $conn->query($sql);
                                    $results = $run->fetch_all(MYSQLI_ASSOC);

                                    foreach($results as $rezultat) { 
                                    echo '<tr class = "">';
                                    echo "<td>" . $rezultat['first_name'] . "</td>";
                                    echo "<td>" . $rezultat['last_name'] . "</td>";
                                    echo "<td>" . $rezultat['email'] . "</td>";
                                    echo "<td>" . $rezultat['phone_number'] . "</td>";
                                    echo "<td>" . $rezultat['sessions'] . "</td>";

                                    
                                    echo '<td> <div class="mb-3 row" style = "position : relative; right : 10vh;">
                                    <div class="offset-sm-4 col-sm-8">
                                        <button name = ' . $rezultat['member_id'] . ' onClick = "OtvoriAkcije( ' . $rezultat['member_id'] . ')" type="submit" class="btn btn-primary">
                                            Akcija
                                        </button>
                                    </div>
                                    </div> </td>';
                                    echo "</tr>";
                                    }
                                }
                            ?>
                    </tbody>
                </table>
              </div>
        
             </div>



             <form action="update_member.php" method="post">
 
              <div class = "kontejner">
                <div class="menu">
                    <h4 class="card-title">Akcije Korisnika</h4>
                    <br>
                    
                    <h1-6>Dodeli clanarinu</h1-6>
                    
                    <br>

                    <select class="form-select form-select-lg" name="plan_id" id="">
                                
                    <?php
                        $sql = "SELECT * FROM training_plans";
                        $run = $conn->query($sql);
                        $results = $run->fetch_all(MYSQLI_ASSOC);
                        foreach($results as $rezultat) { 
                            echo "<option value=" . $rezultat['plan_id'] . '>' . $rezultat['name'] . '</option>';
                        }
                    ?>

                    </select>
                    <br>

                    <h1-6>Zameni Email</h1-6>

                    <input
                        type="text"
                        class="form-control"
                        name="email"
                        id="inputName"
                        placeholder="E-mail"
                    />
                    <br>
 
                    <br>
                    <h1-6>Zameni Broj Telefona</h1-6>
                    <input
                        type="text"
                        class="form-control"
                        name="phone_number"
                        id="inputName"
                        placeholder="Broj Telefona"
                    />
                    <br>
                    <h1-6>Obrisi Korisnika</h1-6>
                    <br>
                    <input
                        name="brisanje"
                        id=""
                        class="btn btn-primary"
                        type="submit"
                        value="Obrisi"
                        style = "background-color: red; border-color : red;"
                    />
                    <div class = "member_id"></div>
                    
                    <br><br>
                    

                    <input
                        name="cuvanje"
                        id=""
                        class="btn btn-primary"
                        type="submit"
                        value="Sacuvaj"
                    />
                    <input
                        name="odustao"
                        id=""
                        class="btn btn-primary"
                        type="submit"
                        value="Odustani"
                    />

                </div>      
            </form> 
        
        <script >
            OtvoriAkcije = function(arg) { 
                var body = document.querySelector(".dashboardfull");
                body.style.filter = "blur(5px)";
                var actions = document.querySelector(".kontejner");
                actions.style.display = "block";

                var push = document.querySelector(".member_id");
                push.innerHTML = '<input  name = "member_id" value = ' + parseInt(arg) + ' id = "nevidljivi" style = "display:none;"/>';
            }

            var timer;
            function doneTyping() {
                document.getElementById("forma").submit();
            }
            document.getElementById("pretraga").addEventListener("keyup", function() {
                clearTimeout(timer);
                timer = setTimeout(doneTyping, 500);
            });
        </script>


    

        <script
            src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
            integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
            crossorigin="anonymous"
        ></script>
 
        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
            integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
            crossorigin="anonymous"
        ></script>
    </body>
 </html>
 
