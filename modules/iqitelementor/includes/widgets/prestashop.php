<?php
namespace Elementor;

if (!defined('ELEMENTOR_ABSPATH')) {
    exit;
} // Exit if accessed directly

class Widget_Prestashop extends Widget_Base
{

    /**
     * @var string
     */
    private $_widget_name = null;

    /**
     * @var Object
     */
    private $_widget_instance = null;

    private function _get_widget_instance()
    {
        if (is_null($this->_widget_instance)) {
            $this->_widget_instance = \IqitElementorWpHelper::getIqitElementorWidgetInstance($this->_widget_name);
        }
        return $this->_widget_instance;
    }

    public function get_id()
    {
        return 'prestashop-widget-' . $this->_get_widget_instance()->id_base;
    }

    public function get_title()
    {
        return $this->_get_widget_instance()->name;
    }

    public function get_categories()
    {
        $category = 'prestashop';
        return [$category];
    }

    public function get_icon()
    {
        return $this->_get_widget_instance()->icon;
    }

    public function get_parse_values($instance = [])
    {
        $instance = parent::get_parse_values($instance);

        return $instance;
    }

    protected function _register_controls()
    {

            $controls = $this->_get_widget_instance()->getForm();

            foreach ($controls as $key => $control) {
                if (isset($control['responsive'])) {
                    $this->add_responsive_control(
                        $key,
                        $control
                    );
                } elseif (isset($control['group_type_control'])) {
                    $this->add_group_control(
                        $control['group_type_control'],
                        $control
                    );
                } else {
                    $this->add_control(
                        $key,
                        $control
                    );
                }
            }

    }

    protected function render($instance = [])
    {

        $options = $this->get_parse_values($instance);


        if (PluginElementor::instance()->editor->is_edit_mode()) {
            echo \IqitElementorWpHelper::renderIqitElementorWidgetPreview($this->_get_widget_instance()->id_base,
                $options);
        } else {
            echo \IqitElementorWpHelper::renderIqitElementorWidget($this->_get_widget_instance()->id_base, $options);
        }
    }

    protected function content_template()
    {
    }

    public function __construct($args = [])
    {
        $this->_widget_name = $args['widget_name'];

        parent::__construct($args);
    }

    public function render_plain_content($instance = [])
    {
    }
}
