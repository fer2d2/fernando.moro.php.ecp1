<?php

// php app/scripts/crud_reservations/create_reservation.php datetime=2016-12-5_05:32:12 court=21 user=fernando.moro@php.net

require_once __DIR__ . '/../../../config/bootstrap.php';

if ($argc < 2) {
    echo "Usage: " . basename(__FILE__) . " datetime=Y-m-d_H:i:s court=court_id user=user_email" . PHP_EOL;
    exit;
}

$cmd_data = [];
parse_str(implode('&', array_slice($argv, 1)), $cmd_data);

$datetime = DateTime::createFromFormat("Y-m-d_H:i:s", $cmd_data['datetime']);
$court_id = $cmd_data['court'];
$user_email = $cmd_data['user'];

$em = GetEntityManager();
$revervationRepository = $em->getRepository('AppBundle\Entity\Reservation');
$userRepository = $em->getRepository('AppBundle\Entity\User');
$courtRepository = $em->getRepository('AppBundle\Entity\Court');

$court = $courtRepository->find($court_id);
$user = $userRepository->findOneBy(["email" => $user_email]);

$reservation = new \AppBundle\Entity\Reservation();
$reservation
    ->setDatetime($datetime)
    ->setCourt($court)
    ->setUser($user);

$em->persist($reservation);
$em->flush();