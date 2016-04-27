<?php
/**
 * @package         Gamification
 * @subpackage      Activities
 * @author          Todor Iliev
 * @copyright       Copyright (C) 2016 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license         GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Gamification\Activity;

use Prism\Database\Collection;

defined('JPATH_PLATFORM') or die;

/**
 * This class contains methods that are used for managing activities.
 *
 * @package         Gamification
 * @subpackage      Activities
 */
class Activities extends Collection
{
    /**
     * Load user activities.
     *
     * <code>
     * $options = array(
     *        "user_id"         => 1,
     *        "limit"           => 10,
     *        "order_column"    => "a.created"
     *        "order_direction" => "DESC"
     * );
     *
     * $activities = new Gamification\Activity\Activities(JFactory::getDbo());
     * $activities->load($options);
     * </code>
     *
     * @param array $options  Options that will be used for filtering results.
     */
    public function load(array $options = array())
    {
        $userId         = $this->getOptionId($options, 'user_id');
        $orderColumn    = $this->getOptionOrderColumn($options, 'a.created');
        $orderDirection = $this->getOptionOrderDirection($options);
        $limit          = $this->getOptionLimit($options);

        // Create a new query object.
        $query = $this->db->getQuery(true);
        $query
            ->select(
                'a.title, a.content, a.image, a.url, a.created, a.user_id, ' .
                'b.name'
            )
            ->from($this->db->quoteName('#__gfy_activities', 'a'))
            ->innerJoin($this->db->quoteName('#__users', 'b') . ' ON a.user_id = b.id');

        if ($userId > 0) {
            $query->where('a.user_id = ' . (int)$userId);
        }

        $query->order($this->db->quoteName($orderColumn) . $orderDirection);

        $this->db->setQuery($query, 0, $limit);
        $this->items = (array)$this->db->loadAssocList();
    }
}
