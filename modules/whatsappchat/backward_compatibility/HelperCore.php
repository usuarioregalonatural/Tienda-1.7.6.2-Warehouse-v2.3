<?php
/**
* NOTICE OF LICENSE
*
* This product is licensed for one customer to use on one installation (test stores and multishop included).
* Site developer has the right to modify this module to suit their needs, but can not redistribute the module in
* whole or in part. Any other use of this module constitues a violation of the user agreement.
*
* DISCLAIMER
*
* NO WARRANTIES OF DATA SAFETY OR MODULE SECURITY
* ARE EXPRESSED OR IMPLIED. USE THIS MODULE IN ACCORDANCE
* WITH YOUR MERCHANT AGREEMENT, KNOWING THAT VIOLATIONS OF
* PCI COMPLIANCY OR A DATA BREACH CAN COST THOUSANDS OF DOLLARS
* IN FINES AND DAMAGE A STORES REPUTATION. USE AT YOUR OWN RISK.
*
*  @author    idnovate.com <info@idnovate.com>
*  @copyright 2019 idnovate.com
*  @license   See above
*/

/*
 * TODO : move HTML code in template files
 */

class HelperCore
{
	public static $translationsKeysForAdminCategorieTree = array(
		 'Home', 'selected', 'selecteds', 'Collapse All', 'Expand All', 'Check All', 'Uncheck All'
	);

	/**
	 *
	 * @param type $trads values of translations keys
	 *					For the moment, translation are not automatic
	 * @param type $selected_cat array of selected categories
	 *					Format
	 *						Array
							(
								 [0] => 1
								 [1] => 2
	 						)
	 *					OR
							Array
							(
								 [1] => Array
									  (
											[id_category] => 1
											[name] => Home page
											[link_rewrite] => home
									  )
							)
	 * @param type $input_name name of input
	 * @return string
	 */
	public static function renderAdminCategorieTree($trads, $selected_cat = array(), $input_name = 'categoryBox')
	{
		$html = '
		<script src="../js/jquery/treeview/jquery.treeview.js" type="text/javascript"></script>
		<script src="../js/jquery/treeview/jquery.treeview.async.js" type="text/javascript"></script>
		<script src="../js/jquery/treeview/jquery.treeview.edit.js" type="text/javascript"></script>
		<script src="../js/admin-categories-tree.js" type="text/javascript"></script>
		<script type="text/javascript">
			var inputName = "'.$input_name.'";
			var selectedCat = "'.implode(',', array_keys($selected_cat)).'";
		</script>
		<script type="text/javascript">
			var selectedLabel = \''.$trads['selected'].'\';
			var home = \''.$trads['Home'].'\';
		</script>
		<link type="text/css" rel="stylesheet" href="../css/jquery.treeview.css" />
		';

		$html .= '
		<div style="background-color:#F4E6C9; width:99%;padding:5px 0 5px 5px;">
			<a href="#" id="collapse_all" >'.$trads['Collapse All'].'</a>
			 - <a href="#" id="expand_all" >'.$trads['Expand All'].'</a>
			 - <a href="#" id="check_all" >'.$trads['Check All'].'</a>
			 - <a href="#" id="uncheck_all" >'.$trads['Uncheck All'].'</a>
		</div>
		';

		$home_is_selected = false;
		foreach($selected_cat AS $cat)
		{
			if (is_array($cat))
			{
				if  ($cat['id_category'] != 1)
					$html .= '<input type="hidden" name="'.$input_name.'[]" value="'.$cat['id_category'].'" >';
				else
					$home_is_selected = true;
			}
			else
			{
				if  ($cat != 1)
					$html .= '<input type="hidden" name="'.$input_name.'[]" value="'.$cat.'" >';
				else
					$home_is_selected = true;
			}
		}
		$html .= '
			<ul id="categories-treeview" class="filetree">
				<li id="1" class="hasChildren">
					<span class="folder"> <input type="checkbox" name="'.$input_name.'[]" value="1" '.($home_is_selected ? 'checked' : '').' onclick="clickOnCategoryBox($(this));" /> '.$trads['Home'].'</span>
					<ul>
						<li><span class="placeholder">&nbsp;</span></li>
				  </ul>
				</li>
			</ul>';
		return $html;
	}
}
