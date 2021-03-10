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

use Joomla\CMS\Router\Route;
use Joomla\CMS\HTML\HTMLHelper;

defined('_JEXEC') or die('Restricted access');

echo '<div class="pg-categories-items-box">';

foreach ($this->categories as $k => $item) {

    echo '<div class="pg-category-box">';

    echo '<div class="pg-category-box-image">';
    echo '<a href="' . Route::_($item->link) . '">' . HTMLHelper::_('image', $item->linkthumbnailpath, $item->title) . '</a>';
    echo '</div>';

    echo '<div class="pg-category-box-title">';
    echo '<svg class="ph-si ph-si-category"><use xlink:href="#ph-si-category"></use></svg>';
    echo '<a href="' . Route::_($item->link) . '">' . $item->title_self. '</a>';
    echo $item->numlinks > 0 ? ' <span class="pg-category-box-count">(' . $item->numlinks . ')</span>' : '';
    echo '</div>';


    if ($this->t['display_cat_desc_box'] == 1 && $item->description != '') {
        echo '<div class="pg-category-box-description">' . strip_tags($item->description) . '</div>';
    } else if ($this->t['display_cat_desc_box'] == 2 && $item->description != '') {
        echo '<div class="pg-category-box-description">' . (HTMLHelper::_('content.prepare', $item->description, 'com_phocagallery.category')) . '</div>';
    }

    echo $this->loadTemplate('rating');

    echo '</div>';
}
echo '</div>';

?>
