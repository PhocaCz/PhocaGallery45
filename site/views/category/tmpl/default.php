<?php
/*
 * @package Joomla
 * @copyright Copyright (C) 2005 Open Source Matters. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 *
 * @component Phoca Gallery
 * @copyright Copyright (C) Jan Pavelka www.phoca.cz
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */
defined('_JEXEC') or die('Restricted access');
phocagalleryimport('phocagallery.render.rendertabs');

$layoutSVG 	= new JLayoutFile('svg_definitions', null, array('component' => 'com_phocagallery'));

// SVG Definitions
$d          = array();
echo $layoutSVG->render($d);

echo '<div id="phocagallery" class="pg-category-view'.$this->params->get( 'pageclass_sfx' ).' pg-cv">';

// Heading
$heading = '';
if ($this->params->get( 'page_heading' ) != '') {
	$heading .= $this->params->get( 'page_heading' );
}

// Category Name Title
if ( $this->t['display_cat_name_title'] == 1) {
	if (isset($this->category->title) && $this->category->title != '') {
		if ($heading != '') {
			$heading .= ' - ';
		}
		$heading .= $this->category->title;
	}
}
// Pagetitle
if ($this->t['show_page_heading'] != 0) {
	if ( $heading != '') {
		echo '<div class="page-header"><h1>'. $this->escape($heading) . '</h1></div>';
	}
}

// Feed
if ($this->t['display_feed'] == 1 || $this->t['display_feed'] == 3) {
    if (isset($this->category->id) && (int)$this->category->id > 0 && isset($this->category->alias)) {
        echo '<div class="pg-top-icons">';
        echo '<a href="' . JRoute::_(PhocaGalleryRoute::getFeedRoute('category'), $this->category->id, $this->category->alias) . '" title="' . JText::_('COM_PHOCAGALLERY_RSS') . '"><svg class="pg-icon pg-icon-feed"><use xlink:href="#pg-icon-feed"></use></svg></a>';
        echo '</div>';
        echo '<div class="ph-cb"></div>';
    }
}


// Category Description
if (isset($this->category->description) && $this->category->description != '' ) {
	echo '<div class="pg-category-desc">'. HTMLHelper::_('content.prepare', $this->category->description) .'</div>'. "\n";
}




$this->checkRights = 1;

if ((int)$this->tagId > 0) {

	// Search by tags
	$this->checkRights = 1;

	// Categories View in Category View
	if ($this->t['display_categories_cv']) {
		echo $this->loadTemplate('categories');
	}

	echo $this->loadTemplate('images');

	echo $this->loadTemplate('pagination');

} else {

    // Standard category displaying
	$this->checkRights = 0;

	// Categories View in Category View
	if ($this->t['display_categories_cv']) {
		echo $this->loadTemplate('categories');
	}

	// Rendering images
	echo $this->loadTemplate('images');

	echo $this->loadTemplate('pagination');


	if ($this->t['displaytabs'] > 0) {

	    $tabItems = array();
	    $tabItemsI = 0;

        $tabs = new PhocaGalleryRenderTabs();
        echo $tabs->startTabs();

        if ((int)$this->t['display_rating'] == 1) {
            $tabItems[$tabItemsI] = array('id' => 'pgvotes', 'title' => JText::_('COM_PHOCAGALLERY_RATING'), 'image' => 'vote', 'icon' => 'vote');
            $tabItemsI++;
        }

        if ((int)$this->t['display_comment'] == 1) {
            if ($this->t['externalcommentsystem'] == 2) {
                $tabItems[$tabItemsI] = array('id' => 'pgcomments', 'title' => JText::_('COM_PHOCAGALLERY_COMMENTS'), 'image' => 'comment-fb-small', 'icon' => 'comment-fb');
            } else {
                $tabItems[$tabItemsI] = array('id' => 'pgcomments', 'title' => JText::_('COM_PHOCAGALLERY_COMMENTS'), 'image' => 'comment', 'icon' => 'comment');
            }
            $tabItemsI++;
        }
        if ((int)$this->t['displaycategorystatistics'] == 1) {
            $tabItems[$tabItemsI] = array('id' => 'pgstatistics', 'title' => JText::_('COM_PHOCAGALLERY_STATISTICS'), 'image' => 'statistics', 'icon' => 'statistics');
            $tabItemsI++;
        }
        if ((int)$this->t['displaycategorygeotagging'] == 1) {
            if ($this->map['longitude'] == '' || $this->map['latitude'] == '') {
				//echo '<p>' . JText::_('COM_PHOCAGALLERY_ERROR_MAP_NO_DATA') . '</p>';
			} else {
                $tabItems[$tabItemsI] = array('id' => 'pggeotagging', 'title' => JText::_('COM_PHOCAGALLERY_GEOTAGGING'), 'image' => 'geo', 'icon' => 'geo');
                $tabItemsI++;
            }
        }

        if ((int)$this->t['displaycreatecat'] == 1) {
            $tabItems[$tabItemsI] = array('id' => 'pgnewcategory', 'title' => JText::_('COM_PHOCAGALLERY_CATEGORY'), 'image' => 'subcategories', 'icon' => 'subcategory');
            $tabItemsI++;
        }
        if ((int)$this->t['displayupload'] == 1) {
            $tabItems[$tabItemsI] = array('id' => 'pgupload', 'title' => JText::_('COM_PHOCAGALLERY_UPLOAD'), 'image' => 'upload', 'icon' => 'upload');
            $tabItemsI++;
        }
        if ((int)$this->t['ytbupload'] == 1 && $this->t['displayupload'] == 1 ) {
            $tabItems[$tabItemsI] = array('id' => 'pgytbupload', 'title' => JText::_('COM_PHOCAGALLERY_YTB_UPLOAD'), 'image' => 'upload-ytb', 'icon' => 'upload-ytb');
            $tabItemsI++;
        }
        if((int)$this->t['enablemultiple']  == 1 && (int)$this->t['displayupload'] == 1) {
            $tabItems[$tabItemsI] = array('id' => 'pgmultipleupload', 'title' => JText::_('COM_PHOCAGALLERY_MULTIPLE_UPLOAD'), 'image' => 'upload-multiple', 'icon' => 'upload-multiple');
            $tabItemsI++;
        }
        if($this->t['enablejava'] == 1 && (int)$this->t['displayupload'] == 1) {
            $tabItems[$tabItemsI] = array('id' => 'pgjavaupload', 'title' => JText::_('COM_PHOCAGALLERY_JAVA_UPLOAD'), 'image' => 'upload-java', 'icon' => 'upload-java');
            $tabItemsI++;
        }

        $tabs->setActiveTab(isset($tabItems[$this->t['tab']]['id']) ? $tabItems[$this->t['tab']]['id'] : 0);
        echo $tabs->renderTabsHeader($tabItems);





		//echo '<div id="phocagallery-pane">';
		//echo Joomla\CMS\HTML\HTMLHelper::_('tabs.start', 'config-tabs-com_phocagallery-category', array('useCookie'=>1, 'startOffset'=> $this->t['tab']));

		if ((int)$this->t['display_rating'] == 1) {
		    echo $tabs->startTab('pgvotes');
			echo $this->loadTemplate('rating');
			echo $tabs->endTab();
		    //echo Joomla\CMS\HTML\HTMLHelper::_('tabs.panel', PhocaGalleryRenderFront::renderIcon('vote', 'media/com_phocagallery/images/icon-vote.png', ''). '&nbsp;'. JText::_('COM_PHOCAGALLERY_RATING'), 'pgvotes' );


		}

		if ((int)$this->t['display_comment'] == 1) {
			//$commentImg = ($this->t['externalcommentsystem'] == 2) ? 'icon-comment-fb' : 'icon-comment';
			//echo Joomla\CMS\HTML\HTMLHelper::_('tabs.panel', Joomla\CMS\HTML\HTMLHelper::_( 'image', 'media/com_phocagallery/images/'.$commentImg.'.png','') . '&nbsp;'.JText::_('COM_PHOCAGALLERY_COMMENTS'), 'pgcomments' );
            echo $tabs->startTab('pgcomments');
			/*if ($this->t['externalcommentsystem'] == 2) {
				echo Joomla\CMS\HTML\HTMLHelper::_('tabs.panel', PhocaGalleryRenderFront::renderIcon('comment-fb', 'media/com_phocagallery/images/icon-comment-fb-small.png', ''). '&nbsp;'.JText::_('COM_PHOCAGALLERY_COMMENTS'), 'pgcomments' );
			} else {
				echo Joomla\CMS\HTML\HTMLHelper::_('tabs.panel', PhocaGalleryRenderFront::renderIcon('comment', 'media/com_phocagallery/images/icon-comment.png', ''). '&nbsp;'.JText::_('COM_PHOCAGALLERY_COMMENTS'), 'pgcomments' );
			}*/



			if ($this->t['externalcommentsystem'] == 1) {
				if (JComponentHelper::isEnabled('com_jcomments', true)) {
					include_once(JPATH_BASE.'/components/com_jcomments/jcomments.php');
					echo JComments::showComments($this->category->id, 'com_phocagallery', JText::_('COM_PHOCAGALLERY_CATEGORY') .' '. $this->category->title);
				}
			} else if($this->t['externalcommentsystem'] == 2) {
				echo $this->loadTemplate('comments-fb');
			} else {
				echo $this->loadTemplate('comments');
			}

			echo $tabs->endTab();
		}

		if ((int)$this->t['displaycategorystatistics'] == 1) {
			//echo Joomla\CMS\HTML\HTMLHelper::_('tabs.panel', Joomla\CMS\HTML\HTMLHelper::_( 'image', 'media/com_phocagallery/images/icon-statistics.png', '') . '&nbsp;'.JText::_('COM_PHOCAGALLERY_STATISTICS'), 'pgstatistics' );
			//echo Joomla\CMS\HTML\HTMLHelper::_('tabs.panel', PhocaGalleryRenderFront::renderIcon('statistics', 'media/com_phocagallery/images/icon-statistics.png', '') . '&nbsp;'.JText::_('COM_PHOCAGALLERY_STATISTICS'), 'pgstatistics' );
            echo $tabs->startTab('pgstatistics');
			echo $this->loadTemplate('statistics');
			echo $tabs->endTab();
		}

		if ((int)$this->t['displaycategorygeotagging'] == 1) {
			if ($this->map['longitude'] == '' || $this->map['latitude'] == '') {
				//echo '<p>' . JText::_('COM_PHOCAGALLERY_ERROR_MAP_NO_DATA') . '</p>';
			} else {
				//echo Joomla\CMS\HTML\HTMLHelper::_('tabs.panel', Joomla\CMS\HTML\HTMLHelper::_( 'image', 'media/com_phocagallery/images/icon-geo.png','') . '&nbsp;'.JText::_('COM_PHOCAGALLERY_GEOTAGGING'), 'pggeotagging' );
				//echo Joomla\CMS\HTML\HTMLHelper::_('tabs.panel', PhocaGalleryRenderFront::renderIcon('geo', 'media/com_phocagallery/images/icon-geo.png', '') . '&nbsp;'.JText::_('COM_PHOCAGALLERY_GEOTAGGING'), 'pggeotagging' );
                echo $tabs->startTab('pggeotagging');
				if ($this->t['map_type'] == 2){
					echo $this->loadTemplate('geotagging_osm');
				} else {
					echo $this->loadTemplate('geotagging');
				}
				echo $tabs->endTab();

			}
		}
		if ((int)$this->t['displaycreatecat'] == 1) {
		    echo $tabs->startTab('pgnewcategory');
			//echo Joomla\CMS\HTML\HTMLHelper::_('tabs.panel', PhocaGalleryRenderFront::renderIcon('subcategory', 'media/com_phocagallery/images/icon-subcategories.png', '') . '&nbsp;'.JText::_('COM_PHOCAGALLERY_CATEGORY'), 'pgnewcategory' );
			echo $this->loadTemplate('newcategory');
			echo $tabs->endTab();
		}

		if ((int)$this->t['displayupload'] == 1) {
		    echo $tabs->startTab('pgupload');
			//echo Joomla\CMS\HTML\HTMLHelper::_('tabs.panel', PhocaGalleryRenderFront::renderIcon('upload', 'media/com_phocagallery/images/icon-upload.png', '') . '&nbsp;'.JText::_('COM_PHOCAGALLERY_UPLOAD'), 'pgupload' );
			echo $this->loadTemplate('upload');
			echo $tabs->endTab();
		}

		if ((int)$this->t['ytbupload'] == 1 && $this->t['displayupload'] == 1 ) {
		    echo $tabs->startTab('pgytbupload');
			//echo Joomla\CMS\HTML\HTMLHelper::_('tabs.panel', PhocaGalleryRenderFront::renderIcon('upload-ytb', 'media/com_phocagallery/images/icon-upload-ytb.png', '') . '&nbsp;'.JText::_('COM_PHOCAGALLERY_YTB_UPLOAD'), 'pgytbupload' );
			echo $this->loadTemplate('ytbupload');
			echo $tabs->endTab();
		}

		if((int)$this->t['enablemultiple']  == 1 && (int)$this->t['displayupload'] == 1) {
		    echo $tabs->startTab('pgmultipleupload');
			//echo Joomla\CMS\HTML\HTMLHelper::_('tabs.panel', PhocaGalleryRenderFront::renderIcon('upload-multiple', 'media/com_phocagallery/images/icon-upload-multiple.png', '') . '&nbsp;'.JText::_('COM_PHOCAGALLERY_MULTIPLE_UPLOAD'), 'pgmultipleupload' );
			echo $this->loadTemplate('multipleupload');
			echo $tabs->endTab();
		}

		if($this->t['enablejava'] == 1 && (int)$this->t['displayupload'] == 1) {
		    echo $tabs->startTab('pgjavaupload');
			//echo Joomla\CMS\HTML\HTMLHelper::_('tabs.panel', PhocaGalleryRenderFront::renderIcon('upload-java', 'media/com_phocagallery/images/icon-upload-java.png', ''). '&nbsp;'.JText::_('COM_PHOCAGALLERY_JAVA_UPLOAD'), 'pgjavaupload' );
			echo $this->loadTemplate('javaupload');
			echo $tabs->endTab();
		}

		echo $tabs->endTabs();
		//echo Joomla\CMS\HTML\HTMLHelper::_('tabs.end');
		//echo '</div>'. "\n";// end phocagallery-pane
	}
}

if ($this->t['detail_window'] == 6) {
	?><script type="text/javascript">
	var gjaks = new SZN.LightBox(dataJakJs, optgjaks);
	</script><?php
}

if ($this->t['detail_window'] == 14) {
	echo PhocaGalleryRenderDetailWindow::loadPhotoswipeBottom();
}

echo PhocaGalleryUtils::getExtInfo();
echo '</div>';
?>