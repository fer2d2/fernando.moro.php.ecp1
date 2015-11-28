<?php

require_once __DIR__ . '/../../../config/bootstrap.php';

if ($argc < 2) {
    echo "Usage: " . basename(__FILE__) . " ids=id_1,id_2,...,id_n" . PHP_EOL;
    exit;
}

$cmd_data = [];
parse_str(implode('&', array_slice($argv, 1)), $cmd_data);

$groups_ids = explode(',', $cmd_data['ids']);

$em = GetEntityManager();
$groupRepository = $em->getRepository('AppBundle\Entity\Group');

foreach ($groups_ids as $group_id) {
    $group = $groupRepository->find($group_id);

    if ($group) {
        $em->remove($group);
        echo "Removed group: $group_id" . PHP_EOL;
    } else {
        echo "Group with id $group_id was not found" . PHP_EOL;
    }
}

$em->flush();