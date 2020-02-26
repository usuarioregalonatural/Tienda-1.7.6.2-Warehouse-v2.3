<?php
namespace Elementor;

if ( ! defined( 'ELEMENTOR_ABSPATH' ) ) exit; // Exit if accessed directly


/**
 * Main class plugin
 */
class PluginElementor {

	/**
	 * @var PluginElementor
	 */
    private static $_instance = null;

	/**
	 * @return string
	 */
	public function get_version() {
		return ELEMENTOR_VERSION;
	}

    public function __clone() {}

    /**
     * Disable unserializing of the class
     *
     * @since 1.0.0
     * @return void
     */
    public function __wakeup() {
        // Unserializing instances of the class is forbidden
        \IqitElementorWpHelper::_doing_it_wrong( __FUNCTION__, \IqitElementorWpHelper::__( 'Cheatin&#8217; huh?', 'elementor' ), '1.0.0' );
    }

    /**
     * @return PluginElementor
     */
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();

        }
        return self::$_instance;
    }

    public function get_current_introduction() {
        return [
            'active' => true,
            'title' => '<div id="elementor-introduction-title">' .
                \IqitElementorWpHelper::__( 'Two Minute Tour Of Elementor', 'elementor' ) .
                '</div><div id="elementor-introduction-subtitle">' .
                \IqitElementorWpHelper::__( 'Watch this quick tour that gives you a basic understanding of how to use Elementor.', 'elementor' ) .
                '</div>',
            'content' => '<div class="elementor-video-wrapper"><iframe src="https://www.youtube.com/embed/6u45V2q1s4k?autoplay=1&rel=0&showinfo=0" frameborder="0" allowfullscreen></iframe></div>',
            'delay' => 2500,
            'version' => 1,
        ];
    }
    public function get_frontend($data) {
        $this->frontend = new Frontend($data);
    }

	/**
	 * Register the CPTs with our Editor support.
	 */
	public function init() {}

	private function _includes() {

        include_once( ELEMENTOR_PATH . 'includes/utils-elementor.php' );
        include_once( ELEMENTOR_PATH . 'includes/fonts.php' );
        include_once( ELEMENTOR_PATH . 'includes/controls-manager.php' );
        include_once( ELEMENTOR_PATH . 'includes/schemes-manager.php' );
        include_once( ELEMENTOR_PATH . 'includes/elements-manager.php' );
        include_once( ELEMENTOR_PATH . 'includes/widgets-manager.php' );
        include_once( ELEMENTOR_PATH . 'includes/editor.php' );
        include_once( ELEMENTOR_PATH . 'includes/frontend.php' );
        include_once( ELEMENTOR_PATH . 'includes/responsive.php' );
        include_once( ELEMENTOR_PATH . 'includes/stylesheet.php' );

	}

	/**
	 * PluginElementor constructor.
	 */
    private function __construct() {

        self::$_instance = $this;
		$this->_includes();

		$this->controls_manager = new Controls_Manager();
		$this->schemes_manager = new Schemes_Manager();
		$this->elements_manager = new Elements_Manager();
		$this->widgets_manager = new Widgets_Manager();
        $this->editor = new Editor();
	}

}


