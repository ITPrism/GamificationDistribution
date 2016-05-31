<?php
/**
 * @package         Gamification
 * @subpackage      Goals
 * @author          Todor Iliev
 * @copyright       Copyright (C) 2016 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license         GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Gamification\Goal;

use Prism\Database\Collection;

defined('JPATH_PLATFORM') or die;

/**
 * This class contains methods that are used for managing goals.
 *
 * @package         Gamification
 * @subpackage      Goals
 */
class Goals extends Collection
{
    /**
     * Load units from database.
     *
     * <code>
     * $goals = new Gamification\Goal\Goals(JFactory::getDbo());
     * $goals->load();
     *
     * $options = $goals->toOptions("id", "title");
     * </code>
     *
     * @param array $options  Options that will be used for filtering results.
     */
    public function load(array $options = array())
    {
        $orderColumn    = $this->getOptionOrderColumn($options, 'a.ordering');
        $orderDirection = $this->getOptionOrderDirection($options);

        $ids     = $this->getOptionIds($options);
        $groupId = $this->getOptionId($options, 'group_id');
        $context = !array_key_exists('context', $options) ? null : $options['context'];

        // Create a new query object.
        $query = $this->db->getQuery(true);
        $query
            ->select('a.id, a.title, a.context, a.activity_text, a.description, a.published, a.image, a.group_id, a.params')
            ->from($this->db->quoteName('#__gfy_goals', 'a'))
            ->order($this->db->escape($orderColumn . ' ' . $orderDirection));

        // Filter by unit ID.
        if (count($ids) > 0) {
            $query->where('a.id IN (' . implode(',', $ids) . ')');
        }
        
        // Filter by group ID.
        if ($groupId > 0) {
            $query->where('a.group_id = ' . (int)$groupId);
        }

        // Filter by group ID.
        if ($context !== null and $context !== '') {
            $query->where('a.context = ' . $this->db->quote($context));
        }

        $this->db->setQuery($query);
        $this->items = (array)$this->db->loadAssocList();
    }

    /**
     * Create a currency object and return it.
     *
     * <code>
     * $options = array(
     *     "ids" => array(1,2,3,4,5),
     *     "codes" => array("USD", "GBP")
     * );
     *
     * $goals   = new Crowdfunding\Currencies(\JFactory::getDbo());
     * $goals->load($options);
     *
     * $currencyId = 1;
     * $currency = $goals->getCurrency($currencyId);
     * </code>
     *
     * @param int|string $id Goal ID or Goal context.
     *
     * @return Goal|null
     */
    public function getGoal($id)
    {
        $currency = null;

        foreach ($this->items as $item) {
            if (is_numeric($id) and (int)$id === (int)$item['id']) {
                $currency = new Goal($this->db);
                $currency->bind($this->items[$id]);
                break;

            } elseif (strcmp($id, $item['context']) === 0) {
                $currency = new Goal($this->db);
                $currency->bind($item);
                break;
            }
        }

        return $currency;
    }

    /**
     * Return the goals as array with objects.
     *
     * <code>
     * $options = array(
     *     "ids" => array(1,2,3,4,5),
     *     "codes" => array("USD", "GBP")
     * );
     *
     * $goals   = new Crowdfunding\Currencies(\JFactory::getDbo());
     * $goals->load($options);
     *
     * $goals = $goals->getGoals();
     * </code>
     *
     * @return array
     */
    public function getGoals()
    {
        $results = array();

        $i = 0;
        foreach ($this->items as $item) {
            $goal = new Goal($this->db);
            $goal->bind($item);
            
            $results[$i] = $goal;
            $i++;
        }

        return $results;
    }
}
