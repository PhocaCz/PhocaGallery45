<?php
/*
 * @package		Joomla.Framework
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 *
 * @component Phoca Component
 * @copyright Copyright (C) Jan Pavelka www.phoca.cz
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License version 2 or later;
 */

defined('_JEXEC') or die();
use Joomla\CMS\MVC\Model\ListModel;
use Joomla\CMS\Factory;
use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\Application\ApplicationHelper;
jimport('joomla.application.component.modellist');

class PhocaGalleryCpModelPhocaGalleryRa extends ListModel
{
	protected	$option 		= 'com_phocagallery';

	public function __construct($config = array())
	{
		if (empty($config['filter_fields'])) {
			$config['filter_fields'] = array(
				'id', 'a.id',
				'title', 'a.title',
				'username','ua.username',
				'date', 'a.date',
				'alias', 'a.alias',
				'checked_out', 'a.checked_out',
				'checked_out_time', 'a.checked_out_time',
				'category_id', 'category_id',
				'state', 'a.state',
				'ordering', 'a.ordering',
				'language', 'a.language',
				'hits', 'a.hits',
				'published','a.published',
				'rating', 'a.rating',
				'category_title', 'category_title'
			);
		}

		parent::__construct($config);
	}

	protected function populateState($ordering = 'ua.username', $direction = 'ASC')
	{
		// Initialise variables.
		$app = Factory::getApplication('administrator');

		// Load the filter state.
		$search = $app->getUserStateFromRequest($this->context.'.filter.search', 'filter_search');
		$this->setState('filter.search', $search);
/*
		$accessId = $app->getUserStateFromRequest($this->context.'.filter.access', 'filter_access', null, 'int');
		$this->setState('filter.access', $accessId);

		$state = $app->getUserStateFromRequest($this->context.'.filter.published', 'filter_published', '', 'string');
		$this->setState('filter.published', $state);
*/
		$categoryId = $app->getUserStateFromRequest($this->context.'.filter.category_id', 'filter_category_id', null);
		$this->setState('filter.category_id', $categoryId);
/*
		$language = $app->getUserStateFromRequest($this->context.'.filter.language', 'filter_language', '');
		$this->setState('filter.language', $language);
*/
		// Load the parameters.
		$params = ComponentHelper::getParams('com_phocagallery');
		$this->setState('params', $params);

		// List state information.
		parent::populateState($ordering, $direction);
	}

	protected function getStoreId($id = '')
	{
		// Compile the store id.
		$id	.= ':'.$this->getState('filter.search');
		//$id	.= ':'.$this->getState('filter.access');
		//$id	.= ':'.$this->getState('filter.published');
		$id	.= ':'.$this->getState('filter.category_id');

		return parent::getStoreId($id);
	}

	protected function getListQuery()
	{
		/*
		$query = ' SELECT a.*, cc.title AS category, ua.name AS editor, u.id AS ratinguserid, u.username AS ratingusername '
			. ' FROM #__phocagallery_votes AS a '
			. ' LEFT JOIN #__phocagallery_categories AS cc ON cc.id = a.catid '
			. ' LEFT JOIN #__users AS ua ON ua.id = a.checked_out '
			. ' LEFT JOIN #__users AS u ON u.id = a.userid'
			. $where
			. ' GROUP by a.id'
			. $orderby
		;
		*/

		// Create a new query object.
		$db		= $this->getDbo();
		$query	= $db->getQuery(true);

		// Select the required fields from the table.
		$query->select(
			$this->getState(
				'list.select',
				'a.*'
			)
		);
		$query->from('`#__phocagallery_votes` AS a');

		// Join over the language
		$query->select('l.title AS language_title');
		$query->join('LEFT', '`#__languages` AS l ON l.lang_code = a.language');

		// Join over the users for the checked out user.
		$query->select('ua.id AS ratinguserid, ua.username AS ratingusername, ua.name AS ratingname');
		$query->join('LEFT', '#__users AS ua ON ua.id=a.userid');

		$query->select('uc.name AS editor');
		$query->join('LEFT', '#__users AS uc ON uc.id=a.checked_out');

/*		// Join over the asset groups.
		$query->select('ag.title AS access_level');
		$query->join('LEFT', '#__viewlevels AS ag ON ag.id = a.access');
*/
		// Join over the categories.
		$query->select('c.title AS category_title, c.id AS category_id');
		$query->join('LEFT', '#__phocagallery_categories AS c ON c.id = a.catid');

		// Filter by access level.
	/*	if ($access = $this->getState('filter.access')) {
			$query->where('a.access = '.(int) $access);
		}*/

		// Filter by published state.
		$published = $this->getState('filter.published');
		if (is_numeric($published)) {
			$query->where('a.published = '.(int) $published);
		}
		else if ($published === '') {
			$query->where('(a.published IN (0, 1))');
		}

		// Filter by category.
		$categoryId = $this->getState('filter.category_id');
		if (is_numeric($categoryId)) {
			$query->where('a.catid = ' . (int) $categoryId);
		}

		// Filter by search in title
		$search = $this->getState('filter.search');
		if (!empty($search))
		{
			if (stripos($search, 'id:') === 0) {
				$query->where('a.id = '.(int) substr($search, 3));
			}
			else
			{
				$search = $db->Quote('%'.$db->escape($search, true).'%');
				$query->where('( ua.name LIKE '.$search.' OR ua.username LIKE '.$search.')');
			}
		}

		//$query->group('a.id');

		// Add the list ordering clause.
		$orderCol	= $this->state->get('list.ordering');
		$orderDirn	= $this->state->get('list.direction');
		if ($orderCol == 'a.ordering' || $orderCol == 'category_title') {
			$orderCol = 'category_title '.$orderDirn.', a.ordering';
		}
		$query->order($db->escape($orderCol.' '.$orderDirn));

		//echo nl2br(str_replace('#__','jos_',$query));
		return $query;
	}

	function delete($cid = array()) {


		if (count( $cid )) {
			\Joomla\Utilities\ArrayHelper::toInteger($cid);
			$cids = implode( ',', $cid );

			//Select affected catids
			$query = 'SELECT v.catid AS catid'
				. ' FROM #__phocagallery_votes AS v'
				. ' WHERE v.id IN ( '.$cids.' )';
			$catids = $this->_getList($query);

			//Delete it from DB
			$query = 'DELETE FROM #__phocagallery_votes'
				. ' WHERE id IN ( '.$cids.' )';
			$this->_db->setQuery( $query );
			$this->_db->execute();
			/*
			if(!$this->_db->query()) {
				$this->setError($this->_db->getErrorMsg());
				return false;
			}*/
			phocagalleryimport('phocagallery.rate.ratecategory');
			foreach ($catids as $valueCatid) {
				$updated = PhocaGalleryRateCategory::updateVoteStatistics( $valueCatid->catid );
				if(!$updated) {
					return false;
				}
			}
		}
		return true;
	}

	protected function prepareTable($table)
	{
		jimport('joomla.filter.output');
		$date = Factory::getDate();
		$user = Factory::getUser();

		$table->title		= htmlspecialchars_decode($table->title, ENT_QUOTES);
		$table->alias		=ApplicationHelper::stringURLSafe($table->alias);

		if (empty($table->alias)) {
			$table->alias =ApplicationHelper::stringURLSafe($table->title);
		}

		if (empty($table->id)) {
			// Set the values
			//$table->created	= $date->toSql();

			// Set ordering to the last item if not set
			if (empty($table->ordering)) {
				$db = Factory::getDbo();
				$db->setQuery('SELECT MAX(ordering) FROM #__phocagallery_votes WHERE catid = '.(int) $table->catid);
				$max = $db->loadResult();

				$table->ordering = $max+1;
			}
		}
		else {
			// Set the values
			//$table->modified	= $date->toSql();
			//$table->modified_by	= $user->get('id');
		}
	}

}
?>
