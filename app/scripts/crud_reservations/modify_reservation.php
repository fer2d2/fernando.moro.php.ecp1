<?php

// php app/scripts/crud_reservations/modify_reservation.php id=0 datetime=2016-12-05_04:32:12 court=21 user=fernando.moro@php.net

require_once __DIR__ . '/../../../config/bootstrap.php';

if ($argc < 2) {
    echo "Usage: " . basename(__FILE__) . " id=value [datetime=Y-m-d_H:i:s court=court_id user=user_email]" . PHP_EOL;
    exit;
}

$cmd_data = [];
parse_str(implode('&', array_slice($argv, 1)), $cmd_data);

$reservation_id = array_key_exists('id', $cmd_data) ? $cmd_data['id'] : null;
$datetime = array_key_exists('datetime', $cmd_data) ? DateTime::createFromFormat("Y-m-d_H:i:s", $cmd_data['datetime']) : null;
$court_id = array_key_exists('court', $cmd_data) ? $cmd_data['court'] : null;
$user_email = array_key_exists('user', $cmd_data) ? $cmd_data['user'] : null;

$em = GetEntityManager();
$revervationRepository = $em->getRepository('AppBundle\Entity\Reservation');
$userRepository = $em->getRepository('AppBundle\Entity\User');
$courtRepository = $em->getRepository('AppBundle\Entity\Court');

$court = !is_null($court_id) ? $courtRepository->find($court_id) : null;
$user = !is_null($user_email) ? $userRepository->findOneBy(["email" => $user_email]) : null;

$reservation = $revervationRepository->find($reservation_id);

if (!is_null($datetime))
    $reservation->setDatetime($datetime);
if (!is_null($court))
    $reservation->setCourt($court);
if (!is_null($user))
    $reservation->setUser($user);

$em->persist($reservation);
$em->flush();