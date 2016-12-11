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
 * Test class for Gamification\UnitTest.
 *
 * @package     Gamification\UnitTest
 * @subpackage  Points
 */
class PointsDatabaseTest extends GamificationTestCaseDatabase
{
    /**
     * @var    Points
     */
    protected $object;

    /**
     * Test the getAbbr method.
     *
     * @return  void
     * @covers  Points::getAbbr
     */
    public function testGetAbbr()
    {
        $this->assertEquals(
            'P',
            $this->object->getAbbr()
        );
    }

    /**
     * Test the isPublished method.
     *
     * @return  void
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

        $db = self::$driver;

        // Remove rows.
        $query = $db->getQuery(true);
        $query->delete($db->quoteName('jos_gfy_points'));
        $db->setQuery($query);
        $db->execute();

        // Add rows.
        $sqlData = file_get_contents(GAMIFICATION_TESTS_FOLDER_STUBS_DATABASE.'jos_gfy_points.sql');
        $db->setQuery($sqlData);
        $db->execute();

        $pointsId      = 1;
        $this->object  = new Points(JFactory::getDbo());
        $this->object->load($pointsId);
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
