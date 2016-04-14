<?php

require_once(__DIR__ . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Genderize.php');

try {

    $Recognizer = Genderize::factory();

    $john = $Recognizer->set_names('Ashley')->recognize();
    print_r($john);

    $asia = $Recognizer->set_names('Asia')->recognize();
    print_r($asia);

    $asiaPL = $Recognizer->set_country_id('pl')->set_names('Asia')->recognize();
    print_r($asiaPL);

    $multiPL = $Recognizer->set_country_id('pl')->set_names(['Asia', 'Janek', 'Piotr', 'Maria'])->recognize();
    print_r($multiPL);

} catch (Exception $e) {
    var_dump($e->getMessage());
    echo $e->getTraceAsString();
}





