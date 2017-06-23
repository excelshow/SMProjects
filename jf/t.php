<?php

ignore_user_abort(FALSE); // run script in background
set_time_limit(0); // run script forever
$interval = 20; // do every 15 minutes…
do {
    $fp = fopen('t.txt', 'a');
    fwrite($fp, 'test');
    fclose($fp);
    sleep($interval); // wait 15 minutes
} while (TRUE);

exit();
//error_reporting(E_ALL);
echo "<h2>tcp/ip connection </h2>\n";
$service_port = 8111;
$address = '123.234.131.233';

$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
if ($socket === false) {
    echo "socket_create(IP) failed: reason: " . socket_strerror(socket_last_error()) . "\n";
    exit();
} else {
    echo "OK. \n";
}

echo "Attempting to connect to '$address' on port '$service_port'...";
$result = socket_connect($socket, $address, $service_port);
if ($result === false) {
    echo "socket_connect() failed.\nReason: ($result) " . socket_strerror(socket_last_error($socket)) . "\n";
} else {
    echo "OK \n";
}

echo "closeing socket..";
socket_close($socket);
echo "ok .\n\n";


/////////////////////
exit();
require_once "PHPTelnet.php";

$telnet = new PHPTelnet();
$telnet->show_connect_error = 0;

// if the first argument to Connect is blank,
// PHPTelnet will connect to the local host via 127.0.0.1
$result = $telnet->Connect('103.234.131.233', '', '');
echo $result;
exit();
switch ($result) {
    case 0:
        $telnet->DoCommand('enter command here', $result);
// NOTE: $result may contain newlines
        echo $result;
        $telnet->DoCommand('another command', $result);
        echo $result;
// say Disconnect(0); to break the connection without explicitly logging out
        $telnet->Disconnect();
        break;
    case 1:
        echo '[PHP Telnet] Connect failed: Unable to open network connection';
        break;
    case 2:
        echo '[PHP Telnet] Connect failed: Unknown host';
        break;
    case 3:
        echo '[PHP Telnet] Connect failed: Login failed';
        break;
    case 4:
        echo '[PHP Telnet] Connect failed: Your PHP version does not support PHP Telnet';
        break;
}
?> 