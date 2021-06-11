<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_phocagallery
 *
 * @copyright   Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * Routing class of com_phocagallery
 *
 * @since  3.3
 */

if (! class_exists('PhocaGalleryLoader')) {
    require_once( JPATH_ADMINISTRATOR.'/components/com_phocagallery/libraries/loader.php');
}

class PhocagalleryRouter extends JComponentRouterView
{
	protected $noIDs = false;

	/**
	 * Content Component router constructor
	 *
	 * @param   JApplicationCms  $app   The application object
	 * @param   JMenu            $menu  The menu object to work with
	 */
	public function __construct($app = null, $menu = null)
	{


		$params = JComponentHelper::getParams('com_phcagallery');
		$this->noIDs = (bool) $params->get('sef_ids');

		$categories = new JComponentRouterViewconfiguration('categories');
		$categories->setKey('id');
		$this->registerView($categories);


		$category = new JComponentRouterViewconfiguration('category');


		$category->setKey('id')->setParent($categories, 'parent_id')->setNestable();


		$this->registerView($category);



		$detail = new JComponentRouterViewconfiguration('detail');
		$detail->setKey('id')->setParent($category, 'catid');//->setNestable();
		$this->registerView($detail);

		$views = array('info', 'comment', 'user');
        foreach ($views as $k => $v) {
            $item = new JComponentRouterViewconfiguration($v);
		    $item->setName($v)->setParent($detail, 'id')->setParent($category, 'catid');
		    $this->registerView($item);
        }



		parent::__construct($app, $menu);

		phocagalleryimport('phocagallery.path.routerrules');
		phocagalleryimport('phocagallery.category.category');
		$this->attachRule(new JComponentRouterRulesMenu($this));
		$this->attachRule(new PhocaGalleryRouterrules($this));

		$this->attachRule(new JComponentRouterRulesStandard($this));
		$this->attachRule(new JComponentRouterRulesNomenu($this));



	}

	/**
	 * Method to get the segment(s) for a category
	 *
	 * @param   string  $id     ID of the category to retrieve the segments for
	 * @param   array   $query  The request that is built right now
	 *
	 * @return  array|string  The segments of this item
	 */
	public function getCategorySegment($id, $query)
	{



	    $category = PhocaGalleryCategory::getCategoryById($id);


		if (isset($category->id)) {





		    $path = PhocaGalleryCategory::getPath(array(), (int)$category->id, $category->parent_id, $category->title, $category->alias);

		    //$path = array_reverse($path, true);
		    //$path = array_reverse($category->getPath(), true);
			$path[0] = '1:root';// we don't use root but it is needed when building urls with joomla methods
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
	}

	/**
	 * Method to get the segment(s) for a category
	 *
	 * @param   string  $id     ID of the category to retrieve the segments for
	 * @param   array   $query  The request that is built right now
	 *
	 * @return  array|string  The segments of this item
	 */
	public function getCategoriesSegment($id, $query)
	{

		return $this->getCategorySegment($id, $query);
	}

	/**
	 * Method to get the segment(s) for an article
	 *
	 * @param   string  $id     ID of the article to retrieve the segments for
	 * @param   array   $query  The request that is built right now
	 *
	 * @return  array|string  The segments of this item
	 */
	public function getDetailSegment($id, $query)
	{

		if (!strpos($id, ':'))
		{
			$db = JFactory::getDbo();
			$dbquery = $db->getQuery(true);
			$dbquery->select($dbquery->qn('alias'))
				->from($dbquery->qn('#__phocagallery'))
				->where('id = ' . $dbquery->q($id));
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

	public function getInfoSegment($id, $query)
	{


		if (!strpos($id, ':'))
		{
			$db = JFactory::getDbo();
			$dbquery = $db->getQuery(true);
			$dbquery->select($dbquery->qn('alias'))
				->from($dbquery->qn('#__phocagallery'))
				->where('id = ' . $dbquery->q($id));
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

	/**
	 * Method to get the segment(s) for a form
	 *
	 * @param   string  $id     ID of the article form to retrieve the segments for
	 * @param   array   $query  The request that is built right now
	 *
	 * @return  array|string  The segments of this item
	 *
	 * @since   3.7.3
	 */
	public function getFormSegment($id, $query)
	{

		return $this->getArticleSegment($id, $query);
	}

	/**
	 * Method to get the id for a category
	 *
	 * @param   string  $segment  Segment to retrieve the ID for
	 * @param   array   $query    The request that is parsed right now
	 *
	 * @return  mixed   The id of this item or false
	 */
	public function getCategoryId($segment, $query)
	{



	    if (isset($query['id']))
		{

		    $category = false;
		    if ((int)$query['id'] > 0) {
                $category = PhocaGalleryCategory::getCategoryById($query['id']);
            } else if ((int)$segment > 0) {
		        // todo noids alias
		        $category = PhocaGalleryCategory::getCategoryById((int)$segment);
                if (isset($category->id) && (int)$category->id > 0 && $category->parent_id == 0) {
                    // We don't have root category with 0 so we need to start with segment one
                    return (int)$category->id;
                }
            }


			if ($category) {

                if (!empty($category->subcategories)){

                    foreach ($category->subcategories as $child) {
                        if ($this->noIDs) {
                            if ($child->alias == $segment) {


                                return $child->id;
                            }
                        } else {

                            if ($child->id == (int)$segment) {

                                return $child->id;
                            }
                        }
                    }
                }
			}
		}

		return false;
	}

	/**
	 * Method to get the segment(s) for a category
	 *
	 * @param   string  $segment  Segment to retrieve the ID for
	 * @param   array   $query    The request that is parsed right now
	 *
	 * @return  mixed   The id of this item or false
	 */
	public function getCategoriesId($segment, $query)
	{

		return $this->getCategoryId($segment, $query);
	}

	/**
	 * Method to get the segment(s) for an article
	 *
	 * @param   string  $segment  Segment of the article to retrieve the ID for
	 * @param   array   $query    The request that is parsed right now
	 *
	 * @return  mixed   The id of this item or false
	 */
	public function getDetailId($segment, $query)
	{

		if ($this->noIDs)
		{
			$db = JFactory::getDbo();
			$dbquery = $db->getQuery(true);
			$dbquery->select($dbquery->qn('id'))
				->from($dbquery->qn('#__phocagallery_image'))
				->where('alias = ' . $dbquery->q($segment))
				->where('catid = ' . $dbquery->q($query['id']));
			$db->setQuery($dbquery);

			return (int) $db->loadResult();
		}

		return (int) $segment;
	}
}


function PhocaGalleryBuildRoute(&$query)
{

	$app = JFactory::getApplication();
	$router = new PhocagalleryRouter($app, $app->getMenu());

	return $router->build($query);
}


function PhocaGalleryParseRoute($segments)
{


	$app = JFactory::getApplication();
	$router = new PhocagalleryRouter($app, $app->getMenu());

	return $router->parse($segments);
}

