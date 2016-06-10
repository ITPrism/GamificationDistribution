<?php
/**
 * @package         Gamification
 * @subpackage      Achievements
 * @author          Todor Iliev
 * @copyright       Copyright (C) 2016 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license         GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Gamification\Achievement;

use Prism\Database\Table;

defined('JPATH_PLATFORM') or die;

/**
 * This class contains methods that are used for managing a goal.
 *
 * @package         Gamification
 * @subpackage      Achievements
 */
class Achievement extends Table
{
    /**
     * Achievement ID.
     *
     * @var int
     */
    protected $id;

    protected $title;
    protected $description;
    protected $note;
    protected $image;
    protected $activity_text;
    protected $published;
    protected $group_id;

    /**
     * Get goal title.
     *
     * <code>
     * $goalId    = 1;
     * $goal      = new Gamification\Achievement\Achievement(\JFactory::getDbo());
     * $title     = $goal->getTitle();
     * </code>
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Get goal image.
     *
     * <code>
     * $goalId    = 1;
     * $goal      = new Gamification\Achievement\Achievement(\JFactory::getDbo());
     * $image     = $goal->getImage();
     * </code>
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Get goal note.
     *
     * <code>
     * $goalId    = 1;
     * $goal      = new Gamification\Achievement\Achievement(\JFactory::getDbo());
     * $note      = $goal->getNote();
     * </code>
     *
     * @return string
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Return goal description with possibility
     * to replace placeholders with dynamically generated data.
     *
     * <code>
     * $goalId    = 1;
     * $goal      = new Gamification\Achievement\Achievement(\JFactory::getDbo());
     *
     * $data = array(
     *     "name" => "John Dow",
     *     "title" => "..."
     * );
     *
     * echo $goal->getDescription($data);
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
     * Check for published goal.
     *
     * <code>
     * $goalId     = 1;
     * $goal       = new Gamification\Achievement\Achievement(\JFactory::getDbo());
     *
     * if(!$goal->isPublished()) {
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
     * Get the group ID of the goal.
     *
     * <code>
     * $goalId    = 1;
     *
     * $goal      = new Gamification\Achievement\Achievement(\JFactory::getDbo());
     * $goal->load($goalId);
     *
     * $groupId    = $goal->getGroupId();
     * </code>
     *
     * @return integer
     */
    public function getGroupId()
    {
        return $this->group_id;
    }

    /**
     * Return the activity text with possibility
     * to replace placeholders with dynamically generated data.
     *
     * <code>
     * $goalId    = 1;
     * $goal      = new Gamification\Achievement\Achievement(\JFactory::getDbo());
     *
     * $data = array(
     *     "name" => "John Dow",
     *     "title" => "..."
     * );
     *
     * echo $goal->getActivityText($data);
     * </code>
     *
     * @param array $data
     * @return string
     */
    public function getActivityText(array $data = array())
    {
        if (count($data) > 0) {
            $result = $this->activity_text;

            foreach ($data as $placeholder => $value) {
                $placeholder = '{'.strtoupper($placeholder).'}';
                $result = str_replace($placeholder, $value, $result);
            }

            return $result;

        } else {
            return $this->activity_text;
        }
    }

    /**
     * Load goal data from database.
     *
     * <code>
     * $keys = array(
     *    "id" => 1,
     *    "points_id" => 2
     * );
     *
     * $goal      = new Gamification\Achievement\Achievement(\JFactory::getDbo());
     * $goal->load($keys);
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
            ->select('a.id, a.title, a.description, a.activity_text, a.image, a.published, a.params, a.group_id')
            ->from($this->db->quoteName('#__gfy_goals', 'a'));

        // Prepare keys.
        if (is_array($keys)) {
            foreach ($keys as $column => $value) {
                $query->where($this->db->quoteName('a.'.$column) . '=' . $this->db->quote($value));
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
     *        "image"    => "picture.png",
     *        "note"    => null,
     *        "published" => 1,
     *        "group_id"  => 3
     * );
     *
     * $goal   = new Gamification\Achievement\Achievement(\JFactory::getDbo());
     * $goal->bind($data);
     * $goal->store();
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
        $note         = (!$this->note) ? null : $this->db->quote($this->note);
        $description  = (!$this->description) ? null : $this->db->quote($this->description);
        $activityText = (!$this->activity_text) ? null : $this->db->quote($this->activity_text);

        // Create a new query object.
        $query = $this->db->getQuery(true);

        $query
            ->update($this->db->quoteName('#__gfy_goals'))
            ->set($this->db->quoteName('title') . '=' . $this->db->quote($this->title))
            ->set($this->db->quoteName('image') . '=' . $this->db->quote($this->image))
            ->set($this->db->quoteName('note') . '=' . $note)
            ->set($this->db->quoteName('activity_text') . '=' . $activityText)
            ->set($this->db->quoteName('description') . '=' . $description)
            ->set($this->db->quoteName('published') . '=' . (int)$this->published)
            ->set($this->db->quoteName('group_id') . '=' . (int)$this->group_id)
            ->where($this->db->quoteName('id') . '=' . (int)$this->id);

        $this->db->setQuery($query);
        $this->db->execute();
    }

    protected function insertObject()
    {
        // Create a new query object.
        $query = $this->db->getQuery(true);

        $query
            ->insert($this->db->quoteName('#__gfy_goals'))
            ->set($this->db->quoteName('title') . '  = ' . $this->db->quote($this->title))
            ->set($this->db->quoteName('image') . '  = ' . $this->db->quote($this->image))
            ->set($this->db->quoteName('published') . '  = ' . (int)$this->published)
            ->set($this->db->quoteName('group_id') . '  = ' . (int)$this->group_id);

        if ($this->note !== null and $this->note !== '') {
            $query->set($this->db->quoteName('note') . ' = ' . $this->db->quote($this->note));
        }

        if ($this->description !== null and $this->description !== '') {
            $query->set($this->db->quoteName('description') . ' = ' . $this->db->quote($this->description));
        }

        if ($this->activity_text !== null and $this->activity_text !== '') {
            $query->set($this->db->quoteName('activity_text') . ' = ' . $this->db->quote($this->activity_text));
        }

        $this->db->setQuery($query);
        $this->db->execute();

        return $this->db->insertid();
    }
}
