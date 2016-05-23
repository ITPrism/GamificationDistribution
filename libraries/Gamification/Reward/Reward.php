<?php
/**
 * @package         Gamification
 * @subpackage      Rewards
 * @author          Todor Iliev
 * @copyright       Copyright (C) 2016 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license         GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Gamification\Reward;

use Prism\Database\Table;
use Gamification\Mechanic;

defined('JPATH_PLATFORM') or die;

/**
 * This class contains methods that are used for managing a reward.
 *
 * @package         Gamification
 * @subpackage      Rewards
 */
class Reward extends Table implements Mechanic\PointsInterface
{
    /**
     * Reward ID.
     *
     * @var integer
     */
    protected $id;

    protected $title;
    protected $description;
    protected $points;
    protected $image;
    protected $note;
    protected $number;
    protected $published;
    protected $points_id;
    protected $group_id;

    protected static $instances = array();

    /**
     * Create an instance of the object and load data.
     *
     * <code>
     * $rewardId = 1;
     * $reward   = Gamification\Reward\Reward::getInstance(\JFactory::getDbo(), $rewardId);
     * </code>
     *
     * @param \JDatabaseDriver $db
     * @param int $id
     *
     * @return null|self
     */
    public static function getInstance($db, $id)
    {
        if (!array_key_exists($id, self::$instances)) {
            $item   = new Reward($db);
            $item->load($id);
            
            self::$instances[$id] = $item;
        }

        return self::$instances[$id];
    }

    /**
     * Get reward title.
     *
     * <code>
     * $rewardId    = 1;
     * $reward      = new Gamification\Reward\Reward(\JFactory::getDbo());
     * $title      = $reward->getTitle();
     * </code>
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Get reward points.
     *
     * <code>
     * $rewardId    = 1;
     * $reward      = new Gamification\Reward\Reward(\JFactory::getDbo());
     * $reward->load($rewardId);
     *
     * $points     = $reward->getPoints();
     * </code>
     *
     * @return number
     */
    public function getPoints()
    {
        return $this->points;
    }

    /**
     * Get the points ID used for the reward.
     *
     * <code>
     * $rewardId    = 1;
     *
     * $reward      = new Gamification\Reward\Reward(\JFactory::getDbo());
     * $reward->load($rewardId);
     *
     * $pointsId   = $reward->getPointsId();
     * </code>
     *
     * @return int
     */
    public function getPointsId()
    {
        return (int)$this->points_id;
    }

    /**
     * Get reward image.
     *
     * <code>
     * $rewardId    = 1;
     * $reward      = new Gamification\Reward\Reward(\JFactory::getDbo());
     * $image      = $reward->getImage();
     * </code>
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Get reward note.
     *
     * <code>
     * $rewardId    = 1;
     * $reward      = new Gamification\Reward\Reward(\JFactory::getDbo());
     * $note       = $reward->getNote();
     * </code>
     *
     * @return string
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Get reward number.
     *
     * <code>
     * $rewardId    = 1;
     * $reward      = new Gamification\Reward\Reward(\JFactory::getDbo());
     * $number      = $reward->getNumber();
     * </code>
     *
     * @return int
     */
    public function getNumber()
    {
        return (int)$this->number;
    }

    /**
     * Return reward description with possibility
     * to replace placeholders with dynamically generated data.
     *
     * <code>
     * $rewardId    = 1;
     * $reward      = new Gamification\Reward\Reward(\JFactory::getDbo());
     *
     * $data = array(
     *     "name" => "John Dow",
     *     "title" => "..."
     * );
     *
     * echo $reward->getDescription($data);
     * </code>
     *
     * @param array $data
     * @return string
     */
    public function getDescription(array $data = array())
    {
        if (count($data) > 0) {
            $result = $this->description;

            foreach ($data as $placeholder => $value) {
                $placeholder = '{'.strtoupper($placeholder).'}';
                $result = str_replace($placeholder, $value, $result);
            }

            return $result;

        } else {
            return $this->description;
        }
    }

    /**
     * Check for published reward.
     *
     * <code>
     * $rewardId     = 1;
     * $reward       = new Gamification\Reward\Reward(\JFactory::getDbo());
     *
     * if(!$reward->isPublished()) {
     * ...
     * }
     * </code>
     *
     * @return boolean
     */
    public function isPublished()
    {
        return (!$this->published) ? false : true;
    }

    /**
     * Get the group ID of the reward.
     *
     * <code>
     * $rewardId    = 1;
     *
     * $reward      = new Gamification\Reward\Reward(\JFactory::getDbo());
     * $reward->load($rewardId);
     *
     * $groupId    = $reward->getGroupId();
     * </code>
     *
     * @return integer
     */
    public function getGroupId()
    {
        return $this->group_id;
    }

    /**
     * Load reward data from database.
     *
     * <code>
     * $keys = array(
     *    "group_id" => 1,
     *    "points_id" => 2
     * );
     *
     * $reward      = new Gamification\Reward\Reward(\JFactory::getDbo());
     * $reward->load($keys);
     * </code>
     *
     * @param int|array $keys
     * @param array $options
     */
    public function load($keys, array $options = array())
    {
        // Create a new query object.
        $query = $this->db->getQuery(true);

        $query
            ->select('a.id, a.title, a.description, a.points, a.image, a.note, a.number, a.published, a.points_id, a.group_id')
            ->from($this->db->quoteName('#__gfy_rewards', 'a'));

        // Prepare keys.
        if (is_array($keys)) {
            foreach ($keys as $column => $value) {
                $query->where($this->db->quoteName('a.'.$column) . ' = ' . $this->db->quote($value));
            }
        } else {
            $query->where('a.id = ' . (int)$keys);
        }

        $this->db->setQuery($query);
        $result = (array)$this->db->loadAssoc();

        $this->bind($result);
    }

    /**
     * Save the data to the database.
     *
     * <code>
     * $data = array(
     *        "title"    => "......",
     *        "description"    => "......",
     *        "points"    => 100,
     *        "image"    => "picture.png",
     *        "note"    => null,
     *        "number"    => 10,
     *        "published" => 1,
     *        "points_id" => 2,
     *        "group_id"  => 3
     * );
     *
     * $reward   = new Gamification\Reward\Reward(\JFactory::getDbo());
     * $reward->bind($data);
     * $reward->store();
     * </code>
     */
    public function store()
    {
        if (!$this->id) {
            $this->id = $this->insertObject();
        } else {
            $this->updateObject();
        }
    }

    protected function updateObject()
    {
        $note = (!$this->note) ? null : $this->db->quote($this->note);
        $description = (!$this->description) ? null : $this->db->quote($this->description);

        // Create a new query object.
        $query = $this->db->getQuery(true);

        $query
            ->update($this->db->quoteName('#__gfy_rewards'))
            ->set($this->db->quoteName('title') . '  = ' . $this->db->quote($this->title))
            ->set($this->db->quoteName('points') . '  = ' . $this->db->quote($this->points))
            ->set($this->db->quoteName('image') . '  = ' . $this->db->quote($this->image))
            ->set($this->db->quoteName('note') . '  = ' . $note)
            ->set($this->db->quoteName('number') . '  = ' . (int)$this->number)
            ->set($this->db->quoteName('description') . '  = ' . $description)
            ->set($this->db->quoteName('published') . '  = ' . (int)$this->published)
            ->set($this->db->quoteName('points_id') . '  = ' . (int)$this->points_id)
            ->set($this->db->quoteName('group_id') . '  = ' . (int)$this->group_id)
            ->where($this->db->quoteName('id') . '  = ' . (int)$this->id);

        $this->db->setQuery($query);
        $this->db->execute();
    }

    protected function insertObject()
    {
        // Create a new query object.
        $query = $this->db->getQuery(true);

        $query
            ->insert($this->db->quoteName('#__gfy_rewards'))
            ->set($this->db->quoteName('title') . '  = ' . $this->db->quote($this->title))
            ->set($this->db->quoteName('points') . '  = ' . $this->db->quote($this->points))
            ->set($this->db->quoteName('image') . '  = ' . $this->db->quote($this->image))
            ->set($this->db->quoteName('number') . '  = ' . (int)$this->number)
            ->set($this->db->quoteName('published') . '  = ' . (int)$this->published)
            ->set($this->db->quoteName('points_id') . '  = ' . (int)$this->points_id)
            ->set($this->db->quoteName('group_id') . '  = ' . (int)$this->group_id);

        if ($this->note !== null and $this->note !== '') {
            $query->set($this->db->quoteName('note') . ' = ' . $this->db->quote($this->note));
        }

        if ($this->description !== null and $this->description !== '') {
            $query->set($this->db->quoteName('description') . ' = ' . $this->db->quote($this->description));
        }

        $this->db->setQuery($query);
        $this->db->execute();

        return $this->db->insertid();
    }
}
