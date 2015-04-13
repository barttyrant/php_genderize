<?php

require_once(__DIR__ . DIRECTORY_SEPARATOR . 'src/Genderize.php');

$recognizer = new \Genderize\Base\Recognizer();

$peter = $recognizer->set_country_id('pl')->set_name('Peter')->set_language_id('pl')->recognize(false);



