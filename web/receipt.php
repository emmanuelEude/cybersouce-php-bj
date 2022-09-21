<?php

$transientToken = json_decode($_POST["flexresponse"], true);
include 'infoOrder.php';
include 'paymentWithFlexTransientToken.php';

?>


<html lang="en">
    <head>
        <title>Receipt</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">

        <style>
            .td-1 {
                word-break: break-all;
                word-wrap: break-word;
            }
        </style>
    </head>
    
    <body>
        <div class="container card m-5">
            <div class="card-body">
            <?php if($payement_success){ ?>
                <div class="alert alert-success"> <?php echo $response_msg; ?></div>
            <?php }else{

             ?>
                <div class="alert alert-danger"><?php echo $response_msg; ?></div>
            <?php }?>
            <table class="table">
               
                <tbody>
                    <tr>
                        <th scope="col">Client</th>
                        <td> <?php echo $_POST['customer']; ?></td>
                    </tr>
                    <tr>
                        <th scope="col">E-mail</th>
                        <td> <?php echo $_POST['email']; ?></td>
                    </tr>
                    <tr>
                        <th scope="col">Téléphone</th>
                        <td> <?php echo $_POST['phone']; ?></td>
                    </tr>
                    <tr>
                        <th scope="col">Pays</th>
                        <td> <?php echo $_POST['country']; ?></td>
                    </tr>
                    <tr>
                        <th scope="col">Région</th>
                        <td> <?php echo $_POST['state']; ?></td>
                    </tr>
                    <tr>
                        <th scope="col">Ville</th>
                        <td> <?php echo $_POST['city']; ?></td>
                    </tr>
                    <tr>
                        <th scope="col">Adresse</th>
                        <td> <?php echo $_POST['adress']; ?></td>
                    </tr>
                    <tr>
                        <th scope="col">Total à payer</th>
                        <td> <?php echo $_POST['total_amount']; ?></td>
                    </tr>
                   
                </tbody>
            </table>
        </div>
    </body>
</html>