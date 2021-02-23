<?php
/**
 * @package   Phoca Gallery
 * @author    Jan Pavelka - https://www.phoca.cz
 * @copyright Copyright (C) Jan Pavelka https://www.phoca.cz
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 and later
 * @cms       Joomla
 * @copyright Copyright (C) Open Source Matters. All rights reserved.
 * @license   http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 */
defined( '_JEXEC' ) or die( 'Restricted access' );

use Joomla\CMS\Session\Session;
use Phoca\Render\Adminviews;
use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;

class PhocaGalleryRenderAdminViews extends AdminViews
{
	public $view        = '';
    public $viewtype    = 1;
    public $option      = '';
    public $optionLang  = '';
    public $tmpl        = '';
    public $compatible  = false;
    public $sidebar     = true;
    protected $document	= false;

	public function __construct(){

		parent::__construct();

		//$this->loadMedia();

	}

	public function tdImage($item, $button, $txtE, $class = '', $avatarAbs = '', $avatarRel = '') {
		$o = '<td class="'.$class.'">'. "\n";
		$o .= '<div class="pg-msnr-container"><div class="phocagallery-box-file">'. "\n"
			.' <center>'. "\n"
			.'  <div class="phocagallery-box-file-first">'. "\n"
			.'   <div class="phocagallery-box-file-second">'. "\n"
			.'    <div class="phocagallery-box-file-third">'. "\n"
			.'     <center>'. "\n";

		if ($avatarAbs != '' && $avatarRel != '') {
			// AVATAR
			if (JFile::exists($avatarAbs.$item->avatar)){
				$o .= '<a class="'. $button->methodname.'"'
				//.' title="'. $button->text.'"'
				.' href="'.JURI::root().$avatarRel.$item->avatar.'" '
				//.' rel="'. $button->options.'"'
				. ' >'
				.'<img src="'.JURI::root().$avatarRel.$item->avatar.'?imagesid='.md5(uniqid(time())).'" alt="'.JText::_($txtE).'" />'
				.'</a>';
			} else {
				$o .= Joomla\CMS\HTML\HTMLHelper::_( 'image', '/media/com_phocagallery/images/administrator/phoca_thumb_s_no_image.gif', '');
			}
		} else {
			// PICASA
			if (isset($item->extid) && $item->extid !='') {

				$resW				= explode(',', $item->extw);
				$resH				= explode(',', $item->exth);
				$correctImageRes 	= PhocaGalleryImage::correctSizeWithRate($resW[2], $resH[2], 50, 50);
				$imgLink			= $item->extl;

				//$o .= '<a class="'. $button->modalname.'" title="'.$button->text.'" href="'. $imgLink .'" rel="'. $button->options.'" >'
				$o .= '<a class="'. $button->methodname.'"  href="'. $imgLink .'" >'
				. '<img src="'.$item->exts.'?imagesid='.md5(uniqid(time())).'" width="'.$correctImageRes['width'].'" height="'.$correctImageRes['height'].'" alt="'.JText::_($txtE).'" />'
				.'</a>'. "\n";
			} else if (isset ($item->fileoriginalexist) && $item->fileoriginalexist == 1) {

				$imageRes			= PhocaGalleryImage::getRealImageSize($item->filename, 'small');
				$correctImageRes 	= PhocaGalleryImage::correctSizeWithRate($imageRes['w'], $imageRes['h'], 50, 50);
				$imgLink			= PhocaGalleryFileThumbnail::getThumbnailName($item->filename, 'large');

				//$o .= '<a class="'. $button->modalname.'" title="'. $button->text.'" href="'. JURI::root(). $imgLink->rel.'" rel="'. $button->options.'" >'
				$o .= '<a class="'. $button->methodname.'"  href="'. JURI::root(). $imgLink->rel.'"  >'
				. '<img src="'.JURI::root().$item->linkthumbnailpath.'?imagesid='.md5(uniqid(time())).'" width="'.$correctImageRes['width'].'" height="'.$correctImageRes['height'].'" alt="'.JText::_($txtE).'" itemprop="thumbnail" />'
				.'</a>'. "\n";
			} else {
				$o .= Joomla\CMS\HTML\HTMLHelper::_( 'image', 'media/com_phocagallery/images/administrator/phoca_thumb_s_no_image.gif', '');
			}
		}
		$o .= '     </center>'. "\n"
			.'    </div>'. "\n"
			.'   </div>'. "\n"
			.'  </div>'. "\n"
			.' </center>'. "\n"
			.'</div></div>'. "\n";
		$o .=  '</td>'. "\n";
		return $o;
	}
}
?>