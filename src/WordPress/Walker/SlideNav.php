<?php

namespace Adwisemedia\WordPress\Walker;

class SlideNav extends \Walker_Nav_Menu
{

    // Add classes to ul sub-menus
    public function start_lvl(&$output, $depth = 0, $args = []) // phpcs:ignore
    {
        // depth dependent classes
        $indent = ( $depth > 0  ? str_repeat("\t", $depth) : '' ); // code indent
        $display_depth = ( $depth + 1 ); // because it counts the first submenu as 0

        $classes = [
            'c-nav__sub-menu is-hidden',
            ( $display_depth >= 2 ? 'c-nav__sub-sub-menu is-hidden' : '' ),
            'menu-depth-' . $display_depth
        ];

        $class_names = implode(' ', $classes);
        $output .= "\n" . $indent . '<ul class="' . $class_names . '">';
        $output .= '<li class="c-nav__go-back">';
        $output .= '<a class="c-nav__link c-nav__sub-link c-nav__go-back-link" href="#0">';
        $output .= __('Back', 'regnbagsfonden');
        $output .= '</a>' . "\n";
    }

    // add main/sub classes to li's and links
    public function start_el(&$output, $item, $depth = 0, $args = [], $id = 0) // phpcs:ignore
    {
        global $wp_query;

        // htmlentities( pp( $item ) );

        $indent = ( $depth > 0 ? str_repeat("\t", $depth) : '' ); // code indent

        $args = ( is_array($args) && empty($args) ) ? new stdClass() : (object) $args ;
        $args->before = ! isset($args->before) ? '' : $args->before;
        $args->after = ! isset($args->after) ? '' : $args->after;
        $args->link_before = ! isset($args->link_before) ? '' : $args->link_before;
        $args->link_after = ! isset($args->link_after) ? '' : $args->link_after;

        // depth dependent classes
        $depth_classes = array(
            ( $depth == 0 ? '' : 'c-nav__sub-item' ),
            ( $depth >= 2 ? 'c-nav__sub-sub-item c-nav__item has-children' : '' ),
            'c-nav__item--depth-' . $depth
        );

        $depth_class_names = esc_attr(implode(' ', $depth_classes));

        $item->classes = ! is_array($item->classes) ? (array) $item->classes : $item->classes;
        $item->classes[] = 'c-nav__item';
        if (in_array('menu-item-has-children', $item->classes, true)) {
            $item->classes[] .= 'c-nav__item has-children';
        }

        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes = preg_replace('/(current(-menu-|[-_]page[-_])(item|parent|ancestor))/', 'is-active', $classes);
        $classes = array_filter(preg_replace('/^((menu|page)[-_\w+]+ )+/', '', $classes));

        $remove = ['menu-item', 'menu-item-custom', 'menu-item-object-custom'];
        foreach ($classes as $class) {
            if (in_array($class, $remove)) {
                unset($classes[ $class ]);
            }
        }

        $classes = array_unique($classes);
        $class_names = esc_attr(implode(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item)));

        // build html
        $output .= $indent . '<li class="' . $class_names . ' ' . $depth_class_names . '">';

        // link attributes
        $attributes  = ! empty($item->attr_title) ? ' title="'  . esc_attr($item->attr_title) . '"' : '';
        $attributes .= ! empty($item->target)     ? ' target="' . esc_attr($item->target) . '"' : '';
        $attributes .= ! empty($item->xfn)        ? ' rel="'    . esc_attr($item->xfn) . '"' : '';
        $attributes .= ! empty($item->url)        ? ' href="'   . esc_attr($item->url) . '"' : '';
        $attributes .= ' class="' . ( $depth > 0 ? 'c-nav__link c-nav__sub-link' : 'c-nav__link' ) . '"';

        $title = isset($item->title) && $item->title !== '' ? $item->title : $item->post_title;

        $item_output = sprintf(
            '%1$s<a%2$s>%3$s%4$s%5$s</a>%6$s',
            $args->before,
            $attributes,
            $args->link_before,
            apply_filters('the_title', $title, $item->ID),
            $args->link_after,
            $args->after
        );

        // build html
        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth = 0, $args = array(), $id = 0);
    }
}
