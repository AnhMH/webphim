<?php
$time = time();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Admin</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="<?php echo $BASE_URL;?>/css/admin.css?<?php echo $time;?>">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
        <script src="<?php echo $BASE_URL;?>/js/admin.js?<?php echo $time;?>"></script>
    </head>
    <body>
        <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
            <a class="navbar-brand" href="#">Navbar</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="collapsibleNavbar">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $BASE_URL;?>/users">Admin</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $BASE_URL;?>/countries">Countries</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $BASE_URL;?>/movies">Movies</a>
                    </li>    
                </ul>
            </div>  
        </nav>
        <?= $this->Flash->render() ?>
        <div class="container" style="margin-top:30px">
            <?= $this->fetch('content') ?>
        </div>
    </body>
</html>
