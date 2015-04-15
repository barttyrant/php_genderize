<?php

require_once(__DIR__ . DIRECTORY_SEPARATOR . 'src/Genderize.php');

try {


    $Recognizer = Genderize::factory();

    $asia = $Recognizer->set_name('Asia')->recognize();
    print_r($asia);

    $asiaPL = $Recognizer->set_country_id('pl')->set_name('Asia')->recognize();
    print_r($asiaPL);

} catch (Exception $e) {
    var_dump($e->getMessage());
    echo $e->getTraceAsString();
}





