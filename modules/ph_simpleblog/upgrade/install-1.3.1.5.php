<?php
/**
 * Blog for PrestaShop module by Krystian Podemski from PrestaHome.
 *
 * @author    Krystian Podemski <krystian@prestahome.com>
 * @copyright Copyright (c) 2014-2016 Krystian Podemski - www.PrestaHome.com / www.Podemski.info
 * @license   You only can use module, nothing more!
 */
if (!defined('_PS_VERSION_')) {
    exit;
}

function upgrade_module_1_3_1_5($object)
{
    $default_post_type = new SimpleBlogPostType();
    $default_post_type->name = 'Post';
    $default_post_type->slug = 'post';
    $default_post_type->description = 'Default type of post';
    $default_post_type->add();

    $gallery_post_type = new SimpleBlogPostType();
    $gallery_post_type->name = 'Gallery';
    $gallery_post_type->slug = 'gallery';
    $gallery_post_type->add();

    $external_url_post_type = new SimpleBlogPostType();
    $external_url_post_type->name = 'External URL';
    $external_url_post_type->slug = 'url';
    $external_url_post_type->add();

    $video_post_type = new SimpleBlogPostType();
    $video_post_type->name = 'Video';
    $video_post_type->slug = 'video';
    $video_post_type->add();

    return true;
}
