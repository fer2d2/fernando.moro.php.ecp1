<?php

namespace AppBundle\Entity;


class GroupTest extends \PHPUnit_Framework_TestCase
{
    private $testUserUsername = "Jorge";
    private $testUser;
    private $testUserUsername2 = "Alvaro";
    private $testUser2;
    /**
     * @var Group
     */
    protected $group;
    const TEST_GROUP = "TEST_GROUP";

    protected function setUp()
    {
        $this->group = new Group();
        $this->group->setName($this::TEST_GROUP);

        $this->testUser = new User();
        $this->testUser->setUsername($this->testUserUsername);

        $this->testUser2 = new User();
        $this->testUser2->setUsername($this->testUserUsername2);
    }

    protected function tearDown()
    {

    }

    public function testConstructor()
    {
        $this->assertEmpty($this->group->getId());
        $this->assertEquals($this::TEST_GROUP, $this->group->getName());
    }

    public function testGetId()
    {
        $this->assertEmpty($this->group->getId());
    }

    public function testName()
    {
        $testName = "TEST_GROUP_2";

        $this->assertEquals($this::TEST_GROUP, $this->group->getName());
        $this->group->setName($testName);
        $this->assertEquals($testName, $this->group->getName());
    }

    public function testRoles()
    {
        $testRoles = ['ROLE_MANAGER', 'ROLE_PLAYER', 'ROLE_ADMIN', 'ROLE_SUPER_ADMIN'];

        $this->assertEmpty($this->group->getRoles());
        $this->group->setRoles($testRoles);
        $this->assertEquals($testRoles, $this->group->getRoles());
    }

    public function testUser()
    {
        $this->assertEmpty($this->group->getUser());
        $this->group->addUser($this->testUser);
        $this->assertEquals($this->testUser, $this->group->getUser()->first());

        $this->group->addUser($this->testUser2);
        $this->assertEquals(2, $this->group->getUser()->count());

        $this->group->removeUser($this->testUser);
        $this->assertEquals(1, $this->group->getUser()->count());
        $this->assertEquals($this->testUser2, $this->group->getUser()->first());
    }
}