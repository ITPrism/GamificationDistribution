<?php
/**
 * @package     Gamification\UnitTest
 * @subpackage  Points
 * @author      Todor Iliev
 * @copyright   Copyright (C) 2016 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license     GNU General Public License version 3 or later; see LICENSE.txt
 */

use Gamification\Points\Points;

/**
 * Test class for Gamification\Points.
 *
 * @package     Gamification\UnitTest
 * @subpackage  Points
 */
class PointsTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var    Points
     */
    protected $object;

    /**
     * Test the getTitle method.
     *
     * @return  void
     * @covers  Points::getTitle
     */
    public function testGetTitle()
    {
        $this->assertEquals(
            'Gold',
            $this->object->getTitle()
        );
    }

    /**
     * Test the getAbbr method.
     *
     * @return  void
     *
     * @covers  Points::getAbbr
     */
    public function testGetAbbr()
    {
        $this->assertEquals(
            'GOLD',
            $this->object->getAbbr()
        );
    }

    /**
     * Test the getNote method.
     *
     * @return  void
     *
     * @covers  Points::getNote
     */
    public function testGetNote()
    {
        $this->assertEquals(
            'Gold Coins',
            $this->object->getNote()
        );
    }

    /**
     * Test the getGroupId method.
     *
     * @return  void
     *
     * @covers  Points::getGroupId
     */
    public function testGetGroupId()
    {
        $this->assertEquals(
            1,
            $this->object->getGroupId()
        );
    }

    /**
     * Test the isPublished method.
     *
     * @return  void
     *
     * @covers  Points::isPublished
     */
    public function testIsPublished()
    {
        $this->assertTrue($this->object->isPublished());
    }

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     *
     * @return  void
     */
    protected function setUp()
    {
        parent::setUp();

        $data = array(
            'title' => 'Gold',
            'abbr'  => 'GOLD',
            'note'  => 'Gold Coins',
            'group_id'  => 1,
            'published' => 1
        );

        $this->object = new Points();
        $this->object->bind($data);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     *
     * @return void
     *
     * @see     PHPUnit_Framework_TestCase::tearDown()
     */
    protected function tearDown()
    {
        unset($this->object);
        parent::tearDown();
    }
}
