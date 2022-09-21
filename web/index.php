<?php

include 'generatekey.php';

include 'infoOrder.php';

?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Make payement</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">

        <style>
            #number-container, #securityCode-container {
                height: 38px;
            }

            .flex-microform-focused {
                background-color: #fff;
                border-color: #80bdff;
                outline: 0;
                box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
            }
        </style>
    </head>

   <div class="container card px-0 m-5">
            <div class="card-header mx-0">
                <h4 class="text-center">Make payement</h4>
            </div>
            <div class="card-body">
            <div class="text-center text-danger" id="errors-output" role="alert"> <?php if($od==null || $order==null){ echo "Commande introuvable"; }?> </div>
            

                <form action="receipt.php" id="my-sample-form" method="post">
                    <div class="form-row">
                        <div class="form-group  col-md-4" >
                              <label for="cardholderName">Client</label>
                              <input  class="form-control" name="customer" value="<?php if($order!=null){
                                if(isset($order['customer'])){
                                  echo $order['customer']['firstname']." ".$order['customer']['lastname'] ; 
                                }
                               ?>" readonly>
                        </div>
                        <div class="form-group  col-md-4" >
                              <label for="cardholderName">E-mail</label>
                              <input  class="form-control" name="email" value="<?php if($order!=null){ 
                                if(isset($order['customer'])){
                                  echo $order['customer']['email'] ; 
                                }?>" readonly>
                        </div>
                        <div class="form-group  col-md-4" >
                              <label for="cardholderName">Téléphone</label>
                              <input name="phone" value="<?php if($order!=null){ 
                                if(isset($order['customer'])){
                                  echo $order['customer']['phone'] ; 
                                }?>" class="form-control"  readonly>
                        </div>
                      
                    </div>
                    <div class="form-row">
                        <div class="form-group  col-md-4" >
                              <label for="cardholderName">Pays</label>
                              <input  class="form-control" name="country" value="<?php if($order!=null){ echo $order['facturation_address']['country']['name'] ; } ?>" readonly>
                        </div>
                        <div class="form-group  col-md-4" >
                              <label for="cardholderName">Ville</label>
                              <input name="city" value="<?php if($order!=null){ echo $order['facturation_address']['city']['name'] ; } ?>" class="form-control"  readonly>
                        </div>
                        <div class="form-group  col-md-4" >
                              <label for="cardholderName">Région</label>
                              <input  class="form-control" name="state" value="<?php if($order!=null){ echo  $order['facturation_address']['state'] ; } ?>" readonly>
                        </div>
                    </div>
                    <div class="form-row">
                        
                        <div class="form-group  col-md-6" >
                              <label for="cardholderName">Adresse</label>
                              <input  class="form-control" name="adress" value="<?php if($order!=null){ echo  $order['facturation_address']['information'] ; } ?>" readonly>
                        </div>
                        <div class="form-group  col-md-6" >
                              <label for="cardholderName">Montant à payer</label>
                              <input name="total_amount" value="<?php if($order!=null){ echo $order['total_amount'] ; } ?> XOF" class="form-control"  readonly>
                        </div>
                    </div>
                    <div class="form-row">
                         
                    </div>
                    <div class="form-row">
                        <!--label for="cardholderName">Nom</label>
                        <input id="cardholderName" class="form-control" name="cardholderName" placeholder="Name on the card"-->
                        <div class="form-group col-md-6">
                          <label id="cardNumber-label">Numéro de la carte</label>
                          <div id="number-container" class="form-control"></div>
                        </div>
                        <div class="form-group col-md-6">
                          <label for="securityCode-container">Code de sécurité</label>
                          <div id="securityCode-container" class="form-control"></div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="expMonth">Mois d'expiration</label>
                            <select id="expMonth" class="form-control">
                                <option>01</option>
                                <option>02</option>
                                <option>03</option>
                                <option>04</option>
                                <option>05</option>
                                <option>06</option>
                                <option>07</option>
                                <option>08</option>
                                <option>09</option>
                                <option>10</option>
                                <option>11</option>
                                <option>12</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="expYear">Année d'expiration</label>
                            <input id="expYear" placeholder="ex: <?php echo date('Y') ?>" name="expYear" type="number" min="<?php echo date('Y') ?>" max="<?php echo date('Y')+10 ?>" class="form-control">
                                
                        </div>
                    </div>

                    <button type="button" <?php if($order==null){ echo "disabled"; } ?> id="pay-button" class="btn btn-primary">Payer</button>
                    <input type="hidden" id="flexresponse" name="flexresponse">
                    <input type="hidden" id="od" name="od" value="<?php echo $_GET['od']; ?>">
                    <input type="hidden" id="rd_uri" name="rd_uri" value="<?php echo $_GET['rd_uri']; ?>">
                    
                </form>
            </div>
        </div>

    <script src="https://flex.cybersource.com/cybersource/assets/microform/0.11/flex-microform.min.js"></script>
    
            
  <script>
            // JWK is set up on the server side route for /

            var form = document.querySelector('#my-sample-form');
            var payButton = document.querySelector('#pay-button');
            var flexResponse = document.querySelector('#flexresponse');
            var expMonth = document.querySelector('#expMonth');
            var expYear = document.querySelector('#expYear');
            var errorsOutput = document.querySelector('#errors-output');
          
            // the capture context that was requested server-side for this transaction
            var captureContext = '<?php echo $captureContext; ?>'  ;
            console.log(captureContext);

            // custom styles that will be applied to each field we create using Microform
            var myStyles = {  
              'input': {    
                'font-size': '14px',    
                'font-family': 'helvetica, tahoma, calibri, sans-serif',    
                'color': '#555'  
              },  
              ':focus': { 'color': 'blue' },  
              ':disabled': { 'cursor': 'not-allowed' },  
              'valid': { 'color': '#3c763d' },  
              'invalid': { 'color': '#a94442' }
            };

            // setup
            var flex = new Flex(captureContext);
            var microform = flex.microform({ styles: myStyles });
            var number = microform.createField('number', { placeholder: 'Saisir le numéro de la carte' });
            var securityCode = microform.createField('securityCode', { placeholder: '•••' });

            number.load('#number-container');
            securityCode.load('#securityCode-container');


            payButton.addEventListener('click', function() {  
              var options = {    
                expirationMonth: expMonth.value,  
                expirationYear: expYear.value 
              };

              microform.createToken(options, function (err, token) {
                if (err) {
                  // handle error
                  console.error(err);
                  errorsOutput.textContent = err.message;
                } else {
                  // At this point you may pass the token back to your server as you wish.
                  // In this example we append a hidden input to the form and submit it.      
                  console.log(JSON.stringify(token));
                  flexResponse.value = JSON.stringify(token);
                  form.submit();
                }
              });
            });
        </script>
    </body>
</html>