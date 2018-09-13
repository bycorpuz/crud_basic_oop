<?php
// Initialize the session
session_start();
 
// If session variable is not set it will redirect to login page
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
  header("location: ../pages/login.php");
  exit;
}

// Check existence of id parameter before processing further
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    $id = $_GET["id"];
    // Include config file
    require_once '../config/config.php';
    
    // Prepare a select statement
    $sql = "SELECT * FROM employees WHERE id = $id";
    $stmt = sqlsrv_query( $conn, $sql );
    if( $stmt === false) {
        die( print_r( sqlsrv_errors(), true) );
    }

    if( sqlsrv_fetch( $stmt ) === false) {
        die( print_r( sqlsrv_errors(), true));
    }

    $name = sqlsrv_get_field( $stmt, 1);
    $address = sqlsrv_get_field( $stmt, 2);
    $salary = sqlsrv_get_field( $stmt, 3);

} else{
    // URL doesn't contain id parameter. Redirect to error page
    header("location: error.php");
    exit();
}

?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; }

        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="page-header">
        <h1>Hi, <b><a href="../pages/logout.php"><?php echo htmlspecialchars($_SESSION['username']); ?></a></b>. Welcome to UCT WebApp.</h1>
    </div>

    <!-- READ Page -->
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h1>View Record</h1>
                    </div>
                    <div class="form-group">
                        <label>Name</label>
                        <p class="form-control-static"><?php echo $name; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Address</label>
                        <p class="form-control-static"><?php echo $address; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Salary</label>
                        <p class="form-control-static"><?php echo $salary; ?></p>
                    </div>
                    <p><a href="welcome.php" class="btn btn-primary">Back</a></p>
                </div>
            </div>        
        </div>
    </div>

</body>
</html>