<?php
$getSource = passthru('(echo menu player && echo show) | bluetoothctl');
echo $getSource;
