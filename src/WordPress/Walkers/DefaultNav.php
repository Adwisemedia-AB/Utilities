<?php

namespace Adwisemedia\WordPress\Walkers;

class DefaultNav extends \Walker_Nav_Menu
{
    /**
     * Starts the list before the elements are added.
     *
     * @see Walker::start_lvl()
     *
     * @since 3.0.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param int    $depth  Depth of menu item. Used for padding.
     * @param array  $args   An array of arguments. @see wp_nav_menu()
     */
    public function start_lvl(&$output, $depth = 0, $args = []) // phpcs:ignore
    {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"c-nav__dropdown-menu\">\n";
    }

    /**
     * Ends the list of after the elements are added.
     *
     * @see Walker::end_lvl()
     *
     * @since 3.0.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param int    $depth  Depth of menu item. Used for padding.
     * @param array  $args   An array of arguments. @see wp_nav_menu()
     */
    public function end_lvl(&$output, $depth = 0, $args = []) // phpcs:ignore
    {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul>\n";
    }

    /**
     * Start the element output.
     *
     * @see Walker::start_el()
     *
     * @since 3.0.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param object $item   Menu item data object.
     * @param int    $depth  Depth of menu item. Used for padding.
     * @param array  $args   An array of arguments. @see wp_nav_menu()
     * @param int    $id     Current item ID.
     */
    public function start_el(&$output, $item, $depth = 0, $args = [], $id = 0) // phpcs:ignore
    {
        $indent = ( $depth ) ? str_repeat("\t", $depth) : '';

        $classes = $original_classes = empty($item->classes) ? array() : (array) $item->classes;

        if (has_acf() && get_field('nav_item_label', $item->ID)) {
            $classes = [];
            $classes[] = 'c-nav__item';
            $classes[] = 'c-nav__item--type-label';

            $class_names = join(' ', array_unique(array_filter($classes)));
            $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';
        } else {
            // Remove most core classes
            $classes = preg_replace('/(current(-menu-|[-_]page[-_])(item|parent|ancestor))/', 'is-active', $classes);
            $classes = array_filter(preg_replace('/^((menu|page)[-_\w+]+)+/', '', $classes));

            // Re-add core `menu-item` class
            array_unshift($classes, 'c-nav__item');

            if (in_array('menu-item-has-children', $original_classes)) {
                $classes[] = 'c-nav__item--children';
            }

            $remove = ['menu-item', 'menu-item-custom', 'menu-item-object-custom'];
            foreach ($classes as $class) {
                if (in_array($class, $remove)) {
                    unset($classes[ $class ]);
                }
            }

            /**
             * Filter the CSS class(es ) applied to a menu item's list item element.
             *
             * @since 3.0.0
             * @since 4.1.0 The `$depth` parameter was added.
             *
             * @param array  $classes The CSS classes that are applied to the menu item's `<li>` element.
             * @param object $item    The current menu item.
             * @param array  $args    An array of {@see wp_nav_menu()} arguments.
             * @param int    $depth   Depth of menu item. Used for padding.
             */
            $class_names = join(' ', apply_filters(
                'nav_menu_css_class',
                array_unique(array_filter($classes)),
                $item,
                $args,
                $depth
            ));

            if (in_array('menu-item-has-children', $original_classes)) {
                $class_names .= ' c-nav__dropdown';
            }

            $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';
        }

        // New
        $output .= $indent . '<li' . $class_names . '>';

        $item_output = $args->before;


        if (has_acf() && get_field('nav_item_label', $item->ID)) {
            $item_output .= '<div class="c-nav__item-label">';
            $item_output .= $args->link_before;
            $item_output .= apply_filters('the_title', $item->title, $item->ID);
            $item_output .= $args->link_after;
            $item_output .= '</div>';
        } else {
            $atts = [];
            $atts['title']  = ! empty($item->attr_title) ? $item->attr_title : '';
            $atts['target'] = ! empty($item->target)     ? $item->target     : '';
            $atts['rel']    = ! empty($item->xfn)        ? $item->xfn        : '';
            $atts['href']   = ! empty($item->url)        ? $item->url        : '';

            // New
            if ($depth === 0) {
                $atts['class'] = 'c-nav__link';
            }

            if ($depth === 0 && in_array('menu-item-has-children', $original_classes)) {
                $atts['class'] .= ' c-nav__dropdown-toggle';
            }

            if ($depth > 0) {
                $atts['class'] = 'c-nav__link';
                $atts['class'] .= ' c-nav__dropdown-item';
            }

            if ($item->current) {
                $atts['class'] .= ' is-active';
            }

            /**
             * Filter the HTML attributes applied to a menu item's anchor element.
             *
             * @since 3.6.0
             * @since 4.1.0 The `$depth` parameter was added.
             *
             * @param array $atts {
             *     The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
             *
             *     @type string $title  Title attribute.
             *     @type string $target Target attribute.
             *     @type string $rel    The rel attribute.
             *     @type string $href   The href attribute.
             * }
             * @param object $item  The current menu item.
             * @param array  $args  An array of {@see wp_nav_menu()} arguments.
             * @param int    $depth Depth of menu item. Used for padding.
             */
            $atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args, $depth);

            $attributes = '';
            foreach ($atts as $attr => $value) {
                if (! empty($value)) {
                    $value = ( 'href' === $attr ) ? esc_url($value) : esc_attr($value);
                    $attributes .= ' ' . $attr . '="' . $value . '"';
                }
            }

            $item_output .= '<a' . $attributes . '>';
            $item_output .= $args->link_before;
            $item_output .= apply_filters('the_title', $item->title, $item->ID);
            $item_output .= $args->link_after;
            $item_output .= '</a>';
        }

        $item_output .= $args->after;

        /**
         * Filter a menu item's starting output.
         *
         * The menu item's starting output only includes `$args->before`, the opening `<a>`,
         * the menu item's title, the closing `</a>`, and `$args->after`. Currently, there is
         * no filter for modifying the opening and closing `<li>` for a menu item.
         *
         * @since 3.0.0
         *
         * @param string $item_output The menu item's starting HTML output.
         * @param object $item        Menu item data object.
         * @param int    $depth       Depth of menu item. Used for padding.
         * @param array  $args        An array of {@see wp_nav_menu()} arguments.
         */
        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }

    /**
     * Ends the element output, if needed.
     *
     * @see Walker::end_el()
     *
     * @since 3.0.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param object $item   Page data object. Not used.
     * @param int    $depth  Depth of page. Not Used.
     * @param array  $args   An array of arguments. @see wp_nav_menu()
     */
    public function end_el(&$output, $item, $depth = 0, $args = []) // phpcs:ignore
    {
        if (isset($args->has_children) && $depth === 0) {
            $output .= "</li>\n";
        }
    }
}
