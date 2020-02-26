<?php
/**
 * 2017 IQIT-COMMERCE.COM
 *
 * NOTICE OF LICENSE
 *
 * This file is licenced under the Software License Agreement.
 * With the purchase or the installation of the software in your application
 * you accept the licence agreement
 *
 *  @author    IQIT-COMMERCE.COM <support@iqit-commerce.com>
 *  @copyright 2017 IQIT-COMMERCE.COM
 *  @license   Commercial license (You can not resell or redistribute this software.)
 *
 */

class IqitHtmlAndBannerPresenter
{
    private $language;

    public function __construct(Language $language)
    {
        $this->language = $language;
    }

    public function present(IqitHtmlAndBanner $block)
    {
        return array(
            'id' => (int)$block->id,
            'title' => $block->name,
            'hook' => (new Hook((int)$block->id_hook))->name,
            'width' => $block->width,
            'position' => $block->position,
            'type' => $block->type,
            'content' => $this->makeContent($block->content, $block->description, $block->type),
        );
    }

    public function makeContent($content, $description, $type)
    {
        if ($type == 1) {
            $content = $description;
        } else {
            $content = $this->makeSlider($content);
        }

        return $content;
    }

    public function makeSlider($content)
    {
        $context = Context::getContext();
        $bannersFull = array();
        $banners = array();

        if (isset($content['banners']) && is_array($content['banners'])){
            foreach ($content['banners'] as $key => $banner) {
                if ($banner['status']) {
                    if ($banner['language'] == 'all' || $banner['language'] == $context->language->id) {
                        $banners[$key]['image'] = $context->link->getMediaLink(_MODULE_DIR_.'iqithtmlandbanners/uploads/images/'.$banner['img']);
                        $banners[$key]['link'] = $banner['url'];
                    }
                }
            }
        }

        $bannersFull['banners'] = $banners;
        $bannersFull['options'] = $content['options'];
        return $bannersFull;
    }
}
