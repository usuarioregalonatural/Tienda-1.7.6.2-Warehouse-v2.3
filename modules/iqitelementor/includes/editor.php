<?php
namespace Elementor;

if ( ! defined( 'ELEMENTOR_ABSPATH' ) ) exit; // Exit if accessed directly

class Editor {

    public function is_edit_mode() {

        if ( isset( $_GET['controller']  ) && $_GET['controller']  == 'IqitElementorEditor' ) {
            return true;
        }

        return false;
    }

    public function print_panel_html() {

        include( 'editor-templates/editor-wrapper.php' );
        include( 'editor-templates/panel.php' );
        include( 'editor-templates/panel-elements.php' );
        include( 'editor-templates/repeater.php' );
        include( 'editor-templates/templates.php' );

        PluginElementor::instance()->controls_manager->render_controls();
        PluginElementor::instance()->widgets_manager->render_widgets_content();
        PluginElementor::instance()->elements_manager->render_elements_content();

    }
}
