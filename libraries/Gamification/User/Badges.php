<?php
/**
 * @package         Gamification\User
 * @subpackage      Badges
 * @author          Todor Iliev
 * @copyright       Copyright (C) 2016 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license         GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Gamification\User;

use Joomla\Utilities\ArrayHelper;
use Prism\Database\Collection;

defined('JPATH_PLATFORM') or die;

/**
 * This class contains methods that are used for managing user badges.
 *
 * @package         Gamification\User
 * @subpackage      Badges
 */
class Badges extends Collection
{
    /**
     * User ID.
     *
     * @var int
     */
    protected $userId;

    /**
     * Group ID.
     *
     * @var int
     */
    protected $groupId;

    /**
     * Load all user badges and set them to group index.
     * Every user can have only one badge for a group.
     *
     * <code>
     * $options = array(
     *       'user_id'  => 1,
     *       'group_id' => 2
     * );
     *
     * $userBadges     = new Gamification\User\Badges(\JFactory::getDbo())
     * $userBadges->load($options);
     * </code>
     *
     * @param array $options
     */
    public function load(array $options = array())
    {
        $userId  = $this->getOptionId($options, 'user_id');
        $groupId = $this->getOptionId($options, 'group_id');

        // Create a new query object.
        $query = $this->db->getQuery(true);
        $query
            ->select(
                'a.id, a.badge_id, a.user_id, a.group_id, ' .
                'b.title, b.description, b.points, b.image, b.published, b.points_id, b.group_id'
            )
            ->from($this->db->quoteName('#__gfy_userbadges', 'a'))
            ->innerJoin($this->db->quoteName('#__gfy_badges', 'b') . ' ON a.badge_id = b.id')
            ->where('a.user_id = ' . (int)$userId);

        if ($groupId > 0) {
            $query->where('a.group_id = ' . (int)$groupId);
        }

        $this->db->setQuery($query);
        $results = (array)$this->db->loadAssocList();

        if (count($results) > 0) {

            $this->userId = $userId;

            if ($groupId > 0) {
                $this->groupId = $groupId;
            }

            foreach ($results as $result) {
                $badge = new Badge(\JFactory::getDbo());
                $badge->bind($result);

                $this->items[$result['group_id']][$result['badge_id']] = $badge;
            }
        }
    }

    /**
     * Return user badges. They can be obtained by group ID.
     *
     * <code>
     * $keys = array(
     *       'user_id'  => 1,
     *       'group_id' => 2
     * );
     *
     * $userBadges  = new GamificationUserBadges(\JFactory::getDbo());
     * $userBadges->load($options);
     *
     * $badges      = $userBadges->getBadges();
     * </code>
     *
     * @param  $groupId
     *
     * @return array
     */
    public function getBadges($groupId = 0)
    {
        return ($groupId > 0 and array_key_exists($groupId, $this->items)) ? (array)$this->items[$groupId] : (array)$this->items;
    }

    /**
     * Get badge by badge ID and group ID.
     *
     * <code>
     * $keys = array(
     *       'user_id'  => 1,
     *       'group_id' => 2
     * );
     *
     * $badgeId     = 1;
     *
     * $userBadges  = new GamificationUserBadges(\JFactory::getDbo());
     * $userBadges->load($options);
     *
     * $badge       = $userBadges->getBadge($badgeId);
     * </code>
     *
     * @param int $badgeId
     * @param int $groupId
     *
     * @return null|Badge
     */
    public function getBadge($badgeId, $groupId = 0)
    {
        $item = null;

        if ($groupId > 0) { // Get an item from a specific group
            $item = (!array_key_exists($groupId, $this->items)) ? null : ArrayHelper::getValue($this->items[$groupId], $badgeId);
        } else { // Look in all groups
            foreach ($this->items as $group) {
                $item = ArrayHelper::getValue($group, $badgeId);
                if ($item !== null and ($item instanceof Badge) and $item->getId()) {
                    break;
                } else {
                    $item = null;
                }
            }
        }

        return $item;
    }
}
