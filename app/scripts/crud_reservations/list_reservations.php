<?php

require_once __DIR__ . '/../../../config/bootstrap.php';

$entityManager = GetEntityManager();

$repository = $entityManager->getRepository('AppBundle\Entity\Reservation');
$reservations = $repository->findAll();

$mask = "|%5.5s |%30.30s |%8.8s |%30.30s |" . PHP_EOL;

printf($mask, 'ID', 'DATETIME', 'COURT', 'USER');

foreach ($reservations as $reservation) {
    printf($mask, $reservation->getId(), $reservation->getDatetime()->format('Y-m-d H:i:s'), $reservation->getCourt()->getId(), $reservation->getUser()->getEmail());
}