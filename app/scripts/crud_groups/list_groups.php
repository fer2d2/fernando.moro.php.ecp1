<?php

require_once __DIR__ . '/../../../config/bootstrap.php';

$entityManager = GetEntityManager();

$repository = $entityManager->getRepository('AppBundle\Entity\Group');
$groups = $repository->findAll();

$mask = "|%5.5s |%10.10s |%60.60s |%60.60s |" . PHP_EOL;

printf($mask, 'ID', 'NAME', 'ROLES', 'USERS');

foreach ($groups as $group) {
    $users = [];
    foreach ($group->getUser() as $user) {
        $users[] = $user->getUsername();
    }

    printf($mask, $group->getId(), $group->getName(), implode(",", $group->getRoles()), implode(",", $users));
}