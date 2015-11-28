<?php

namespace AppBundle\Entity;


class GroupRepositoryTest extends \PHPUnit_Framework_TestCase
{
    private $user;

    private $entityManager;
    private $groupRepository;
    private $userRepository;

    /**
     * @var Group
     */
    protected $group;

    protected function setUp()
    {
        $this->entityManager = getEntityManager();
        $this->groupRepository = $this->entityManager->getRepository('AppBundle\Entity\Group');
        $this->userRepository = $this->entityManager->getRepository('AppBundle\Entity\User');

        $this->group = new Group();
        $this->group->setName("EXAMPLE__TEST_GROUP");

        $this->user = new User();
        $this->user
            ->setUsername("Mario Perez")
            ->setUsernameCanonical(strtolower("Mario Perez"))
            ->setEmail("mario.perez@ibm.co.uk")
            ->setEmailCanonical(strtolower("mario.perez@ibm.co.uk"))
            ->setPassword(password_hash('WowSoSecretPassword', PASSWORD_DEFAULT))
            ->setRoles(['ROLE_MANAGER', 'ROLE_PLAYER', 'ROLE_ADMIN', 'ROLE_SUPER_ADMIN'])
            ->setEnabled(true)
            ->setSalt("AnRandomlyGeneratedSalt")
            ->setLocked(false)
            ->setExpired(false)
            ->setCredentialsExpired(false);

        $this->tearDown();  // Clean database (this exercise is sharing DB for all environments)
    }

    protected function tearDown()
    {
        $user = $this->userRepository->findOneBy(["email" => $this->user->getEmail()]);
        $group = $this->groupRepository->findOneBy(["name" => $this->group->getName()]);

        if (!empty($user)) {
            $this->entityManager->remove($user);
        }

        if (!empty($group)) {
            $this->entityManager->remove($group);
        }

        $this->entityManager->flush();
    }

    public function testManyToManyPersist()
    {
        $this->group->addUser($this->user);

        $this->entityManager->persist($this->user);
        $this->entityManager->persist($this->group);

        $this->entityManager->flush();

        $persistedGroup = $this->groupRepository->find($this->group->getId());
        $persistedUser = $this->userRepository->find($this->user->getId());

        $this->assertEquals($this->user, $persistedGroup->getUser()->first());
        $this->assertEquals($this->group, $persistedUser->getGroup()->first());
    }
}