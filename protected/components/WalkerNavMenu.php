<?php

class WalkerNavMenu1 extends Walker
{
    var $special_a_class;
    var $uctr = 0;

    /**
     * @see Walker::$tree_type
     * @since 3.0.0
     * @var string
     */
    var $tree_type = array( 'post_type', 'taxonomy', 'custom' );

    /**
     * @see Walker::$db_fields
     * @since 3.0.0
     * @todo Decouple this.
     * @var array
     */
    var $db_fields = array( 'parent' => 'menu_item_parent', 'id' => 'db_id' );

    /**
     * @see Walker::start_lvl()
     * @since 3.0.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param int $depth Depth of page. Used for padding.
     */
    function start_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat("\t", $depth);
        $this->uctr++;
        #20141101:#151:vikas:lima:changes that will allow bootstrap compatible dropdown system
        $output .= "\n$indent<ul  class=\"dropdown-menu\" role=\"menu\" >\n";
    }

    /**
     * @see Walker::end_lvl()
     * @since 3.0.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param int $depth Depth of page. Used for padding.
     */
    function end_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul>\n";
    }

    /**
     * @see Walker::start_el()
     * @since 3.0.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param object $item Menu item data object.
     * @param int $depth Depth of menu item. Used for padding.
     * @param int $current_page Menu item ID.
     * @param object $args
     */
    function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        if($item->menu_item_parent > 0)
        {
            $this->parents[$item->menu_item_parent][$item->ID] = $item->ID    ;
            $this->page2parent[$item->ID] = $item->menu_item_parent;
        }

        global $wp_query;
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

        $class_names = $value = '';

        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;

        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );

        #20141101:#151:vikas:lima:changes that will allow bootstrap compatible dropdown system
        if(isset($this->parents[$item->ID]))
            $class_names .= ' dropdown';

        $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

        $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
        $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

        $output .= $indent . '<li' . $id . $value . $class_names .'>';

        if(substr($item->url,0,4) != 'http')
        	$item->url = Yii::app()->request->baseUrl . $item->url;

        list($item->attr_title,$faicon) = explode('|',$item->attr_title . '|',3);

        $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
        $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
        $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
        $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

        $dropdown_link_after = "";
        if(isset($this->special_a_class[$item->ID]))
        	$attributes .= ' class="'   . esc_attr( $this->special_a_class[$item->ID]        ) .'"';
        #20141101:#151:vikas:lima:changes that will allow bootstrap compatible dropdown system
        else if(isset($this->parents[$item->ID]))
        {
            $attributes .= ' class="dropdown-toggle" data-toggle="dropdown" ';
            $dropdown_link_after = ' <span class="caret"></span>';
        }
        $item_output = $args->before;
        $item_output .= '<a'. $attributes .'>';
    	if(!empty($faicon))
        {
        	$item_output .= "<i class=\"fa $faicon theme-color\"></i>&nbsp;";

        }
        $item_output .= $args->link_before . apply_filters( 'the_title', __($item->title), $item->ID ) . $args->link_after . $dropdown_link_after;
        $item_output .= '</a>';
        $item_output .= $args->after;

        #20141101:#151:vikas:lima:changes that will allow bootstrap compatible dropdown system
        #if(isset($this->parents[$item->ID]))
        #	$item_output .= '<a class="flyout-toggle" href="#"><span> </span></a>';

        $post_name = $item->post_name;
        if($item->ID != $item->object_id)
        {
        	$post = wp_get_single_post($item->object_id);
        	$post_name = $post->post_name;
        }

		$this->alltitles[$item->ID]=array($item->title,$item->url,$item);
		$this->allpostnames[$post_name] = $item->ID;
        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }

    /**
     * @see Walker::end_el()
     * @since 3.0.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param object $item Page data object. Not used.
     * @param int $depth Depth of page. Not Used.
     */
    function end_el( &$output, $item, $depth = 0, $args = array() ) {
        $output .= "</li>\n";
    }
}
