<?php
/*
 * @package Joomla
 * @copyright Copyright (C) Open Source Matters. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * @component Phoca Gallery
 * @copyright Copyright (C) Jan Pavelka www.phoca.cz
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */
defined('_JEXEC') or die;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;

$published = $this->state->get('filter.published');
?>
<div class="modal hide fade" id="collapseModal">
	<div class="modal-header">
		<button type="button" role="presentation" class="close" data-dismiss="modal">x</button>
		<h3><?php echo Text::_('COM_PHOCAGALLERY_BATCH_OPTIONS_CATEGORIES');?></h3>
	</div>
	<div class="modal-body">
		<p><?php /* echo JText::_('COM_CONTENT_BATCH_TIP');*/ ?></p>
		<div class="control-group">
			<div class="controls">
				<?php echo LayoutHelper::render('joomla.html.batch.access', []);?>
			</div>
		</div>

		<div class="control-group">
			<div class="controls">
				<label id="batch-accessuserid-lbl" for="batch-accessuserid" class="modalTooltip" title="<strong><?php echo Text::_('COM_PHOCAGALLERY_SET_ACCESS_RIGHTS_LEVEL'); ?></strong><br /><?php echo Text::_('COM_PHOCAGALLERY_NOT_MAKING_SELECTION_WILL_KEEP_ORIGINAL_ACCESS_RIGHTS_LEVELS'); ?>"><?php echo Text::_('COM_PHOCAGALLERY_SET_ACCESS_RIGHTS_LEVEL'); ?></label>


				<?php
				$userList = PhocaGalleryAccess::usersList( 'batch[accessuserid][]', 'batch-accessuserid', -3, 1, NULL, 'name', 0 );
				echo $userList
				?>
			</div>
		</div>


		<div class="control-group">
			<div class="controls">
				<?php echo LayoutHelper::render('joomla.html.batch.language', []); ?>
			</div>
		</div>
		<?php if ($published >= 0) : ?>
		<div class="control-group">
			<div class="controls">
				<?php /* echo JHtml::_('batch.item', 'com_phocagallery'); */ ?>
				<?php echo PhocaGalleryBatch::item($published, 1); ?>
			</div>
		</div>
		<?php endif; ?>
	</div>
	<div class="modal-footer">
		<button class="btn" type="button" onclick="document.getElementById('batch-category-id').value='';document.getElementById('batch-access').value='';document.getElementById('batch-language-id').value=''" data-dismiss="modal">
			<?php echo Text::_('JCANCEL'); ?>
		</button>
		<button class="btn btn-primary" type="submit" onclick="Joomla.submitbutton('phocagalleryc.batch');">
			<?php echo Text::_('JGLOBAL_BATCH_PROCESS'); ?>
		</button>
	</div>
</div>
