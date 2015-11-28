<?php

require_once __DIR__ . '/../../../config/bootstrap.php';

$entityManager = GetEntityManager();

$repository = $entityManager->getRepository('AppBundle\Entity\User');
$users = $repository->findAll();

$mask = "|%5.5s |%30.30s |%30.30s |%40.40s |%40.40s |" . PHP_EOL;

printf($mask, 'ID', 'NAME', 'EMAIL', 'ROLES', 'GROUPS');

foreach ($users as $user) {
    $groups = [];
    foreach ($user->getGroup() as $group) {
        $groups[] = $group->getName();
    }

    printf($mask, $user->getId(), $user->getUsername(), $user->getEmail(), implode(",", $user->getRoles()), implode(",", $groups));
}