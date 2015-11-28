<?php

namespace AppBundle\Entity;
require_once __DIR__ . '/../../../config/bootstrap.php';

class UserRepositoryTest extends \PHPUnit_Framework_TestCase
{
    private $entityManager;

    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    private $userRepository;

    /**
     * @var User
     */
    protected $user;

    protected function setUp()
    {
        $this->entityManager = getEntityManager();
        $this->userRepository = $this->entityManager->getRepository('AppBundle\Entity\User');

        $this->user = new User();
        $this->user
            ->setUsername("Alvaro Martin")
            ->setUsernameCanonical(strtolower("Alvaro Martin"))
            ->setEmail("alvaro.martin@php.net")
            ->setEmailCanonical(strtolower("alvaro.martin@php.net"))
            ->setPassword(password_hash('WowSoSecretPassword', PASSWORD_DEFAULT))
            ->setRoles(['ROLE_MANAGER', 'ROLE_PLAYER', 'ROLE_ADMIN', 'ROLE_SUPER_ADMIN'])
            ->setEnabled(true)
            ->setSalt("AnRandomlyGeneratedSalt")
            ->setLocked(false)
            ->setExpired(false)
            ->setCredentialsExpired(false);

        $this->tearDown(); // Clean database (this exercise is sharing DB for all environments)
    }

    protected function tearDown()
    {
        $user = $this->userRepository->findOneBy(["email" => $this->user->getEmail()]);

        if (!empty($user)) {
            $this->entityManager->remove($user);
            $this->entityManager->flush();
        }
    }

    public function testDelete()
    {
        $this->entityManager->persist($this->user);
        $this->entityManager->flush();

        $persistedUser = $this->userRepository->findOneBy(["email" => $this->user->getEmail()]);
        $this->assertNotEmpty($persistedUser);

        $this->entityManager->remove($persistedUser);
        $this->entityManager->flush();
        $persistedUser = $this->userRepository->findOneBy(["email" => $this->user->getEmail()]);
        $this->assertEmpty($persistedUser);
    }

    public function testCreate()
    {
        $this->assertEmpty($this->userRepository->findOneBy(["email" => $this->user->getEmail()]));
        $this->entityManager->persist($this->user);
        $this->entityManager->flush();

        $this->assertEquals($this->user, $this->userRepository->findOneBy(["email" => $this->user->getEmail()]));
    }

    public function testUpdate()
    {
        $this->entityManager->persist($this->user);
        $this->entityManager->flush();

        $this->user->setUsername("Jorge Fernandez");
        $this->user->setRoles(['ROLE_MANAGER', 'ROLE_ADMIN', 'ROLE_SUPER_ADMIN']);
        $this->entityManager->persist($this->user);
        $this->entityManager->flush();

        $persistedUser = $this->userRepository->findOneBy(["email" => $this->user->getEmail()]);
        $this->assertEquals($this->user, $persistedUser);
        $this->assertEquals($this->user->getRoles(), $persistedUser->getRoles());
    }
}