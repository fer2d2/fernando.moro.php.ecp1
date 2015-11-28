<?php

require_once __DIR__ . '/../../../config/bootstrap.php';

if ($argc < 2) {
    echo "Usage: " . basename(__FILE__) . " ids=id_1,id_2,...,id_n" . PHP_EOL;
    exit;
}

$cmd_data = [];
parse_str(implode('&', array_slice($argv, 1)), $cmd_data);

$reservations_ids = explode(',', $cmd_data['ids']);

$em = GetEntityManager();
$reservationRepository = $em->getRepository('AppBundle\Entity\Reservation');

foreach ($reservations_ids as $reservation_id) {
    $reservation = $reservationRepository->find($reservation_id);

    if ($reservation) {
        $em->remove($reservation);
        echo "Removed reservation: $reservation_id" . PHP_EOL;
    } else {
        echo "Reservation with id $reservation_id was not found" . PHP_EOL;
    }
}

$em->flush();