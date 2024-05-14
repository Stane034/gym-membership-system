<html>

<head>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
            crossorigin="anonymous"
        />
</bead>

<?php 
    require_once 'config.php';

    if (!isset($_SESSION['member_id'])) { 
        header("Location: index.php");
        exit();
    }

    if (isset($_SESSION['new_member']) == true) { 
      echo '<form action = "new_password.php" method = "POST">';
        echo '<div class="mb-3">';
            echo '<label for="" class="form-label">Nova lozinka</label>';
            echo '<input type="password" style = "display: none" name="unvisible" value = ' . $_SESSION['member_id'] . ' id="" placeholder="Upisi novu lozinku"/>';
            echo '<input type="password" class="form-control" name="lozinka" id="" placeholder="Upisi novu lozinku"/><br>';
            echo '<button type="submit" class="btn btn-primary">Potvrdi</button>';
        echo '</div>';
        echo '</form>';
        die();
    }



?>

    <p>Client Side panel is in progress</p>



</html>

