<?php

// php app/scripts/crud_users/modify_user.php id=5 username=fer5d2 email=fernando.moro@asp.net password=otrapass roles=ROLE_TESTER groups=players

require_once __DIR__ . '/../../../config/bootstrap.php';

if ($argc < 2) {
    echo "Usage: " . basename(__FILE__) . " id=value [username=value email=value password=value roles=value_1,...,value_n groups=group_name_1,...,group_name_N enabled=true|false salt=value locked=true|false expired=true|false credentials_expired=true|false]" . PHP_EOL;
    exit;
}

$cmd_data = [];
parse_str(implode('&', array_slice($argv, 1)), $cmd_data);

$user_id = array_key_exists('id', $cmd_data) ? $cmd_data['id'] : null;
$username = array_key_exists('username', $cmd_data) ? $cmd_data['username'] : null;
$email = array_key_exists('email', $cmd_data) ? $cmd_data['email'] : null;
$password = array_key_exists('password', $cmd_data) ? password_hash($cmd_data['password'], PASSWORD_DEFAULT) : null;
$roles = array_key_exists('roles', $cmd_data) ? explode(',', $cmd_data['roles']) : null;
$groups = array_key_exists('groups', $cmd_data) ? explode(',', $cmd_data['groups']) : null;
$enabled = array_key_exists('enabled', $cmd_data) ? filter_var($cmd_data['enabled'], FILTER_VALIDATE_BOOLEAN) : null;
$salt = array_key_exists('salt', $cmd_data) ? $cmd_data['salt'] : null;
$locked = array_key_exists('locked', $cmd_data) ? filter_var($cmd_data['locked'], FILTER_VALIDATE_BOOLEAN) : null;
$expired = array_key_exists('expired', $cmd_data) ? filter_var($cmd_data['expired'], FILTER_VALIDATE_BOOLEAN) : null;
$credentials_expired = array_key_exists('credentials_expired', $cmd_data) ? filter_var($cmd_data['credentials_expired'], FILTER_VALIDATE_BOOLEAN) : null;

$em = GetEntityManager();
$userRepository = $em->getRepository('AppBundle\Entity\User');
$groupRepository = $em->getRepository('AppBundle\Entity\Group');

$user = $userRepository->find($user_id);

if (!is_null($username))
    $user->setUsername($username);
if (!is_null($username))
    $user->setUsernameCanonical(strtolower($username));
if (!is_null($email))
    $user->setEmail($email);
$user->setEmailCanonical(strtolower($email));
if (!is_null($password))
    $user->setPassword($password);
if (!is_null($roles))
    $user->setRoles($roles);
if (!is_null($enabled))
    $user->setEnabled($enabled);
if (!is_null($salt))
    $user->setSalt($salt);
if (!is_null($locked))
    $user->setLocked($locked);
if (!is_null($expired))
    $user->setExpired($expired);
if (!is_null($credentials_expired))
    $user->setCredentialsExpired($credentials_expired);

if (!is_null($groups)) {
    $currentGroups = $user->getGroup();

    foreach ($currentGroups as $currentGroup) {
        $user->removeGroup($currentGroup);
    }

    foreach ($groups as $group) {
        $groupEntity = $groupRepository->findOneBy(["name" => $group]);
        $user->addGroup($groupEntity);
    }
}

$em->persist($user);
$em->flush();