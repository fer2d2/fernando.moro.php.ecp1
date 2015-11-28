<?php

// php app/scripts/crud_groups/create_group.php name=players roles=ROLE_PLAYER users=fernando.moro@radmas.com,fernando.moro@php.net

require_once __DIR__ . '/../../../config/bootstrap.php';

if ($argc < 2) {
    echo "Usage: " . basename(__FILE__) . " name=value roles=value_1,value_2,...,value_n [users=user_email_1,...,user_email_n]" . PHP_EOL;
    exit;
}

$cmd_data = [];
parse_str(implode('&', array_slice($argv, 1)), $cmd_data);

$name = $cmd_data['name'];
$roles = explode(',', $cmd_data['roles']);

$users_ids = [];
if (array_key_exists('users', $cmd_data)) {
    $users_ids = explode(',', $cmd_data['users']);
}

$em = GetEntityManager();
$userRepository = $em->getRepository('AppBundle\Entity\User');

$group = new \AppBundle\Entity\Group();

$group->setName($name);
$group->setRoles($roles);

foreach ($users_ids as $user_id) {
    $user = $userRepository->findOneBy(["email" => $user_id]);
    $group->addUser($user);
}

$em->persist($group);
$em->flush();