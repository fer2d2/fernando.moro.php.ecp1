<?php

namespace AppBundle\Entity;

class ReservationTest extends \PHPUnit_Framework_TestCase
{
    private $datetime;
    private $court;
    private $user;

    /**
     * @var Reservation
     */
    protected $reservation;

    protected function setUp()
    {
        $this->reservation = new Reservation();
        $this->datetime = new \DateTime();
        $this->court = new Court();
        $this->user = new User();
    }

    protected function tearDown()
    {

    }

    public function testGetId()
    {
        $this->assertEmpty($this->reservation->getId());
    }

    public function testDatetime()
    {
        $this->assertEmpty($this->reservation->getDatetime());
        $this->reservation->setDatetime($this->datetime);
        $this->assertEquals($this->datetime, $this->reservation->getDatetime());
    }

    public function testCourt()
    {
        $this->assertEmpty($this->reservation->getCourt());
        $this->reservation->setCourt($this->court);
        $this->assertEquals($this->court, $this->reservation->getCourt());
    }

    public function testUser()
    {
        $this->assertEmpty($this->reservation->getUser());
        $this->reservation->setUser($this->user);
        $this->assertEquals($this->user, $this->reservation->getUser());
    }
}