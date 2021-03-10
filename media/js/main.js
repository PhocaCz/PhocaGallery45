﻿/*
 * @package Joomla
 * @copyright Copyright (C) 2005 Open Source Matters. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 *
 * @extension Phoca Gallery
 * @copyright Copyright (C) Jan Pavelka www.phoca.cz
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */

document.addEventListener("DOMContentLoaded", () => { 
  	
	

	/*var anchors = document.querySelectorAll('.pg-modal-button');
	for (var i = 0, length = anchors.length; i < length; i++) {
	var anchor = anchors[i];
	anchor.addEventListener('click', event => {
		// `this` refers to the anchor tag that's been clicked
		event.preventDefault();
		console.log(this.getAttribute('href'));
	}, true);
	};*/

	// Events
	document.querySelectorAll('.pg-modal-button').forEach(item => {

		
		item.addEventListener('click', function(event) {
		  
			event.preventDefault();
			let href = this.getAttribute('href');
			let title = this.getAttribute('data-img-title');


			let modalItem = document.getElementById('pgCategoryModal')
			let modalIframe = document.getElementById('pgCategoryModalIframe');
			let modalTitle	= document.getElementById('pgCategoryModalLabel');

			modalIframe.src = href;
			modalTitle.innerHTML = title;

			//let modal = document.getElementById('phCategoryModal')

			/*modal.addEventListener('shown.bs.modal', function () {
			myInput.focus()
			})*/
			let modal = new bootstrap.Modal(modalItem);
			modal.show();
	
		})  
	})

	/* Events */
	/*document.getElementById("filterOptionsClear").addEventListener("click", (event) => {
		document.getElementById("filterOptionsInput").value = "";
		filterOptions("");
	})
	
	document.getElementById("filterOptionsInput").addEventListener("input", (event) => {
		let eV = event.currentTarget.value;
		filterOptions(eV);
	});*/
});