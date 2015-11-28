<?php

require_once __DIR__ . '/../../../config/bootstrap.php';

if ($argc < 2) {
    echo "Usage: " . basename(__FILE__) . " ids=id_1,id_2,...,id_n" . PHP_EOL;
    exit;
}

$cmd_data = [];
parse_str(implode('&', array_slice($argv, 1)), $cmd_data);

$users_ids = explode(',', $cmd_data['ids']);

$em = GetEntityManager();
$userRepository = $em->getRepository('AppBundle\Entity\User');

foreach ($users_ids as $user_id) {
    $user = $userRepository->find($user_id);

    if ($user) {
        $em->remove($user);
        echo "Removed user: $user_id" . PHP_EOL;
    } else {
        echo "User with id $user_id was not found" . PHP_EOL;
    }
}

$em->flush();