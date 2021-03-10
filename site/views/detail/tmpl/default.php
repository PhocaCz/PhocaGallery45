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

use Joomla\CMS\HTML\HTMLHelper;

defined('_JEXEC') or die('Restricted access');
echo '<div id="phocagallery" class="pg-detail-item-box'.$this->params->get( 'pageclass_sfx' ).'">';
if ($this->t['backbutton'] != '') {
	echo $this->t['backbutton'];
}
/*
if($this->t['responsive'] == 1) {
	$iW = '';
	$iH = '';
} else {
	$iW = 'width:'.$this->item->realimagewidth. 'px;';
	$iH = 'height:'.$this->t['largeheight'].'px;';
}
*/

switch ($this->t['detailwindow']) {
	case 4:
	case 7:
	case 9:
	case 10:
	case 11:
		$closeImage 	= $this->item->linkimage;
		$closeButton 	= '';
	break;


	default:
		$closeButton 	= str_replace("%onclickclose%", $this->t['detailwindowclose'], $this->item->closebutton);
		$closeImage 	= '<a href="#" onclick="'.$this->t['detailwindowclose'].'" style="margin:auto;padding:0">'.$this->item->linkimage.'</a>';
	break;

}
//krumo($this->item);
$classSuffix = ' popup';
if ($this->t['detailwindow'] == 7) {
	$classSuffix = ' no-popup';
}
/*
echo '<div class="ph-mc" style="padding-top:10px">'
	.'<table border="0" class="ph-w100 ph-mc" cellpadding="0" cellspacing="0">'
	.'<tr>'
	.'<td colspan="6" align="center" valign="middle"'
	.' style="'.$iH.'vertical-align: middle;" >'
	.'<div id="phocaGalleryImageBox" style="'.$iW.'margin: auto;padding: 0;">'
	.$closeImage;
*/
echo '<div class="pg-detail-item-image-box">'.$closeImage.'</div>';
$titleDesc = '';
if ($this->t['display_title_description'] == 1) {
	$titleDesc .= $this->item->title;
	if ($this->item->description != '' && $titleDesc != '') {
		$titleDesc .= ' - ';
	}
}

// Lightbox Description
if ($this->t['displaydescriptiondetail'] == 2 && (!empty($this->item->description) || !empty($titleDesc))){

	echo '<div class="pg-detail-item-desc-box">' .(HTMLHelper::_('content.prepare', $titleDesc . $this->item->description, 'com_phocagallery.item')).'</div>';
}



if ($this->t['detailbuttons'] == 1){
	echo '<div class="pg-detail-item-button-box">'
	.'<td align="left" width="30%" style="padding-left:48px">'.$this->item->prevbutton.'</td>'
	.'<td align="center">'.$this->item->slideshowbutton.'</td>'
	.'<td align="center">'.str_replace("%onclickreload%", $this->t['detailwindowreload'], $this->item->reloadbutton).'</td>'
	. $closeButton
	.'<td align="right" width="30%" style="padding-right:48px">'.$this->item->nextbutton.'</td>'
	.'</div>';
}


echo $this->loadTemplate('rating');

// Tags
if ($this->t['displaying_tags_output'] != '') {
	echo '<div class="pg-detail-item-tag-box">'.$this->t['displaying_tags_output'].'</div>';
}
if ($this->t['detailwindow'] == 7) {



	/*if ($this->t['externalcommentsystem'] == 1) {
		if (JComponentHelper::isEnabled('com_jcomments', true)) {
			include_once(JPATH_BASE.'/components/com_jcomments/jcomments.php');
			echo JComments::showComments($this->item->id, 'com_phocagallery_images', JText::_('COM_PHOCAGALLERY_IMAGE') .' '. $this->item->title);
		}
	} else if ($this->t['externalcommentsystem'] == 2) {
		echo $this->loadTemplate('comments-fb');
	}*/
    echo PhocaGalleryUtils::getExtInfo();
}
echo '</div>';
echo '<div id="phocaGallerySlideshowC" style="display:none"></div>';
?>
