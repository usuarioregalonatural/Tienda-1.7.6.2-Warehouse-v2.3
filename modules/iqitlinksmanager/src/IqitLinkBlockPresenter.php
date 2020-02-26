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

class IqitLinkBlockPresenter
{
    private $link;
    private $language;

    public function __construct(Link $link, Language $language)
    {
        $this->link = $link;
        $this->language = $language;
    }

    public function present(IqitLinkBlock $cmsBlock)
    {
        return array(
            'id' => (int)$cmsBlock->id,
            'title' => $cmsBlock->name[(int)$this->language->id],
            'hook' => (new Hook((int)$cmsBlock->id_hook))->name,
            'position' => $cmsBlock->position,
            'links' => $this->makeLinks($cmsBlock->content),
        );
    }

    public function makeLinks($content)
    {
        foreach ($content as $key => $page) {
            if ($page['type'] == 'custom') {
                $content[$key]['data'] = $this->makeCustomLink($page);
            }
            if ($page['type'] == 'static') {
                $content[$key]['data'] = $this->makeStaticLink($page['id']);
            } elseif ($page['type'] == 'cms_category') {
                $content[$key]['data'] = $this->makeCmsCategoryLink($page['id']);
            } elseif ($page['type'] == 'cms_page') {
                $content[$key]['data'] = $this->makeCmsPageLink($page['id']);
            } elseif ($page['type'] == 'category') {
                $content[$key]['data'] = $this->makeCategoryLink($page['id']);
            }
        }
        return $content;
    }

    private function makeCategoryLink($id)
    {
        $cmsLink = array();

        $cat = new Category((int)$id);

        if (null !== $cat->id) {
            $cmsLink = array(
                'title' => $cat->name[(int)$this->language->id],
                'description' => $cat->meta_description[(int)$this->language->id],
                'url' => $cat->getLink(),
            );
        }
        return $cmsLink;
    }

    private function makeCmsPageLink($cmsId)
    {
        $cmsLink = array();

        $cms = new CMS((int)$cmsId);
        if (null !== $cms->id) {
            $cmsLink = array(
                'title' => $cms->meta_title[(int)$this->language->id],
                'description' => $cms->meta_description[(int)$this->language->id],
                'url' => $this->link->getCMSLink($cms),
                );
        }
        return $cmsLink;
    }

    private function makeCmsCategoryLink($cmsId)
    {
        $cmsLink = array();

        $cms = new CMSCategory((int)$cmsId);
        if (null !== $cms->id) {
            $cmsLink = array(
                'title' => $cms->name[(int)$this->language->id],
                'description' => $cms->meta_description[(int)$this->language->id],
                'url' => $this->link->getCMSCategoryLink($cms),
                );
        }
        return $cmsLink;
    }

    private function makeCustomLink($page)
    {
        $cmsLink = array(
                'title' => $page['title'][(int)$this->language->id],
                'url' => $page['url'][(int)$this->language->id],
        );
        
        return $cmsLink;
    }

    private function makeStaticLink($staticId)
    {
        $staticLink = array();

        $meta = Meta::getMetaByPage($staticId, (int)$this->language->id);
        $staticLink = array(
            'title' => $meta['title'],
            'description' => $meta['description'],
            'url' => $this->link->getPageLink($staticId, true),
            );

        return $staticLink;
    }
}
