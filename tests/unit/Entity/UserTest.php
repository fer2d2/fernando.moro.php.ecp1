<?php

namespace AppBundle\Entity;

class UserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var User
     */
    protected $user;

    protected function setUp()
    {
        $this->user = new User();
    }

    protected function tearDown()
    {

    }

    public function testGetId()
    {
        $this->assertEmpty($this->user->getId());
    }

    public function testUsername()
    {
        $usernameTest = "Jorge";

        $this->assertEmpty($this->user->getUsername());
        $this->user->setUsername($usernameTest);
        $this->assertEquals($usernameTest, $this->user->getUsername());
    }

    public function testEmail()
    {
        $emailTest = "fernando.moro@php.net";

        $this->assertEmpty($this->user->getEmail());
        $this->user->setEmail($emailTest);
        $this->assertEquals($emailTest, $this->user->getEmail());
    }

    public function testEnabled()
    {
        $this->assertEmpty($this->user->getEnabled());
        $this->user->setEnabled(true);
        $this->assertEquals(true, $this->user->getEnabled());
    }

    public function testPassword()
    {
        $passwd = password_hash('WowSoSecretPassword', PASSWORD_DEFAULT);

        $this->assertEmpty($this->user->getPassword());
        $this->user->setPassword($passwd);
        $this->assertEquals($passwd, $this->user->getPassword());
    }

    public function testRoles()
    {
        $testRoles = ['ROLE_MANAGER', 'ROLE_PLAYER', 'ROLE_ADMIN', 'ROLE_SUPER_ADMIN'];

        $this->assertEmpty($this->user->getRoles());
        $this->user->setRoles($testRoles);
        $this->assertEquals($testRoles, $this->user->getRoles());
    }

    public function testGroup()
    {
        $groupTest = new Group("TEST_GROUP");
        $groupTest2 = new Group("TEST_GROUP_2");

        $this->assertEmpty($this->user->getGroup());
        $this->user->addGroup($groupTest);
        $this->assertEquals($groupTest, $this->user->getGroup()->first());

        $this->user->addGroup($groupTest2);
        $this->assertEquals(2, $this->user->getGroup()->count());

        $this->user->removeGroup($groupTest);
        $this->assertEquals(1, $this->user->getGroup()->count());
        $this->assertEquals($groupTest2, $this->user->getGroup()->first());
    }
}