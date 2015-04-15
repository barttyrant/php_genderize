<?php

require_once(__DIR__ . DIRECTORY_SEPARATOR . 'src/Genderize.php');

try {
    $recognizer = new \Genderize\Base\Recognizer();

    $peter = $recognizer->set_country_id('pl')->set_name('Peter')->set_language_id('pl')->recognize(true);

    var_dump($peter);
} catch (Exception $e) {
    var_dump($e->getMessage());
}





