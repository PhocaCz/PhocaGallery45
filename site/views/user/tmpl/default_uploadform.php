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
defined('_JEXEC') or die;
?><table>
	<tr>
		<td><?php echo JText::_('COM_PHOCAGALLERY_FILENAME');?>:</td>
		<td>

		<input type="file" id="file-upload" class="form-control phfileuploadcheckcat" name="Filedata" />
			<button class="btn btn-primary" id="file-upload-submit"><i class="icon-upload icon-white"></i> <?php echo JText::_('COM_PHOCAGALLERY_START_UPLOAD') ?></button>
			<span id="upload-clear"></span>
		</td>
	</tr>

	<tr>
		<td><?php echo JText::_( 'COM_PHOCAGALLERY_IMAGE_TITLE' ); ?>:</td>
			<td>
				<input type="text" id="phocagallery-upload-title" name="phocagalleryuploadtitle" value=""  maxlength="255" class="form-control comment-input" /></td>
		</tr>

		<tr>
			<td><?php echo JText::_( 'COM_PHOCAGALLERY_DESCRIPTION' ); ?>:</td>
			<td><textarea id="phocagallery-upload-description" name="phocagalleryuploaddescription" onkeyup="countCharsUpload('<?php echo $this->t['upload_form_id']; ?>');" cols="30" rows="10" class="form-control comment-input"></textarea></td>
		</tr>

		<tr>
			<td>&nbsp;</td>
			<td><?php echo JText::_('COM_PHOCAGALLERY_CHARACTERS_WRITTEN');?> <input name="phocagalleryuploadcountin" value="0" readonly="readonly" class="form-control comment-input2" /> <?php echo JText::_('COM_PHOCAGALLERY_AND_LEFT_FOR_DESCRIPTION');?> <input name="phocagalleryuploadcountleft" value="<?php echo $this->t['maxuploadchar'];?>" readonly="readonly" class="form-control comment-input2" />
			</td>
		</tr>
</table>

<input type="hidden" name="controller" value="user" />
<input type="hidden" name="viewback" value="user" />
<input type="hidden" name="view" value="user"/>
<input type="hidden" name="tab" value="<?php echo $this->t['currenttab']['images'];?>" />
<input type="hidden" name="Itemid" value="<?php echo $this->itemId ?>"/>
<input type="hidden" name="filter_order_image" value="<?php echo $this->listsimage['order']; ?>" />
<input type="hidden" name="filter_order_Dir_image" value="" />
<input type="hidden" name="catid" value="<?php echo $this->t['catidimage'] ?>"/>

<?php


if ($this->t['upload_form_id'] == 'phocaGalleryUploadFormU') {
	//echo '<div id="loading-label" style="text-align:center">'
	//. Joomla\CMS\HTML\HTMLHelper::_('image', 'media/com_phocagallery/images/icon-switch.gif', '')
	//. '  '.JText::_('COM_PHOCAGALLERY_LOADING').'</div>';
	echo '<div id="loading-label-user" class="ph-loading-text ph-loading-hidden"><div class="ph-lds-ellipsis"><div></div><div></div><div></div><div></div></div><div>'. JText::_('COM_PHOCAGALLERY_LOADING') . '</div></div>';
}
?>
