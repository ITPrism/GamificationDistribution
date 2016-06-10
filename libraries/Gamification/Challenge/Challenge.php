<?php
/**
 * @package         Gamification
 * @subpackage      Challenges
 * @author          Todor Iliev
 * @copyright       Copyright (C) 2016 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license         GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Gamification\Challenge;

use Prism\Database\Table;

defined('JPATH_PLATFORM') or die;

/**
 * This class contains methods that are used for managing a achievement.
 *
 * @package         Gamification
 * @subpackage      Challenges
 */
class Challenge extends Table
{
    /**
     * Challenge ID.
     *
     * @var int
     */
    protected $id;

    protected $title;
    protected $description;
    protected $image;
    protected $note;
    protected $published;
    protected $group_id;

    /**
     * Get achievement title.
     *
     * <code>
     * $achievementId    = 1;
     * $achievement      = new Gamification\Challenge\Challenge(\JFactory::getDbo());
     * $title       = $achievement->getTitle();
     * </code>
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Get achievement image.
     *
     * <code>
     * $achievementId    = 1;
     * $achievement      = new Gamification\Challenge\Challenge(\JFactory::getDbo());
     * $image       = $achievement->getImage();
     * </code>
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Get achievement note.
     *
     * <code>
     * $achievementId    = 1;
     * $achievement      = new Gamification\Challenge\Challenge(\JFactory::getDbo());
     * $note       = $achievement->getNote();
     * </code>
     *
     * @return string
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Return achievement description with possibility
     * to replace placeholders with dynamically generated data.
     *
     * <code>
     * $achievementId    = 1;
     * $achievement      = new Gamification\Challenge\Challenge(\JFactory::getDbo());
     *
     * $data = array(
     *     "name" => "John Dow",
     *     "title" => "..."
     * );
     *
     * echo $achievement->getDescription($data);
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
     * Check for published achievement.
     *
     * <code>
     * $achievementId     = 1;
     * $achievement       = new Gamification\Challenge\Challenge(\JFactory::getDbo());
     *
     * if(!$achievement->isPublished()) {
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
     * Get the group ID of the achievement.
     *
     * <code>
     * $achievementId    = 1;
     *
     * $achievement      = new Gamification\Challenge\Challenge(\JFactory::getDbo());
     * $achievement->load($achievementId);
     *
     * $groupId    = $achievement->getGroupId();
     * </code>
     *
     * @return integer
     */
    public function getGroupId()
    {
        return $this->group_id;
    }

    /**
     * Load achievement data from database.
     *
     * <code>
     * $keys = array(
     *    "id" => 1,
     *    "group_id" => 2
     * );
     *
     * $achievement      = new Gamification\Challenge\Challenge(\JFactory::getDbo());
     * $achievement->load($keys);
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
            ->select('a.id, a.title, a.description, a.image, a.note, a.published, a.group_id')
            ->from($this->db->quoteName('#__gfy_challenges', 'a'));

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
     *        "image"    => "picture.png",
     *        "note"    => null,
     *        "published" => 1,
     *        "group_id"  => 3
     * );
     *
     * $achievement   = new Gamification\Challenge\Challenge(\JFactory::getDbo());
     * $achievement->bind($data);
     * $achievement->store();
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
        $note        = (!$this->note) ? null : $this->db->quote($this->note);
        $description = (!$this->description) ? null : $this->db->quote($this->description);

        // Create a new query object.
        $query = $this->db->getQuery(true);

        $query
            ->update($this->db->quoteName('#__gfy_challenges'))
            ->set($this->db->quoteName('title') . '  = ' . $this->db->quote($this->title))
            ->set($this->db->quoteName('image') . '  = ' . $this->db->quote($this->image))
            ->set($this->db->quoteName('note') . '  = ' . $note)
            ->set($this->db->quoteName('description') . '  = ' . $description)
            ->set($this->db->quoteName('published') . '  = ' . (int)$this->published)
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
            ->insert($this->db->quoteName('#__gfy_challenges'))
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

        $this->db->setQuery($query);
        $this->db->execute();

        return $this->db->insertid();
    }
}
