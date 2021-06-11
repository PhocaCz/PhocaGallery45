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
echo '<div id="phocagallery-ytbupload">';
echo '<div class="ph-tabs-iefix">&nbsp;</div>';//because of IE bug
echo '<form onsubmit="return OnUploadSubmitCategoryPG(\'loading-label-ytb\');" action="'. $this->t['syu_url'] .'" id="phocaGalleryUploadFormYU" method="post">';
//if ($this->t['ftp']) { echo PhocaGalleryFileUpload::renderFTPaccess();}
echo '<h4>'.JText::_('COM_PHOCAGALLERY_YTB_UPLOAD').'</h4>';
echo $this->t['syu_output'];
$this->t['upload_form_id'] = 'phocaGalleryUploadFormYU';
?>
<table>
	<tr>
	<td><?php echo JText::_( 'COM_PHOCAGALLERY_YTB_LINK' ); ?>:</td>
	<td><input type="text" id="phocagallery-ytbupload-link" name="phocagalleryytbuploadlink" value="" class="form-control"  maxlength="255" size="48" /></td>
	</tr>
	<tr style="text-align: right">
	<td></td>
	<td><input type="submit" class="btn btn-primary" id="file-upload-submit" value="<?php echo JText::_('COM_PHOCAGALLERY_START_UPLOAD'); ?>"/></td>
	</tr>
</table><?php
if ($this->t['upload_form_id'] == 'phocaGalleryUploadFormYU') {
/*	echo '<div id="loading-label-ytb" style="text-align:center">'
	. Joomla\CMS\HTML\HTMLHelper::_('image', 'media/com_phocagallery/images/icon-switch.gif', '')
	. '  '.JText::_('COM_PHOCAGALLERY_LOADING').'</div>';
	*/
	echo '<div id="loading-label-ytb" class="ph-loading-text ph-loading-hidden"><div class="ph-lds-ellipsis"><div></div><div></div><div></div><div></div></div><div>'. JText::_('COM_PHOCAGALLERY_LOADING') . '</div></div>';

}
echo Joomla\CMS\HTML\HTMLHelper::_('form.token');
echo '</form>';
echo '</div>';
