<?php



defined('_JEXEC') or die();


use Joomla\Registry\Registry;

class PhocaGalleryRouterrules extends \JComponentRouterRulesMenu
{
	public function preprocess(&$query)
	{

		parent::preprocess($query);

	}

	protected function buildLookup($language = '*')
	{
		parent::buildLookup($language);

	}

}
