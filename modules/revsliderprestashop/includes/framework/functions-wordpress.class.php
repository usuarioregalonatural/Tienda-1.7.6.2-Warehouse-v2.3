<?php
/**
 * @author    ThemePunch <info@themepunch.com>
 * @link      http://www.themepunch.com/
 * @copyright 2015 ThemePunch
 */

 
class RevSliderFunctionsWP {

	public static $urlSite;
	public static $urlAdmin;
	
	const SORTBY_NONE = "none";
	const SORTBY_ID = "ID";
	const SORTBY_AUTHOR = "author";
	const SORTBY_TITLE = "title";
	const SORTBY_SLUG = "name";
	const SORTBY_DATE = "date";
	const SORTBY_LAST_MODIFIED = "modified";
	const SORTBY_RAND = "rand";
	const SORTBY_COMMENT_COUNT = "comment_count";
	const SORTBY_MENU_ORDER = "menu_order";
	
	const ORDER_DIRECTION_ASC = "ASC";
	const ORDER_DIRECTION_DESC = "DESC";
	
	const THUMB_SMALL = "thumbnail";
	const THUMB_MEDIUM = "medium";
	const THUMB_LARGE = "large";
	const THUMB_FULL = "full";
	
	const STATE_PUBLISHED = "publish";
	const STATE_DRAFT = "draft";
	
	
	/**
	 * 
	 * init the static variables
	 */
	public static function initStaticVars(){
		
		self::$urlAdmin = admin_url();			
		if(substr(self::$urlAdmin, -1) != "/")
			self::$urlAdmin .= "/";
			
	}
	
	
	/**
	 * 
	 * get sort by with the names
	 */
	public static function getArrSortBy(){
		$arr = array();
		$arr[self::SORTBY_ID] = "Post ID"; 
		$arr[self::SORTBY_DATE] = "Date";
		$arr[self::SORTBY_TITLE] = "Title"; 
		$arr[self::SORTBY_SLUG] = "Slug"; 
		$arr[self::SORTBY_AUTHOR] = "Author";
		$arr[self::SORTBY_LAST_MODIFIED] = "Last Modified"; 
		$arr[self::SORTBY_COMMENT_COUNT] = "Number Of Comments";
		$arr[self::SORTBY_RAND] = "Random";
		$arr[self::SORTBY_NONE] = "Unsorted";
		$arr[self::SORTBY_MENU_ORDER] = "Custom Order";
		return($arr);
	}
	
	
	/**
	 * 
	 * get array of sort direction
	 */
	public static function getArrSortDirection(){
		$arr = array();
		$arr[self::ORDER_DIRECTION_DESC] = "Descending";
		$arr[self::ORDER_DIRECTION_ASC] = "Ascending";
		return($arr);
	}
	
	
	/**
	 * get blog id
	 */
	public static function getBlogID(){
		global $blog_id;
		return($blog_id);
	}
	
	
	/**
	 * 
	 * get blog id
	 */
	public static function isMultisite(){
		$isMultisite = is_multisite();
		return($isMultisite);
	}
	
	
	/**
	 * 
	 * check if some db table exists
	 */
	public static function isDBTableExists($tableName){
		//global $wpdb;
		$wpdb = rev_db_class::rev_db_instance();
		if(empty($tableName))
			RevSliderFunctions::throwError("Empty table name!!!");
		
		$sql = "show tables like '$tableName'";
		
		$table = $wpdb->get_var($sql);
		
		if($table == $tableName)
			return(true);
			
		return(false);
	}
	
	
	/**
	 * 
	 * get wordpress base path
	 */
	public static function getPathBase(){
		return ABSPATH;
	}
	
	/**
	 * 
	 * get wp-content path
	 */
	public static function getPathUploads(){	
           
		global $wpdb;
		if(self::isMultisite()){
			if(!defined("BLOGUPLOADDIR")){
				$pathBase = self::getPathBase();
				//$pathContent = $pathBase."wp-content/uploads/";
				$pathContent = $pathBase."wp-content/uploads/sites/{$wpdb->blogid}/";
			}else
			  $pathContent = BLOGUPLOADDIR;
		}else{
			$pathContent = wp_upload_dir();
//			if(!empty($pathContent)){
//				$pathContent .= "/";
//			}
//			else{
//				$pathBase = self::getPathBase();
//				$pathContent = $pathBase."wp-content/uploads/";
//			}
		}
		
		return($pathContent);
	}
	
	/**
	 * 
	 * get content url
	 */
//	public static function getUrlUploads(){		
//			$baseUrl = main_site_url();				
//			return($baseUrl);
//		}
	public static function getUrlUploads($productUrl=false){
	
		if(self::isMultisite() == false){	//without multisite
			$baseUrl = content_url()."/";
                }elseif($productUrl==true){
                    $baseUrl = get_mainsite_url().'image/';
                } else{	//for multisite
			$arrUploadData = wp_upload_dir();
			$baseUrl = $arrUploadData["baseurl"]."/";
		}
		
		return($baseUrl);
		
	} 
	
	/**
	 * Check if current user is administrator
	 **/
	public static function isAdminUser(){
		//return current_user_can('administrator');
            return true;
	}
	
	
	/* Import media from url
	 *
	 * @param string $file_url URL of the existing file from the original site
	 * @param int $folder_name The slidername will be used as folder name in import
	 *
	 * @return boolean True on success, false on failure
	 */
//         public static function import_media_img($file_url, $folder, $filename){
//                    $wpdb = rev_db_class::rev_db_instance();  
//                    $tmp = $file_url;
//                    $replace_temp_url = str_replace(wp_upload_dir(). 'rstemp/images/','', $tmp);
//                   
//                    $suburl = str_replace('uploads/', '', $replace_temp_url);
//                    
//                    $suburl = str_replace('revslider/', '', $suburl); 
//                    
//                    $suburl = str_replace($filename, '', $suburl);
//                    
//                    if($suburl != '' || $suburl != null){
//                        @mkdir($folder. $suburl);
//                        copy($file_url, $folder.$suburl. $filename);
//                    }else{
//                        $suburl='';
//                        copy($file_url, $folder. $filename); 
//                    }
//                         
//                    $imagearray = array('file_name'=>$suburl.$filename);
//                  //  var_dump($filename);die();
//                    $mysqli = $wpdb->insert($wpdb->prefix.GlobalsRevSlider::TABLE_ATTACHMENT_IMAGES,$imagearray);
//                    $imgid = $wpdb->Insert_ID();
//                 
//                    
//                    if(!empty($mysqli) && is_numeric($imgid)){
//                        $sizes = array(
//                             GlobalsRevSlider::IMAGE_SIZE_THUMBNAIL,
//                             GlobalsRevSlider::IMAGE_SIZE_MEDIUM,
//                             GlobalsRevSlider::IMAGE_SIZE_LARGE
//                        );
//                        $fsizes = array(
//                             GlobalsRevSlider::IMAGE_SIZE_THUMBNAIL=>GlobalsRevSlider::IMAGE_SIZE_THUMBNAIL_H,
//                             GlobalsRevSlider::IMAGE_SIZE_MEDIUM=>GlobalsRevSlider::IMAGE_SIZE_MEDIUM_H,
//                             GlobalsRevSlider::IMAGE_SIZE_LARGE=>GlobalsRevSlider::IMAGE_SIZE_LARGE_H
//                        );
//                        $filerealname = substr($filename,0,strrpos($filename,'.'));
//                        $fileext = substr($filename,strrpos($filename,'.'),strlen($filename)-strlen($filerealname));
//                        list($width,$height) = getimagesize($folder.$suburl.$filename);
//                        $count = 0;
//                         
//                        foreach($fsizes as $sizew=>$sizeh){
//                            // $nsize = self::get_img_aspect_ratio(array($width,$height,$size));
//                            $newfilename = "{$filerealname}-{$sizew}x{$sizeh}{$fileext}";
//                            $res_img = new ImageToolsHelper();
//                             
//                            if(++$count > 1){
//                                $res_img->resize($folder.$suburl.$filename,$folder.$suburl.$newfilename, $sizew, $sizeh);
//                            }else{
//                                $res_img->resize($folder.$suburl.$filename,$folder.$suburl.$newfilename, $sizew, $sizeh);
//                            }
//                        }
//                         
//                      //  return array("id" => $imgid, "path" => 'media/com_revslider/uploads/'.$filename);
//                        return array("id" => $imgid, "path" => $suburl.$filename);
//                    }
//                }
//                
 
                public static function import_media($file_url,$alias=''){
                  //  var_dump($file_url);die();
                    $folder = wp_upload_dir(); 
                    $filename = basename($file_url);
                    $filename = "{$filename}";
                    
                    if($fp = fopen($file_url, "r")){
                        fclose($fp);
                        return self::import_media_img($file_url,$folder,$filename);                       
                    }
                    return false;
                }
              
 public static function import_media_img($file_url, $folder, $filename){
                    $wpdb = rev_db_class::rev_db_instance();  
                    $tmp = $file_url;
                    $replace_temp_url = str_replace(wp_upload_dir(). 'rstemp/images/','', $tmp);
                    
                    $suburl = str_replace('uploads/', '', $replace_temp_url);
                    
                    $suburl = str_replace('revslider/', '', $suburl); 
                    
                    $suburl = str_replace($filename, '', $suburl);
                    
                   
                    $table_name = RevSliderGlobals::$table_attachment_images; 
                    
                     
                    $subdir_filename = $suburl. $filename;
                    
                    $attachment_id = $wpdb->get_var("SELECT ID FROM {$table_name} WHERE file_name='{$subdir_filename}'");  
                    $reanmed_file_name = pathinfo($subdir_filename,PATHINFO_FILENAME);
                    $extension = pathinfo($subdir_filename, PATHINFO_EXTENSION);
                    $original_name = $reanmed_file_name;
                    $i = 1;
                    while(is_numeric($attachment_id))
                    {      
                        $reanmed_file_name = (string)$original_name.'_'.$i;
                        $subdir_filename = $suburl.$reanmed_file_name.".".$extension; 
                        $attachment_id = $wpdb->get_var("SELECT ID FROM {$table_name} WHERE file_name='{$subdir_filename}'");   
                        $i++;
                    }
                    $filename = basename($subdir_filename);
                    if($suburl != '' || $suburl != null){
                        @mkdir($folder. $suburl, 0777, true);
                        copy($file_url, $folder.$suburl. $filename);
                       // var_dump($suburl);die();
                    }else{
                        $suburl='';
                        copy($file_url, $folder. $filename); 
                    }
                    
                    
                    
                    $imagearray = array('file_name'=>$subdir_filename); 
                    
                    $mysqli = $wpdb->insert($wpdb->prefix.GlobalsRevSlider::TABLE_ATTACHMENT_IMAGES,$imagearray);
                    
                  
                   
                  //  var_dump($subdir_filename);die();
                    $imgid = $wpdb->Insert_ID();
                 
                    
                    if(!empty($mysqli) && is_numeric($imgid)){
                        $sizes = array(
                             GlobalsRevSlider::IMAGE_SIZE_THUMBNAIL,
                             GlobalsRevSlider::IMAGE_SIZE_MEDIUM,
                             GlobalsRevSlider::IMAGE_SIZE_LARGE
                        );
                        $fsizes = array(
                             GlobalsRevSlider::IMAGE_SIZE_THUMBNAIL=>GlobalsRevSlider::IMAGE_SIZE_THUMBNAIL_H,
                             GlobalsRevSlider::IMAGE_SIZE_MEDIUM=>GlobalsRevSlider::IMAGE_SIZE_MEDIUM_H,
                             GlobalsRevSlider::IMAGE_SIZE_LARGE=>GlobalsRevSlider::IMAGE_SIZE_LARGE_H
                        );
                        $filerealname = substr($filename,0,strrpos($filename,'.'));
                        $fileext = substr($filename,strrpos($filename,'.'),strlen($filename)-strlen($filerealname));
                        list($width,$height) = getimagesize($folder.$subdir_filename);
                        $count = 0;
                         
                        foreach($fsizes as $sizew=>$sizeh){
                            // $nsize = self::get_img_aspect_ratio(array($width,$height,$size));
                            $newfilename = "{$filerealname}-{$sizew}x{$sizeh}{$fileext}";
                           // $res_img = new ImageToolsHelper();
                             
                            if(++$count > 1){
                               
                                ImageManager::resize($folder . $subdir_filename, $folder .$suburl. $newfilename, $sizew, $sizeh);
                            }else{
                               ImageManager::resize($folder . $subdir_filename, $folder .$suburl. $newfilename, $sizew, $sizeh);
                            }
                            
                            
                        }
                         
                      //  return array("id" => $imgid, "path" => 'media/com_revslider/uploads/'.$filename);
                        return array("id" => $imgid, "path" => $subdir_filename);
                    }
                }
//                
 
	/**
	 * 
	 * register widget (must be class)
	 */
	public static function registerWidget($widgetName){
		add_action('widgets_init', create_function('', 'return register_widget("'.$widgetName.'");'));
	}

	/**
	 * get image relative path from image url (from upload)
	 */
	public static function getImagePathFromURL($urlImage){
		 
		$baseUrl = self::getUrlUploads();
                //the below line is not needed
                $urlImage = str_replace('helper.2.3.0.2', "2.3.0.2", $urlImage);
               // var_dump($baseUrl);var_dump($urlImage);die();
		$pathImage = str_replace($baseUrl, "", $urlImage);
		//  var_dump($pathImage);die();
		return($pathImage);
	}
	
	/**
	 * get image real path physical on disk from url
	 */
	public static function getImageRealPathFromUrl($urlImage){
		$filepath = self::getImagePathFromURL($urlImage);
		$realPath = RevSliderFunctionsWP::getPathUploads().$filepath;
		return($realPath);
	}
	public static function getImageDirFromUrl($pathImage){
		//protect from absolute url 
		
		$urlImage = str_replace(wp_upload_url(),wp_upload_dir(), $pathImage);
		return($urlImage); 
	}
	
	/**
	 * 
	 * get image url from image path.
	 */
	public static function getImageUrlFromPath($pathImage){
		//protect from absolute url
		$pathLower = strtolower($pathImage);
		if(strpos($pathLower, "http://") !== false || strpos($pathLower, "https://") !== false || strpos($pathLower, "www.") === 0)
			return($pathImage);
		
		$urlImage = str_replace(wp_upload_dir(),wp_upload_url(), $pathImage);
		return($urlImage); 
	}
	public static function getImageUrlFromPathForImport($pathImage){
		//protect from absolute url
		$pathLower = strtolower($pathImage);
		if(strpos($pathLower, "http://") !== false || strpos($pathLower, "https://") !== false || strpos($pathLower, "www.") === 0)
			return($pathImage);
		
		$urlImage = wp_upload_url().$pathImage;
		return($urlImage); 
	} 
	/**	
	 * 
	 * get post categories list assoc - id / title
	 */
	public static function getCategoriesAssoc($taxonomy = "category"){
		
		if(strpos($taxonomy,",") !== false){
			$arrTax = explode(",", $taxonomy);
			$arrCats = array();
			foreach($arrTax as $tax){
				$cats = self::getCategoriesAssoc($tax);
				$arrCats = array_merge($arrCats,$cats);
			}
			
			return($arrCats);
		}	
		
		//$cats = get_terms("category");
		$args = array("taxonomy"=>$taxonomy);
		$cats = get_categories($args);
		
		$arrCats = array();
		foreach($cats as $cat){
			$numItems = $cat->count;
			$itemsName = "items";
			if($numItems == 1)
				$itemsName = "item";
				
			$title = $cat->name . " ($numItems $itemsName)";
			
			$id = $cat->cat_ID;
			$arrCats[$id] = $title;
		}
		return($arrCats);
	}
	
	
	/**
	 * 
	 * return post type title from the post type
	 */
	public static function getPostTypeTitle($postType){
		
		$objType = get_post_type_object($postType);
		
		if(empty($objType))
			return($postType);

		$title = $objType->labels->singular_name;
		
		return($title);
	}
	
	
	/**
	 * 
	 * get post type taxomonies
	 */
	public static function getPostTypeTaxomonies($postType){
		$arrTaxonomies = get_object_taxonomies(array( 'post_type' => $postType ), 'objects');
		
                if($arrTaxonomies == null){
                    $arrTaxonomies = array();
                }
		$arrNames = array();
		foreach($arrTaxonomies as $key=>$objTax){			
			$arrNames[$objTax->name] = $objTax->labels->name;
		}
		
		return($arrNames);
	}
	
	/**
	 * 
	 * get post types taxonomies as string
	 */
	public static function getPostTypeTaxonomiesString($postType){
		$arrTax = self::getPostTypeTaxomonies($postType);
		$strTax = "";
		foreach($arrTax as $name=>$title){
			if(!empty($strTax))
				$strTax .= ",";
			$strTax .= $name;
		}
		
		return($strTax);
	}
	
	
	/**
	 * 
	 * get all the post types including custom ones
	 * the put to top items will be always in top (they must be in the list)
	 */
//	public static function getPostTypesAssoc($arrPutToTop = array()){
//		 $arrBuiltIn = array(
//			"post"=>"post",
//			"page"=>"page",
//		 );
//		 
//		 $arrCustomTypes = get_post_types(array('_builtin' => false));
//		 
//		 //top items validation - add only items that in the customtypes list
//		 $arrPutToTopUpdated = array();
//		 foreach($arrPutToTop as $topItem){
//			if(in_array($topItem, $arrCustomTypes) == true){
//				$arrPutToTopUpdated[$topItem] = $topItem;
//				unset($arrCustomTypes[$topItem]);
//			}
//		 }
//		 
//		 $arrPostTypes = array_merge($arrPutToTopUpdated,$arrBuiltIn,$arrCustomTypes);
//		 
//		 //update label
//		 foreach($arrPostTypes as $key=>$type){
//			$arrPostTypes[$key] = self::getPostTypeTitle($type);			 		
//		 }
//		 
//		 return($arrPostTypes);
//	}
	
	public static function getPostTypesAssoc($arrPutToTop = array()){ 
			$arrPostTypes['product'] = 'Category Product'; 
			
			return($arrPostTypes);

		}


	/**
	 * 
	 * get the category data
	 */
	public static function getCategoryData($catID){
		$catData = get_category($catID);
		if(empty($catData))
			return($catData);
			
		$catData = (array)$catData;			
		return($catData);
	}
	
	
	/**
	 * 
	 * get posts by coma saparated posts
	 */
	public static function getPostsByIDs($strIDs)
    {
        $arrPosts = array();
        $arrPrd = array();
        $id_lang = Context::getContext()->language->id;
        $id_shop = Context::getContext()->shop->id;
        if (is_string($strIDs)) {
            $arr = explode(",", $strIDs);
        }
        $i = 0;
        // actionProductListOverride
        foreach ($arr as $ar) {
            $product = new Product($ar, true, $id_lang, $id_shop);
            $product = (array) $product;
            $product['id_product'] = (int) $ar;

            $lnk = new Link();
            $prd_link = $lnk->getProductLink($product);
            $arrPrd['id_product'] = $ar;
            $arrPrd['link'] = $prd_link;
            $productArr = Product::getProductsProperties($id_lang, array($product));

            $productArr = $productArr[0];
            foreach ($productArr as $key => $value) {
                if ($key == 'id_category_default') {
                    $arrPrd['default_category'] = self::getCategoryNameById($value);
                } else {
                    $arrPrd[$key] = $value;
                }
            }
            $arrPosts[$i] = $arrPrd;
            $i++;
        }

        return($arrPosts);
    }
public static function getCategoryNameById($id_category = '')
    {
        if (@RevsliderPrestashop::getIsset($id_category) && !empty($id_category) && $id_category != 0) {
            $id_lang = (int) Context::getContext()->language->id;
            $result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
                                    SELECT sbcl.`name` FROM `' . _DB_PREFIX_ . 'category` sbc INNER JOIN `' . _DB_PREFIX_ . 'category_lang` sbcl ON(sbc.`id_category` = sbcl.`id_category` AND sbcl.`id_lang` = ' . (int) ($id_lang) . ')
                                    INNER JOIN `' . _DB_PREFIX_ . 'category_shop` sbs ON sbs.id_category = sbc.id_category and sbs.id_shop = ' . (int) Context::getContext()->shop->id . ' WHERE sbc.`active`= 1 and sbc.`id_category` = ' . $id_category);
            return $result[0]['name'];
        } else {
            return false;
        }
    }
	
	/**
	 * 
	 * get posts by some category
	 * could be multiple
	 */
	public static function getPostsByCategory($slider_id,$catID,$sortBy = self::SORTBY_ID,$direction = self::ORDER_DIRECTION_DESC,$numPosts=-1,$postTypes="any",$taxonomies="category",$arrAddition = array()){
		   
		//get post types
		if(strpos($postTypes,",") !== false){
			$postTypes = explode(",", $postTypes);
			if(array_search("any", $postTypes) !== false)
				$postTypes = "any";		
		}
		
		if(empty($postTypes))
			$postTypes = "any";
		
		if(strpos($catID,",") !== false)
			$catID = explode(",",$catID);
		else
			$catID = array($catID);
		
                
                //there was wpml by post which we dont need
		
                
		$query = array(
			'order'=>$direction,
			'ignore_sticky_posts' => 1,
			'posts_per_page'=>$numPosts,
			'showposts'=>$numPosts,
			'post_type'=>$postTypes
		);		

		//add sort by (could be by meta)
		if(strpos($sortBy, "meta_num_") === 0){
			$metaKey = str_replace("meta_num_", "", $sortBy);
			$query["orderby"] = "meta_value_num";
			$query["meta_key"] = $metaKey;
		}else
		if(strpos($sortBy, "meta_") === 0){
			$metaKey = str_replace("meta_", "", $sortBy);
			$query["orderby"] = "meta_value";
			$query["meta_key"] = $metaKey;
		}else
			$query["orderby"] = $sortBy;
			
		//get taxonomies array
		$arrTax = array();
		if(!empty($taxonomies)){
			$arrTax = explode(",", $taxonomies);
		}
			
		if(!empty($taxonomies)){
		
			$taxQuery = array();
		
			//add taxomonies to the query
			if(strpos($taxonomies,",") !== false){	//multiple taxomonies
				$taxonomies = explode(",",$taxonomies);
				foreach($taxonomies as $taxomony){
					$taxArray = array(
						'taxonomy' => $taxomony,
						'field' => 'id',
						'terms' => $catID
					);			
					$taxQuery[] = $taxArray;
				}
			}else{		//single taxomony
				$taxArray = array(
					'taxonomy' => $taxonomies,
					'field' => 'id',
					'terms' => $catID
				);			
				$taxQuery[] = $taxArray;				
			}
			
			$taxQuery['relation'] = 'OR';
			
			$query['tax_query'] = $taxQuery;
		} //if exists taxanomies
		
		//var_dump($catID);die();
               
		if(!empty($arrAddition))
			$query = array_merge($query, $arrAddition);
		
                return '';
                
                
		$query = apply_filters('revslider_get_posts', $query, $slider_id);
		
		$objQuery = new WP_Query($query);

		$arrPosts = $objQuery->posts;

		
		foreach($arrPosts as $key=>$post){
			
			if(method_exists($post, "to_array"))
				$arrPost = $post->to_array();				
			else
				$arrPost = (array)$post;
			
			$arrPostCats = self::getPostCategories($post, $arrTax);
			$arrPost["categories"] = $arrPostCats;
			
			$arrPosts[$key] = $arrPost;
		}
		
		return($arrPosts);
	}
	
	/**
	 * 
	 * get post categories by postID and taxonomies
	 * the postID can be post object or array too
	 */
	public static function getPostCategories($postID,$arrTax){
		
		if(!is_numeric($postID)){
			$postID = (array)$postID;
			$postID = $postID["ID"];
		}
			
		$arrCats = wp_get_post_terms( $postID, $arrTax);
		$arrCats = RevSliderFunctions::convertStdClassToArray($arrCats);
		return($arrCats);
	}
	
	
	/**
	 * 
	 * get single post
	 */
	public static function getPost($postID){
		$post = get_post($postID);
		if(empty($post))
			RevSliderFunctions::throwError("Post with id: $postID not found");
		
		$arrPost = $post->to_array();
		return($arrPost);
	}

	
	/**
	 * 
	 * update post state
	 */
	public static function updatePostState($postID,$state){
		$arrUpdate = array();
		$arrUpdate["ID"] = $postID;
		$arrUpdate["post_status"] = $state;
		
		wp_update_post($arrUpdate);
	}
	
	/**
	 * 
	 * update post menu order
	 */
	public static function updatePostOrder($postID,$order){
		$arrUpdate = array();
		$arrUpdate["ID"] = $postID;
		$arrUpdate["menu_order"] = $order;
		
		wp_update_post($arrUpdate);
	}
	
	
	/**
	 * 
	 * get url of post thumbnail
	 */
	public static function getUrlPostImage($postID,$size = self::THUMB_FULL){
		
		$post_thumbnail_id = get_post_thumbnail_id( $postID );
		if(empty($post_thumbnail_id))
			return("");
		
		$arrImage = wp_get_attachment_image_src($post_thumbnail_id,$size);
		if(empty($arrImage))
			return("");
		
		$urlImage = $arrImage[0];
		return($urlImage);
	}
	
	/**
	 * 
	 * get post thumb id from post id
	 */
	public static function getPostThumbID($postID){
		$thumbID = get_post_thumbnail_id( $postID );
		return($thumbID);
	}
	
	
	/**
	 * 
	 * get attachment image array by id and size
	 */
	public static function getAttachmentImage($thumbID,$size = self::THUMB_FULL){
		
		$arrImage = wp_get_attachment_image_src($thumbID,$size);
		if(empty($arrImage))
			return(false);
		
		$output = array();
		$output["url"] = RevSliderFunctions::getVal($arrImage, 0);
		$output["width"] = RevSliderFunctions::getVal($arrImage, 1);
		$output["height"] = RevSliderFunctions::getVal($arrImage, 2);
		
		return($output);
	}
	
	
	/**
	 * 
	 * get attachment image url
	 */
	public static function getUrlAttachmentImage($thumbID,$size = self::THUMB_FULL){
		$arrImage = wp_get_attachment_image_src($thumbID,$size);
		
                
		if(empty($arrImage))
			return(false);
		//print_r($arrImage);
		$url = RevSliderFunctions::getVal($arrImage, 0);
               
                $url = str_replace(wp_upload_dir(), wp_upload_url(), $url);
		return($url);
	}
	
	
	/**
	 * 
	 * get link of edit slides by category id
	 */
	public static function getUrlSlidesEditByCatID($catID){
		
		$url = self::$urlAdmin;
		$url .= "edit.php?s&post_status=all&post_type=post&action=-1&m=0&cat=".$catID."&paged=1&mode=list&action2=-1";
		
		return($url);
	}
	
	/**
	 * 
	 * get edit post url
	 */
	public static function getUrlEditPost($postID){
		$url = self::$urlAdmin;
		$url .= "post.php?post=".$postID."&action=edit";
		
		return($url);
	}
	
	
	/**
	 * 
	 * get new post url
	 */
	public static function getUrlNewPost(){
		$url = self::$urlAdmin;
		$url .= "post-new.php";
		return($url);
	}
	
	
	/**
	 * 
	 * delete post
	 */
	public static function deletePost($postID){
		$success = wp_delete_post($postID,false);
		if($success == false)
			RevSliderFunctions::throwError("Could not delete post: $postID");
	}
	
	/**
	 * 
	 * update post thumbnail
	 */
	public static function updatePostThumbnail($postID,$thumbID){
		set_post_thumbnail($postID, $thumbID);
	}
	
	
	/**
	 * 
	 * get intro from content
	 */
	public static function getIntroFromContent($text){
		$intro = "";
		if(!empty($text)){
			$arrExtended = get_extended($text);
			$intro = RevSliderFunctions::getVal($arrExtended, "main");
			
			/*
			if(strlen($text) != strlen($intro))
				$intro .= "...";
			*/
		}
		
		return($intro);
	}

	
	/**
	 * 
	 * get excerpt from post id
	 */
	public static function getExcerptById($postID, $limit=55){
		
		 $post = get_post($postID);	
		 
		 $excerpt = $post->post_excerpt;
		 $excerpt = trim($excerpt);
		 
		 $excerpt = trim($excerpt);
		 if(empty($excerpt))
			$excerpt = $post->post_content;			 
		 
		 $excerpt = strip_tags($excerpt,"<b><br><br/><i><strong><small>");
		 
		 $excerpt = RevSliderFunctions::getTextIntro($excerpt, $limit);
		 
		 return $excerpt;
	}		
	
	
	/**
	 * 
	 * get user display name from user id
	 */
	public static function getUserDisplayName($userID){
		
		$displayName =  get_the_author_meta('display_name', $userID);
		
		return($displayName);
	}
	
	
	/**
	 * 
	 * get categories by id's
	 */
	public static function getCategoriesByIDs($arrIDs,$strTax = null){			
		
		if(empty($arrIDs))
			return(array());
			
		if(is_string($arrIDs))
			$strIDs = $arrIDs;
		else
			$strIDs = implode(",", $arrIDs);
		
		$args = array();
		$args["include"] = $strIDs;
		
		if(!empty($strTax)){
			if(is_string($strTax))
				$strTax = explode(",",$strTax);
			
			$args["taxonomy"] = $strTax;
		}
		
		$arrCats = get_categories( $args );
		
		if(!empty($arrCats))
			$arrCats = RevSliderFunctions::convertStdClassToArray($arrCats);			
		
		return($arrCats);
	}
	
	
	/**
	 * 
	 * get categories short 
	 */
	public static function getCategoriesByIDsShort($arrIDs,$strTax = null){
		$arrCats = self::getCategoriesByIDs($arrIDs,$strTax);
		$arrNew = array();
		foreach($arrCats as $cat){
			$catID = $cat["term_id"];
			$catName = $cat["name"];
			$arrNew[$catID] =  $catName;
		}
		
		return($arrNew);
	}
	
	
	/**
	 * get categories list, copy the code from default wp functions
	 */
	public static function getCategoriesHtmlList($catIDs,$strTax = null){
		global $wp_rewrite;
		
		//$catList = get_the_category_list( ",", "", $postID );
		
		$categories = self::getCategoriesByIDs($catIDs,$strTax);
		
		$arrErrors = RevSliderFunctions::getVal($categories, "errors");
		
		if(!empty($arrErrors)){
			foreach($arrErrors as $key=>$arr){
				$strErrors = implode($arr,",");				
			}
			
			RevSliderFunctions::throwError("getCategoriesHtmlList error: ".$strErrors);
		}
		
		$rel = ( is_object( $wp_rewrite ) && $wp_rewrite->using_permalinks() ) ? 'rel="category tag"' : 'rel="category"';
		
		$separator = ',';
		
		$thelist = '';
					
		$i = 0;
		foreach ( $categories as $category ) {

			if(is_object($category))
				$category = (array)$category;
			
			if ( 0 < $i )
				$thelist .= $separator;
				
			$catID = $category["term_id"];
			$link = get_category_link($catID);
			$catName = $category["name"];
			
			if(!empty($link))
				$thelist .= '<a href="' . esc_url( $link ) . '" title="' . esc_attr( sprintf( __( "View all posts in %s", 'revslider'), $category["name"] ) ) . '" ' . $rel . '>' . $catName.'</a>';
			else
				$thelist .= $catName;
			
			++$i;
		}
		
		
		return $thelist;
	}
	
	public static function getImagePathFromURLProduct($urlImage){
		
		$baseUrl = self::getUrlUploads(true);
		$pathImage = str_replace($baseUrl, "", $urlImage);
		
		return($pathImage);
	}
	/**
	 * 
	 * get post tags html list
	 */
	public static function getTagsHtmlList($postID){
		$tagList = get_the_tag_list("",",","",$postID);
		return($tagList);
	}
	
	/**
	 * 
	 * convert date to the date format that the user chose.
	 */
//	public static function convertPostDate($date, $with_time = false){
//		if(empty($date))
//			return($date);
//		if($with_time){
//			$date = date_i18n(get_option('date_format').' '.get_option('time_format'), strtotime($date));
//		}else{
//			$date = date_i18n(get_option('date_format'), strtotime($date));
//		}
//			
//		return($date);
//	}
	public static function convertPostDate($date)
    {

        return($date);
    }
	/**
	 * 
	 * get assoc list of the taxonomies
	 */
	public static function getTaxonomiesAssoc(){
		$arr = get_taxonomies();
		unset($arr["post_tag"]);
		unset($arr["nav_menu"]);
		unset($arr["link_category"]);
		unset($arr["post_format"]);
		
		return($arr);
	}
	
	
	/**
	 * 
	 * get post types array with taxomonies
	 */
	public static function getPostTypesWithTaxomonies(){
		$arrPostTypes = self::getPostTypesAssoc();
		
		foreach($arrPostTypes as $postType=>$title){
			$arrTaxomonies = self::getPostTypeTaxomonies($postType);
			$arrPostTypes[$postType] = $arrTaxomonies;
		}
		
		return($arrPostTypes);
	}
	
	
	/**
	 * 
	 * get array of post types with categories (the taxonomies is between).
	 * get only those taxomonies that have some categories in it.
	 */
	public static function getPostTypesWithCats(){
		$arrPostTypes = self::getPostTypesWithTaxomonies();
		
		$arrPostTypesOutput = array();
		foreach($arrPostTypes as $name=>$arrTax){

			$arrTaxOutput = array();
			foreach($arrTax as $taxName=>$taxTitle){
				$cats = self::getCategoriesAssoc($taxName);
				if(!empty($cats))
					$arrTaxOutput[] = array(
							 "name"=>$taxName,
							 "title"=>$taxTitle,
							 "cats"=>$cats);
			}
			
			$arrPostTypesOutput[$name] = $arrTaxOutput;
			
		}
		
		return($arrPostTypesOutput);
	}
	
	
	/**
	 * 
	 * get array of all taxonomies with categories.
	 */
	public static function getTaxonomiesWithCats(){
		
		$arrTax = self::getTaxonomiesAssoc();
		$arrTaxNew = array();
		foreach($arrTax as $key=>$value){
			$arrItem = array();
			$arrItem["name"] = $key;
			$arrItem["title"] = $value;
			$arrItem["cats"] = self::getCategoriesAssoc($key);
			$arrTaxNew[$key] = $arrItem;
		}
		
		return($arrTaxNew);
	}

	
	/**
	 * 
	 * get content url
	 */
	public static function getUrlContent(){
	
		if(self::isMultisite() == false){	//without multisite
			$baseUrl = content_url()."/";
		}
		else{	//for multisite
			$arrUploadData = wp_upload_dir();
			$baseUrl = $arrUploadData["baseurl"]."/";
		}
		
		if(is_ssl()){
			$baseUrl = str_replace("http://", "https://", $baseUrl);
		}
		
		return($baseUrl);
	}

	/**
	 * 
	 * get wp-content path
	 */
	public static function getPathContent(){		
		if(self::isMultisite()){
			if(!defined("BLOGUPLOADDIR")){
				$pathBase = self::getPathBase();
				$pathContent = $pathBase."wp-content/";
			}else
			  $pathContent = BLOGUPLOADDIR;
		}else{
			$pathContent = wp_upload_dir();
			if(!empty($pathContent)){
				$pathContent .= "/";
			}
			else{
				$pathBase = self::getPathBase();
				$pathContent = $pathBase."wp-content/";
			}
		}
		
		return($pathContent);
	}
public static function getRevPostDataArray($catIDs, $sortBy = self::SORTBY_ID, $direction = self::ORDER_DIRECTION_DESC, $numPosts = -1, $postTypes = "any", $taxonomies = "category", $arrAddition = array())
    {
        if ($numPosts == -1) {
            $numPosts = null;
        }
        $results = array();
        $categoriesid = array();
//        $blogids = array();
        $ids = explode(',', $catIDs);
        if (!empty($ids)) {
            foreach ($ids as $id) {
                $categoriesid[] = (int)$id;
//                $dta_len = Tools::strlen($id);
//                $dta_pos = strrpos($id, '_');
//                $cat_type = Tools::substr($id, 0, $dta_pos);
//                if ($cat_type == 'category') {
//                    $categoriesid[] = str_replace('category_', '', $id);
//                } elseif ($cat_type == 'smartblog') {
//                    $blogids[] = str_replace('smartblog_', '', $id);
//                }
            }
        }
        $i = 0;
        if (@RevsliderPrestashop::getIsset($categoriesid) && !empty($categoriesid)) {
            foreach ($categoriesid as $catid) {
                $results_temp = self::getAllProducts($catid, $sortBy, $direction, $numPosts);
                foreach ($results_temp as $temp) {
                    $results[$i] = $temp;
                    $i++;
                }
            }
        }
//        if (@RevsliderPrestashop::getIsset($blogids) && !empty($blogids)) {
//            foreach ($blogids as $blgid) {
//                $results[$i] = $blgid;
//                $i++;
//            }
//        }
        return $results;
    }
    public static function getAllProducts($id_category, $order_by = null, $order_way = null, $limit = null)
    {
        // start set prestashop value
        $random = false;

        if ($order_by == 'ID') {
            $order_by = 'id_product';
        } elseif ($order_by == 'date') {
            $order_by = 'date_add';
        } elseif ($order_by == 'title') {
            $order_by = 'name';
        } elseif ($order_by == 'price') {
            $order_by = 'price';
        } else {
            $order_by = 'position';
        }

        if ($order_by == 'rand') {
            $random = true;
        }
        // end set prestashop value
        $random_number_products = 1;

        $check_access = true;


        $id_lang = Context::getcontext()->language->id;

        $context = Context::getContext();

        // if ($check_access && !$this->checkAccess($context->customer->id))
        // 	return false;

        $active = true;

        $front = true;
        if (!in_array($context->controller->controller_type, array('front', 'modulefront'))) {
            $front = false;
        }

        if (empty($order_by)) {
            $order_by = 'position';
        } else {
            $order_by = Tools::strtolower($order_by);
        }

        if (empty($order_way)) {
            $order_way = 'ASC';
        }

        $order_by_prefix = false;
        if ($order_by == 'id_product' || $order_by == 'date_add' || $order_by == 'date_upd') {
            $order_by_prefix = 'p';
        } elseif ($order_by == 'name') {
            $order_by_prefix = 'pl';
        } elseif ($order_by == 'manufacturer') {
            $order_by_prefix = 'm';
            $order_by = 'name';
        } elseif ($order_by == 'position') {
            $order_by_prefix = 'cp';
        }

        if ($order_by == 'price') {
            $order_by = 'orderprice';
        }

        if (!Validate::isBool($active) || !Validate::isOrderBy($order_by) || !Validate::isOrderWay($order_way)) {
            die(Tools::displayError());
        }

        $sql = 'SELECT p.*, product_shop.*, stock.out_of_stock, IFNULL(stock.quantity, 0) as quantity, MAX(product_attribute_shop.id_product_attribute) id_product_attribute, product_attribute_shop.minimal_quantity AS product_attribute_minimal_quantity, pl.`description`, pl.`description_short`, pl.`available_now`,
                                                    pl.`available_later`, pl.`link_rewrite`, pl.`meta_description`, pl.`meta_keywords`, pl.`meta_title`, pl.`name`, MAX(image_shop.`id_image`) id_image,
                                                    il.`legend`, m.`name` AS manufacturer_name, cl.`name` AS default_category,
                                                    DATEDIFF(product_shop.`date_add`, DATE_SUB(NOW(),
                                                    INTERVAL ' . (Validate::isUnsignedInt(Configuration::get('PS_NB_DAYS_NEW_PRODUCT')) ? Configuration::get('PS_NB_DAYS_NEW_PRODUCT') : 20) . '
                                                            DAY)) > 0 AS new, product_shop.price AS orderprice
                                            FROM `' . _DB_PREFIX_ . 'category_product` cp
                                            LEFT JOIN `' . _DB_PREFIX_ . 'product` p
                                                    ON p.`id_product` = cp.`id_product`
                                            ' . Shop::addSqlAssociation('product', 'p') . '
                                            LEFT JOIN `' . _DB_PREFIX_ . 'product_attribute` pa
                                            ON (p.`id_product` = pa.`id_product`)
                                            ' . Shop::addSqlAssociation('product_attribute', 'pa', false, 'product_attribute_shop.`default_on` = 1') . '
                                            ' . Product::sqlStock('p', 'product_attribute_shop', false, $context->shop) . '
                                            LEFT JOIN `' . _DB_PREFIX_ . 'category_lang` cl
                                                    ON (product_shop.`id_category_default` = cl.`id_category`
                                                    AND cl.`id_lang` = ' . (int) $id_lang . Shop::addSqlRestrictionOnLang('cl') . ')
                                            LEFT JOIN `' . _DB_PREFIX_ . 'product_lang` pl
                                                    ON (p.`id_product` = pl.`id_product`
                                                    AND pl.`id_lang` = ' . (int) $id_lang . Shop::addSqlRestrictionOnLang('pl') . ')
                                            LEFT JOIN `' . _DB_PREFIX_ . 'image` i
                                                    ON (i.`id_product` = p.`id_product`)' .
            Shop::addSqlAssociation('image', 'i', false, 'image_shop.cover=1') . '
                                            LEFT JOIN `' . _DB_PREFIX_ . 'image_lang` il
                                                    ON (image_shop.`id_image` = il.`id_image`
                                                    AND il.`id_lang` = ' . (int) $id_lang . ')
                                            LEFT JOIN `' . _DB_PREFIX_ . 'manufacturer` m
                                                    ON m.`id_manufacturer` = p.`id_manufacturer`
                                            WHERE product_shop.`id_shop` = ' . (int) $context->shop->id . '
                                                    AND cp.`id_category` = ' . (int) $id_category
            . ($active ? ' AND product_shop.`active` = 1' : '')
            . ($front ? ' AND product_shop.`visibility` IN ("both", "catalog")' : '')
            . ' GROUP BY product_shop.id_product';

        if ($random === true) {
            $sql .= ' ORDER BY RAND() LIMIT ' . (int) $random_number_products;
        } else {
            $sql .= ' ORDER BY ' . (!empty($order_by_prefix) ? $order_by_prefix . '.' : '') . '`' . bqSQL($order_by) . '` ' . pSQL($order_way);
        }
        if (@RevsliderPrestashop::getIsset($limit)) {
            $sql .= ' LIMIT ' . $limit;
        }
        $result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);
        if ($order_by == 'orderprice') {
            Tools::orderbyPrice($result, $order_way);
        }

        if (!$result) {
            return array();
        }

        return Product::getProductsProperties($id_lang, $result);
    }
	/**
	 * 
	 * get cats and taxanomies data from the category id's
	 */
	public static function getCatAndTaxData($catIDs){
		
		if(is_string($catIDs)){
			$catIDs = trim($catIDs);
			if(empty($catIDs))
				return(array("tax"=>"","cats"=>""));
			
			$catIDs = explode(",", $catIDs);
		}
		
		$strCats = "";
		$arrTax = array();
		foreach($catIDs as $cat){
			if(strpos($cat,"option_disabled") === 0)
				continue;
			
			$pos = strrpos($cat,"_");
			if($pos === false)
				RevSliderFunctions::throwError("The category is in wrong format");
			
			$taxName = substr($cat,0,$pos);
			$catID = substr($cat,$pos+1,strlen($cat)-$pos-1);
			
			$arrTax[$taxName] = $taxName;
			if(!empty($strCats))
				$strCats .= ",";
				
			$strCats .= $catID;				
		}
		
		$strTax = "";
		foreach($arrTax as $taxName){
			if(!empty($strTax))
				$strTax .= ",";
				
			$strTax .= $taxName;
		} 
		
		$output = array("tax"=>$strTax,"cats"=>$strCats);
		
		return($output);
	}
	
	
	/**
	 * 
	 * get current language code
	 */
	public static function getCurrentLangCode(){

//		$langTag = ICL_LANGUAGE_CODE;
//
//		return($langTag);
               
                $langTag = sdsconfig::get_current_lang();
                
			return($langTag);
	}

	
	/**
	 * 
	 * check the current post for the existence of a short code
	 */  
	public static function hasShortcode($shortcode = '') {  
	
		if(!is_singular())
			return false;
			
		$post = get_post(get_the_ID());  
		  
		$found = false; 
		
		if (empty($shortcode))   
			return $found;
			
			
		if (stripos($post->post_content, '[' . $shortcode) !== false )    
			$found = true;  
		   
		return $found;  
	}  		
	
	
	/**
	 * Check if shortcodes exists in the content
	 * @since: 5.0
	 */  
	public static function check_for_shortcodes($mid_content){
		if($mid_content !== null){ 
			if(has_shortcode($mid_content, 'gallery')){
				
				preg_match('/\[gallery.*ids=.(.*).\]/', $mid_content, $img_ids);
				
				if(isset($img_ids[1])){
					if($img_ids[1] !== '') return explode(',', $img_ids[1]);
				}
			}
		}
		return false;
	}
	
	
	/**
	 * retrieve the image id from the given image url
	 * @since: 5.0
	 */
	public static function get_image_id_by_url($image_url) {
           return false;//forcefully making it false
		//global $wpdb;
		$wpdb = rev_db_class::rev_db_instance();
                
		$filename = str_replace(wp_upload_url(), '', $image_url);
                        
		$attachment_id = 0;
                $table_name = RevSliderGlobals::$table_attachment_images; 
                //var_dump($table_name);die();
                $attachment_id = $wpdb->get_var("SELECT ID FROM {$table_name} WHERE file_name='{$filename}'");  
		
		return $attachment_id;
	}
	public static function getArrImageSize()
    {
        $arr = array();

        $img_type = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
                        SELECT * FROM `' . _DB_PREFIX_ . 'image_type` where `products` = 1');

        foreach ($img_type as $type) {
            $arr[$type['name']] = $type['name'];
        }

        return($arr);
    }
	
	public static function update_option($handle, $value, $autoload = 'on'){ //on is on, false is 'off'
                update_option($handle,$value);
		//return true;
//		if(!add_option($handle, $value, '', $autoload)){ //returns false if option is not existing
//			delete_option($handle);
//		}
//		
//		add_option($handle, $value, '', $autoload);
	}
	
}	//end of the class

//init the static vars
RevSliderFunctionsWP::initStaticVars();

/**
 * old classname extends new one (old classnames will be obsolete soon)
 * @since: 5.0
 **/
class UniteFunctionsWPRev extends RevSliderFunctionsWP {}
?>