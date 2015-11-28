<?php // app/scripts/list_groups.php

require_once __DIR__ . '/../../../config/bootstrap.php';

$entityManager = GetEntityManager();

$courtRepository = $entityManager->getRepository('AppBundle\Entity\Court');
$courts = $courtRepository->findAll();

//$items = 0;
//echo sprintf("  %2s: %10s\n", 'Id', 'Active:');
//foreach ($courts as $court) {
//    echo sprintf("- %2d: %10s\n", $court->getId(), ($court->getActive() ? 'true' : 'false'));
//    $items++;
//}
//
//echo "\nTotal: $items courts.\n\n";

$mask = "|%5.5s |%8.8s |" . PHP_EOL;

printf($mask, 'ID', 'ACTIVE');

foreach ($courts as $court) {
    printf($mask, $court->getId(), $court->getActive() ? 'true' : 'false');
}