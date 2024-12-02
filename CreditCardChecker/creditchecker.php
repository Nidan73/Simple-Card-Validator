<?php
function validateCard($card_numbers) {
    $number = $card_numbers;
    $sum = 0;
    $count = 0;
    $reversedNumber = strrev($number);

    for ($i = 0; $i < strlen($reversedNumber); $i++) {
        $digit = $reversedNumber[$i];
        if ($i % 2 == 1) {
            $digit *= 2;
        }
        if ($digit > 9) {
            $digit -= 9;
        }
        $sum += $digit;
    }

    $is_valid = ($sum % 10 == 0);
    $len = strlen($number);
    $start_digit = substr($card_numbers, 0, 2);

    $card_type = "INVALID";
    if ($is_valid) {
        if ($len == 15 && ($start_digit == "34" || $start_digit == "37")) {
            $card_type = "AMEX";
        } else if ($len == 16 && ((int)$start_digit >= 51 && (int)$start_digit <= 55)) {
            $card_type = "MASTERCARD";
        } else if (($len == 13 || $len == 16) && $card_numbers[0] == '4') {
            $card_type = "VISA";
        }
    }
    return $card_type;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $card_numbers = $_POST['cardNumber'];
    if (!is_numeric($card_numbers) || $card_numbers < 1) {
        $result = "Invalid input. Please enter a positive number.";
    } else {
        $card_type = validateCard($card_numbers);
        $result = "Result: $card_type";
    }
?>
<html>
<html lang>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Credit Card Type</title>
</head>
<body>
    <h1>Credit Card Validator</h1>
    <p><?php echo $result; ?></p>
</body>
</html>
<?php
}
?>
