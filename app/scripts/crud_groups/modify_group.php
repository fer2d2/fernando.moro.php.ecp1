<?php

require_once __DIR__ . '/../../../config/bootstrap.php';

if ($argc < 2) {
    echo "Usage: " . basename(__FILE__) . " id=value name=value [roles=value_1,...,value_n]" . PHP_EOL;
    exit;
}

$cmd_data = [];
parse_str(implode('&', array_slice($argv, 1)), $cmd_data);

$group_id = $cmd_data['id'];
$name = $cmd_data['name'];

$roles = [];
if (array_key_exists('roles', $cmd_data)) {
    $roles = explode(',', $cmd_data['roles']);
}

$em = GetEntityManager();
$groupRepository = $em->getRepository('AppBundle\Entity\Group');

$group = $groupRepository->find($group_id);

if ($group) {
    $group->setName($name);
    if (!empty($roles)) {
        $group->setRoles($roles);
    }
} else {
    echo "Group with id $group_id was not found" . PHP_EOL;
}

$em->persist($group);
$em->flush();