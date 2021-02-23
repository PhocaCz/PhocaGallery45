<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_newsfeeds
 *
 * @copyright   Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;


class PhocagalleryRouter extends JComponentRouterView
{
	protected $noIDs = false;

	/**
	 * Newsfeeds Component router constructor
	 *
	 * @param   JApplicationCms  $app   The application object
	 * @param   JMenu            $menu  The menu object to work with
	 */
	public function __construct($app = null, $menu = null)
	{
		$params = JComponentHelper::getParams('com_phcagallery');
		$this->noIDs = (bool) $params->get('sef_ids');

		$categories = new JComponentRouterViewconfiguration('categories');
		$this->registerView($categories);

		$category = new JComponentRouterViewconfiguration('category');
		$category->setKey('id')->setParent($categories);
		$this->registerView($category);

		$detail = new JComponentRouterViewconfiguration('detail');
		$detail->setKey('id')->setParent($category, 'catid');
		$this->registerView($detail);

		parent::__construct($app, $menu);




		$this->attachRule(new JComponentRouterRulesMenu($this));

		if ($params->get('sef_advanced', 0))
		{
			$this->attachRule(new JComponentRouterRulesStandard($this));
			$this->attachRule(new JComponentRouterRulesNomenu($this));
		}
		else
		{
			JLoader::register('PhocagalleryRouterRulesLegacy', __DIR__ . '/helpers/legacyrouter.php');
			$this->attachRule(new PhocagalleryRouterRulesLegacy($this));
		}
	}

	/*public function getCategorySegment($id, $query)
	{
		$category = JCategories::getInstance($this->getName())->get($id);

		if ($category)
		{
			$path = array_reverse($category->getPath(), true);
			$path[0] = '1:root';

			if ($this->noIDs)
			{
				foreach ($path as &$segment)
				{
					list($id, $segment) = explode(':', $segment, 2);
				}
			}

			return $path;
		}

		return array();
	}*/

/*
	public function getCategoriesSegment($id, $query)
	{
		return $this->getCategorySegment($id, $query);
	}


	public function getCategorySegment($id, $query)
	{
		if (!strpos($id, ':'))
		{
			$db = JFactory::getDbo();
			$dbquery = $db->getQuery(true);
			$dbquery->select($dbquery->qn('alias'))
				->from($dbquery->qn('#__newsfeeds'))
				->where('id = ' . $dbquery->q((int) $id));
			$db->setQuery($dbquery);

			$id .= ':' . $db->loadResult();
		}

		if ($this->noIDs)
		{
			list($void, $segment) = explode(':', $id, 2);

			return array($void => $segment);
		}

		return array((int) $id => $id);
	}


	public function getCategoryId($segment, $query)
	{
		if (isset($query['id']))
		{
			$category = JCategories::getInstance($this->getName(), array('access' => false))->get($query['id']);

			if ($category)
			{
				foreach ($category->getChildren() as $child)
				{
					if ($this->noIDs)
					{
						if ($child->alias === $segment)
						{
							return $child->id;
						}
					}
					else
					{
						if ($child->id == (int) $segment)
						{
							return $child->id;
						}
					}
				}
			}
		}

		return false;
	}


	public function getCategoriesId($segment, $query)
	{
		return $this->getCategoryId($segment, $query);
	}


	public function getDetailId($segment, $query)
	{
		if ($this->noIDs)
		{
			$db = JFactory::getDbo();
			$dbquery = $db->getQuery(true);
			$dbquery->select($dbquery->qn('id'))
				->from($dbquery->qn('#__newsfeeds'))
				->where('alias = ' . $dbquery->q($segment))
				->where('catid = ' . $dbquery->q($query['id']));
			$db->setQuery($dbquery);

			return (int) $db->loadResult();
		}

		return (int) $segment;
	}*/
}


function phocagalleryBuildRoute(&$query)
{
	$app = JFactory::getApplication();
	$router = new NewsfeedsRouter($app, $app->getMenu());

	return $router->build($query);
}


function phocagalleryParseRoute($segments)
{
	$app = JFactory::getApplication();
	$router = new NewsfeedsRouter($app, $app->getMenu());

	return $router->parse($segments);
}
