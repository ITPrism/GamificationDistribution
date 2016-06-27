<?php
/**
 * @package         Gamification
 * @subpackage      Badges
 * @author          Todor Iliev
 * @copyright       Copyright (C) 2016 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license         GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Gamification\Badge;

use Prism\Database\Collection;

defined('JPATH_PLATFORM') or die;

/**
 * This class contains methods that are used for managing badges.
 *
 * @package         Gamification
 * @subpackage      Badges
 */
class Badges extends Collection
{
    /**
     * Load items from database.
     *
     * <code>
     * $badges = new Gamification\Badge\Badges(JFactory::getDbo());
     * $badges->load();
     *
     * $options = $badges->toOptions("id", "title");
     * </code>
     *
     * @param array $options  Options that will be used for filtering results.
     */
    public function load(array $options = array())
    {
        // Create a new query object.
        $query = $this->db->getQuery(true);
        $query
            ->select('a.id, a.title, a.group_id, b.name AS group_name')
            ->from($this->db->quoteName('#__gfy_badges', 'a'))
            ->leftJoin($this->db->quoteName('#__gfy_groups', 'b') . ' ON a.group_id = b.id')
            ->order('b.name ASC, a.title ASC');

        $this->db->setQuery($query);
        $this->items = (array)$this->db->loadAssocList();
    }
}
