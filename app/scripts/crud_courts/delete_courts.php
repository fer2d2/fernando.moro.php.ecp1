<?php

require_once __DIR__ . '/../../../config/bootstrap.php';

if ($argc < 2) {
    echo "Usage: " . basename(__FILE__) . " ids=id_1,id_2,...,id_n" . PHP_EOL;
    exit;
}

$cmd_data = [];
parse_str(implode('&', array_slice($argv, 1)), $cmd_data);

$courts_ids = explode(',', $cmd_data['ids']);

$em = GetEntityManager();
$courtRepository = $em->getRepository('AppBundle\Entity\Court');

foreach ($courts_ids as $court_id) {
    $court = $courtRepository->find($court_id);

    if ($court) {
        $em->remove($court);
        echo "Removed court: $court_id" . PHP_EOL;
    } else {
        echo "Court with id $court_id was not found" . PHP_EOL;
    }
}

$em->flush();