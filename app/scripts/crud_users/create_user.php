<?php

// php app/scripts/crud_users/create_user.php username=fer2d2 email=fernando.moro@php.net password=unapass roles=ROLE_MANAGER groups=players,admins

require_once __DIR__ . '/../../../config/bootstrap.php';

if ($argc < 2) {
    echo "Usage: " . basename(__FILE__) . " username=value email=value password=value roles=value_1,...,value_n [groups=group_name_1,...,group_name_N enabled=true|false salt=value locked=true|false expired=true|false credentials_expired=true|false]" . PHP_EOL;
    exit;
}

$cmd_data = [];
parse_str(implode('&', array_slice($argv, 1)), $cmd_data);

$username = $cmd_data['username'];
$email = $cmd_data['email'];
$password = password_hash($cmd_data['password'], PASSWORD_DEFAULT);
$roles = explode(',', $cmd_data['roles']);
$groups = explode(',', $cmd_data['groups']);
$enabled = array_key_exists('enabled', $cmd_data) ? filter_var($cmd_data['enabled'], FILTER_VALIDATE_BOOLEAN) : true;
$salt = array_key_exists('salt', $cmd_data) ? $cmd_data['salt'] : 'PLACEHOLDER';
$locked = array_key_exists('locked', $cmd_data) ? filter_var($cmd_data['locked'], FILTER_VALIDATE_BOOLEAN) : false;
$expired = array_key_exists('expired', $cmd_data) ? filter_var($cmd_data['expired'], FILTER_VALIDATE_BOOLEAN) : false;
$credentials_expired = array_key_exists('credentials_expired', $cmd_data) ? filter_var($cmd_data['credentials_expired'], FILTER_VALIDATE_BOOLEAN) : false;

$em = GetEntityManager();
$userRepository = $em->getRepository('AppBundle\Entity\User');
$groupRepository = $em->getRepository('AppBundle\Entity\Group');

$user = new \AppBundle\Entity\User();
$user
    ->setUsername($username)
    ->setUsernameCanonical(strtolower($username))
    ->setEmail($email)
    ->setEmailCanonical(strtolower($email))
    ->setPassword($password)
    ->setRoles($roles)
    ->setEnabled($enabled)
    ->setSalt($salt)
    ->setLocked($locked)
    ->setExpired($expired)
    ->setCredentialsExpired($credentials_expired);

foreach ($groups as $group) {
    $groupEntity = $groupRepository->findOneBy(["name" => $group]);
    $user->addGroup($groupEntity);
}

$em->persist($user);
$em->flush();