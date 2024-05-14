<?php

 require_once 'config.php';

 if ($_SERVER["REQUEST_METHOD"] == "POST") { 
    $email = $_POST['email'];
    $password = $_POST['pwd'];


    $sql = "SELECT * FROM members WHERE email = ?";
    $run = $conn->prepare($sql);
    $run->bind_param("s", $email);
    $run->execute();


    $results = $run->get_result();

    if ($results->num_rows == 1) { 
        $admin = $results->fetch_assoc();

        if ($admin['password'] == "123" && $password == "123") {
            $_SESSION['new_member'] = true;
            $_SESSION['member_id'] = $admin["member_id"];
            header("Location: dashboard.php");
            exit();
        }


        if (password_verify($password, $admin['password'])) { 
            $_SESSION['member_id'] = $admin["member_id"];
            header("Location: dashboard.php");
            exit();
        }else { 
            header("Location: index.php");
            exit();
        }
        

    }else { 
        echo "Takav e-mail ne postoji u bazi podataka.";
    }

 }

?>

<html>
    <head>
        
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

        <form action = "" method = "POST">
        <div class="mb-3">
            <label for="" class="form-label">E-mail</label>
            <input
                type="input"
                class="form-control"
                name="email"
                id=""
                placeholder="Upisi e-mail"
            />
            <label for="" class="form-label">Password</label>
            <input
                type="password"
                class="form-control"
                name="pwd"
                id=""
                placeholder="Upisi Lozinku"
            /> <br>
            <input
                name=""
                id=""
                class="btn btn-primary"
                type="submit"
                value="Uloguj se "
            />
         
        </div>
        </form>


    </body>

</html>

