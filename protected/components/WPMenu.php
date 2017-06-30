<?php
class WPMenu extends CWidget
{
    var $topmname = 'DigiscendMain';
    var $special_a_class;
    /**
     *
     * @var TP_MenuItem
     */
    var $menuitem;
    public function init()
    {
        if (defined ( 'UNIT_TESTING' ))
        {
            return;
        }
        class_exists ( 'WPBootstrapNavWalker' );
        // this method is called by CController::beginWidget()
    }
    public function run()
    {
        if (defined ( 'UNIT_TESTING' ))
        {
            return;
        }

        if ('test' == Yii::app ()->params ['runmode'])
        {
            global $wpdb;
            $wpdb->db_connect ();
            // return;
        }

        Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/css/wp-menu.css');

        if(!empty(Yii::app()->params['translatedMenus'][Yii::app()->language]))
            $this->topmname = Yii::app()->params['translatedMenus'][Yii::app()->language];

        $w2 = new WPBootstrapNavWalker ();
        // 201210051155:vikas:#152 changed home icon from hard coded to config file
        $w2->special_a_class [Yii::app ()->params ['wp-home-menu-id']] = 'home-icon';

        $defaults = array (
                'theme_location' => '',
                'menu' => $this->topmname,
                'container' => 'nav',
                'container_class' => 'collapse navbar-collapse',
                'container_id' => 'main-nav-collapse',
                'menu_class' => 'nav navbar-nav navbar-right',
                'menu_id' => '',
                'echo' => true,
                'fallback_cb' => 'wp_page_menu',
                'before' => '',
                'after' => '',
                'link_before' => '',
                'link_after' => '',
                'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                'depth' => 0,
                'walker' => $w2
        );

        // just mark the flyouts in ths run but don't render
        ob_start ();
        wp_nav_menu ( $defaults );
        $xml = ob_get_contents ();
        ob_end_clean ();

        // use the markings and render flyouts
        ob_start ();
        wp_nav_menu ( $defaults );
        $xml = ob_get_contents ();
        ob_end_clean ();

        echo $xml;
    }
}
