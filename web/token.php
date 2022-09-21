<html lang="en">
    <head>
        <title>Token</title>
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
    <?php $arrDump = json_decode($_POST["flexresponse"], true); ?>
    <body>
        <div class="container card">
            <div class="card-body">
                 <form action="receipt.php" id="my-token-form" method="post">
                    <h1>Information de paiement</h1>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Nom & Prénom</th>
                                <th scope="col">E-mail</th>
                                <th scope="col">Téléphone</th>
                                <th scope="col">Pays</th>
                                <th scope="col">Ville</th>
                                <th scope="col">Adresse</th>
                                <th scope="col">Total à payer</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr scope="row">
                                <td> <?php echo $_POST['customer']; ?></td>
                                <td> <?php echo $_POST['email']; ?></td>
                                <td> <?php echo $_POST['phone']; ?></td>
                                <td> <?php echo $_POST['country']; ?></td>
                                <td> <?php echo $_POST['city']; ?></td>
                                <td> <?php echo $_POST['adress']; ?></td>
                                <td>
                                <?php echo $_POST['total_amount']; ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <button type="button" id="pay-button" class="btn btn-primary">Valider le paiement</button>
                    <input type="hidden" id="flexresponse" name="flexresponse">
                </form>
            </div>
        </div>
        <script>
            var payButton = document.querySelector('#pay-button');
            var flexResponse = document.querySelector('#flexresponse');
            var form = document.querySelector('#my-token-form');

            payButton.addEventListener('click', function() {  
                  
                  var token = '<?php echo $arrDump; ?>' ;
                  console.log(JSON.stringify(token));
                  flexResponse.value = JSON.stringify(token);
                  form.submit();
            });
        </script>

    </body>
</html>