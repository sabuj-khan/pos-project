<?php



class CreditCardPaymentGateway implements PaymentGateway
{
    public function processPayment($amount)
    {
       
        $creditCardNumber = $_POST['credit_card_number'];
        $expirationDate = $_POST['expiration_date'];
        $cvv = $_POST['cvv'];

        // Make a request to the credit card processing API.
        $response = $this->api->charge($creditCardNumber, $amount, $expirationDate, $cvv);
       
        if ($response['success']) {
            return true;
        } else {
            
            return false;
        }
    }
  
}
