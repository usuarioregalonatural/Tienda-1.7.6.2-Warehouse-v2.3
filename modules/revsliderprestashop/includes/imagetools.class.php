<?php
defined('_JEXEC') or die;

class ImageToolsHelper extends JHelperContent{
	const ERROR_FILE_NOT_EXIST = 1;
	const ERROR_FILE_WIDTH     = 2;
	const ERROR_MEMORY_LIMIT   = 3;

	public static function checkImageMemoryLimit($image)
	{
		// $infos = @getimagesize($image);

		// if (!is_array($infos) || !isset($infos['bits']))
		// 	return true;

		// $memory_limit = Tools::getMemoryLimit();
		// // memory_limit == -1 => unlimited memory
		// if (function_exists('memory_get_usage') && (int)$memory_limit != -1)
		// {
		// 	$current_memory = memory_get_usage();
		// 	$channel = isset($infos['channels']) ? ($infos['channels'] / 8) : 1;

		// 	// Evaluate the memory required to resize the image: if it's too much, you can't resize it.
		// 	if (($infos[0] * $infos[1] * $infos['bits'] * $channel + pow(2, 16)) * 1.8 + $current_memory > $memory_limit - 1024 * 1024)
		// 		return false;
		// }

		return true;
	}

	public static function resize($src_file, $dst_file, $dst_width = null, $dst_height = null, $file_type = 'jpg',
								$force_type = false, &$error = 0, &$tgt_width = null, &$tgt_height = null, $quality = 5,
								&$src_width = null, &$src_height = null)
	{
		if (PHP_VERSION_ID < 50300)
			clearstatcache();
		else
			clearstatcache(true, $src_file);

		if (!file_exists($src_file) || !filesize($src_file))
			return !($error = self::ERROR_FILE_NOT_EXIST);

		list($tmp_width, $tmp_height, $type) = getimagesize($src_file);
		$rotate = 0;
		if (function_exists('exif_read_data') && function_exists('mb_strtolower'))
		{
			$exif = @exif_read_data($src_file);

			if ($exif && isset($exif['Orientation']))
			{
				switch ($exif['Orientation'])
				{
					case 3:
						$src_width = $tmp_width;
						$src_height = $tmp_height;
						$rotate = 180;
						break;

					case 6:
						$src_width = $tmp_height;
						$src_height = $tmp_width;
						$rotate = -90;
						break;

					case 8:
						$src_width = $tmp_height;
						$src_height = $tmp_width;
						$rotate = 90;
						break;

					default:
						$src_width = $tmp_width;
						$src_height = $tmp_height;
				}
			}
			else
			{
				$src_width = $tmp_width;
				$src_height = $tmp_height;
			}
		}
		else
		{
			$src_width = $tmp_width;
			$src_height = $tmp_height;
		}

		// If PS_IMAGE_QUALITY is activated, the generated image will be a PNG with .jpg as a file extension.
		// This allow for higher quality and for transparency. JPG source files will also benefit from a higher quality
		// because JPG reencoding by GD, even with max quality setting, degrades the image.
		if (!$force_type)
			$file_type = 'png';

		if (!$src_width)
			return !($error = self::ERROR_FILE_WIDTH);
		if (!$dst_width)
			$dst_width = $src_width;
		if (!$dst_height)
			$dst_height = $src_height;

		$width_diff = $dst_width / $src_width;
		$height_diff = $dst_height / $src_height;

		$ps_image_generation_method = 3;//Configuration::get('PS_IMAGE_GENERATION_METHOD');
		if ($width_diff > 1 && $height_diff > 1)
		{
			$next_width = $src_width;
			$next_height = $src_height;
		}
		else
		{
			if ($ps_image_generation_method == 2 || (!$ps_image_generation_method && $width_diff > $height_diff))
			{
				$next_height = $dst_height;
				$next_width = round(($src_width * $next_height) / $src_height);
				$dst_width = (int)(!$ps_image_generation_method ? $dst_width : $next_width);
			}
			else
			{
				$next_width = $dst_width;
				$next_height = round($src_height * $dst_width / $src_width);
				$dst_height = (int)(!$ps_image_generation_method ? $dst_height : $next_height);
			}
		}

		if (!self::checkImageMemoryLimit($src_file))
			return !($error = self::ERROR_MEMORY_LIMIT);

		$tgt_width  = $dst_width;
		$tgt_height = $dst_height;

		$dest_image = imagecreatetruecolor($dst_width, $dst_height);

		// If image is a PNG and the output is PNG, fill with transparency. Else fill with white background.
		if ($file_type == 'png' && $type == IMAGETYPE_PNG)
		{
			imagealphablending($dest_image, false);
			imagesavealpha($dest_image, true);
			$transparent = imagecolorallocatealpha($dest_image, 255, 255, 255, 127);
			imagefilledrectangle($dest_image, 0, 0, $dst_width, $dst_height, $transparent);
		}
		else
		{
			$white = imagecolorallocate($dest_image, 255, 255, 255);
			imagefilledrectangle ($dest_image, 0, 0, $dst_width, $dst_height, $white);
		}

		$src_image = self::create($type, $src_file);
		if ($rotate)
			$src_image = imagerotate($src_image, $rotate, 0);

		if ($dst_width >= $src_width && $dst_height >= $src_height)
			imagecopyresized($dest_image, $src_image, (int)(($dst_width - $next_width) / 2), (int)(($dst_height - $next_height) / 2), 0, 0, $next_width, $next_height, $src_width, $src_height);
		else
			self::imagecopyresampled($dest_image, $src_image, (int)(($dst_width - $next_width) / 2), (int)(($dst_height - $next_height) / 2), 0, 0, $next_width, $next_height, $src_width, $src_height, $quality);
		$write_file = self::write($file_type, $dest_image, $dst_file);
		@imagedestroy($src_image);
		return $write_file;
	}

	public static function write($type, $resource, $filename)
	{
    
		static $ps_png_quality = null;
		static $ps_jpeg_quality = null;

		if ($ps_png_quality === null)
			$ps_png_quality = 9; //Configuration::get('PS_PNG_QUALITY');

		if ($ps_jpeg_quality === null)
		 	$ps_jpeg_quality = 9; //Configuration::get('PS_JPEG_QUALITY');

		switch ($type){
			case 'gif':
				$success = imagegif($resource, $filename);
			break;

			case 'png':
				$quality = ($ps_png_quality === false ? 7 : $ps_png_quality);
				$success = imagepng($resource, $filename, (int)7);
			break;

			case 'jpg':
			case 'jpeg':
			default:
				$quality = ($ps_jpeg_quality === false ? 90 : $ps_jpeg_quality);
				imageinterlace($resource, 1); /// make it PROGRESSIVE
				$success = imagejpeg($resource, $filename, (int)90);
			break;
		}
		imagedestroy($resource);
		@chmod($filename, 0664);
		return $success;
	}

	public static function imagecopyresampled(&$dst_image, $src_image, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h, $quality = 3)
	{
		// Plug-and-Play fastimagecopyresampled function replaces much slower imagecopyresampled.
		// Just include this function and change all "imagecopyresampled" references to "fastimagecopyresampled".
		// Typically from 30 to 60 times faster when reducing high resolution images down to thumbnail size using the default quality setting.
		// Author: Tim Eckel - Date: 09/07/07 - Version: 1.1 - Project: FreeRingers.net - Freely distributable - These comments must remain.
		//
		// Optional "quality" parameter (defaults is 3). Fractional values are allowed, for example 1.5. Must be greater than zero.
		// Between 0 and 1 = Fast, but mosaic results, closer to 0 increases the mosaic effect.
		// 1 = Up to 350 times faster. Poor results, looks very similar to imagecopyresized.
		// 2 = Up to 95 times faster.  Images appear a little sharp, some prefer this over a quality of 3.
		// 3 = Up to 60 times faster.  Will give high quality smooth results very close to imagecopyresampled, just faster.
		// 4 = Up to 25 times faster.  Almost identical to imagecopyresampled for most images.
		// 5 = No speedup. Just uses imagecopyresampled, no advantage over imagecopyresampled.

		if (empty($src_image) || empty($dst_image) || $quality <= 0)
			return false;
		if ($quality < 5 && (($dst_w * $quality) < $src_w || ($dst_h * $quality) < $src_h))
		{
			$temp = imagecreatetruecolor ($dst_w * $quality + 1, $dst_h * $quality + 1);
			imagecopyresized ($temp, $src_image, 0, 0, $src_x, $src_y, $dst_w * $quality + 1, $dst_h * $quality + 1, $src_w, $src_h);
			imagecopyresampled ($dst_image, $temp, $dst_x, $dst_y, 0, 0, $dst_w, $dst_h, $dst_w * $quality, $dst_h * $quality);
			imagedestroy ($temp);
		}
		else
			imagecopyresampled ($dst_image, $src_image, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h);
		return true;
	}

	/**
	 * Create an image with GD extension from a given type
	 *
	 * @param string $type
	 * @param string $filename
	 * @return resource
	 */
	public static function create($type, $filename)
	{
		switch ($type)
		{
			case IMAGETYPE_GIF :
				return imagecreatefromgif($filename);
			break;

			case IMAGETYPE_PNG :
				return imagecreatefrompng($filename);
			break;

			case IMAGETYPE_JPEG :
			default:
				return imagecreatefromjpeg($filename);
			break;
		}
	}

    public function resizeMe($filename, $width, $height, $newfilename = ''){
        $info = pathinfo($filename);
        $extension = $info['extension'];
        $old_image = $filename;
        $new_image = $newfilename;
        $new_info = pathinfo($newfilename);
        $only_new_filename = $new_info['basename'];
        // $get_http_catalog = self::get_http_catalog();
        $only_new_fileurl = 'image/catalog/revslider_media_folder/' . $only_new_filename;

        if (!file_exists($new_image) || (filemtime($old_image) > filemtime($new_image))) {
            $path = '';
            $directories = explode('/', dirname(str_replace('../', '', $new_image)));
            foreach ($directories as $directory) {
                $path = $path . '/' . $directory;
            }
            // $image = new Image($old_image);
            // self::resize($filename, $width, $height, $newfilename);
            // self::save($filename, $new_image);

		    $remote_file = $filename; //'http://l.yimg.com/g/images/soup_hero-04.jpg';
		    $new_width = $width;
		    $new_height = $height;
		    list($width, $height) = getimagesize($remote_file);
		    $image_p = imagecreatetruecolor($new_width, $new_height);
		    $image = imagecreatefromjpeg($remote_file);        
		    imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
		    header('Content-Type: image/jpeg'); 
		    imagejpeg($image_p, NULL, 100);
		    imagedestroy($image_p);

        }
        return $only_new_fileurl;
    }
}