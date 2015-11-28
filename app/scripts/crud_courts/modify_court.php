<?php // app/scripts/create_court.php

require_once __DIR__ . '/../../../config/bootstrap.php';

if ($argc < 2) {
    echo "Usage: " . basename(__FILE__) . " id=value active=value" . PHP_EOL;
    exit;
}

$cmd_data = [];
parse_str(implode('&', array_slice($argv, 1)), $cmd_data);

$court_id = $cmd_data['id'];
$active = filter_var($cmd_data['active'], FILTER_VALIDATE_BOOLEAN);

$em = GetEntityManager();
$courtRepository = $em->getRepository('AppBundle\Entity\Court');

$court = $courtRepository->find($court_id);

if ($court) {
    $court->setActive($active);
} else {
    echo "Court with id $court_id was not found" . PHP_EOL;
}

$em->persist($court);
$em->flush();