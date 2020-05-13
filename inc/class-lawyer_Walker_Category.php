<?php
class Lawyer_Walker_Category extends Walker_Category {
	public $tree_type = 'category';
	public $db_fields = array(
		'parent' => 'parent',
		'id'     => 'term_id',
	);
	public function start_lvl( &$output, $depth = 0, $args = array() ) {
		parent::start_lvl($output, $depth, $args);
	}
	public function end_lvl( &$output, $depth = 0, $args = array() ) {
		parent::end_lvl($output, $depth, $args);
	}
	public function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) {
		$cat_name = apply_filters( 'list_cats', esc_attr( $category->name ), $category );
		// Don't generate an element if the category name is empty.
		if ( '' === $cat_name ) { return; }

		$atts         = array();
		$atts['href'] = get_term_link( $category );

		if ( $args['use_desc_for_title'] && ! empty( $category->description ) ) {
			/* Filters the category description for display. */
			$atts['title'] = strip_tags( apply_filters( 'category_description', $category->description, $category ) );
		}
		/* Filters the HTML attributes applied to a category list item's anchor element. */
		$atts = apply_filters( 'category_list_link_attributes', $atts, $category, $depth, $args, $id );

		$attributes = '';
		foreach ( $atts as $attr => $value ) {
			if ( is_scalar( $value ) && '' !== $value && false !== $value ) {
				$value       = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
				$attributes .= ' ' . $attr . '="' . $value . '"';
			}
		}

		$link = sprintf(
			'<a%s>%s <span class="ion-ios-arrow-forward"></span></a>',
			$attributes,
			$cat_name
		);

		if ( ! empty( $args['feed_image'] ) || ! empty( $args['feed'] ) ) {
			$link .= ' ';

			if ( empty( $args['feed_image'] ) ) {
				$link .= '(';
			}

			$link .= '<a href="' . esc_url( get_term_feed_link( $category->term_id, $category->taxonomy, $args['feed_type'] ) ) . '"';

			if ( empty( $args['feed'] ) ) {
				/* translators: %s: Category name. */
				$alt = ' alt="' . sprintf( __( 'Feed for all posts filed under %s', 'lawyer' ), $cat_name ) . '"';
			} else {
				$alt   = ' alt="' . $args['feed'] . '"';
				$name  = $args['feed'];
				$link .= empty( $args['title'] ) ? '' : $args['title'];
			}

			$link .= '>';

			if ( empty( $args['feed_image'] ) ) {
				$link .= $name;
			} else {
				$link .= "<img src='" . esc_url( $args['feed_image'] ) . "'$alt" . ' />';
			}
			$link .= '</a>';

			if ( empty( $args['feed_image'] ) ) {
				$link .= ')';
			}
		}

		if ( ! empty( $args['show_count'] ) ) {
			$link .= ' (' . number_format_i18n( $category->count ) . ')';
		}
		if ( 'list' == $args['style'] ) {
			$output     .= "\t<li";
			$css_classes = array(
				'cat-item',
				'cat-item-' . $category->term_id,
			);

			if ( ! empty( $args['current_category'] ) ) {
				// 'current_category' can be an array, so we use `get_terms()`.
				$_current_terms = get_terms(
					array(
						'taxonomy'   => $category->taxonomy,
						'include'    => $args['current_category'],
						'hide_empty' => false,
					)
				);
				foreach ( $_current_terms as $_current_term ) {
					if ( $category->term_id == $_current_term->term_id ) {
						$css_classes[] = 'current-cat';
						$link          = str_replace( '<a', '<a aria-current="page"', $link );
					} elseif ( $category->term_id == $_current_term->parent ) {
						$css_classes[] = 'current-cat-parent';
					}
					while ( $_current_term->parent ) {
						if ( $category->term_id == $_current_term->parent ) {
							$css_classes[] = 'current-cat-ancestor';
							break;
						}
						$_current_term = get_term( $_current_term->parent, $category->taxonomy );
					}
				}
			}
			/* Filters the list of CSS classes to include with each category in the list. */
			$css_classes = implode( ' ', apply_filters( 'category_css_class', $css_classes, $category, $depth, $args ) );
			$css_classes = $css_classes ? ' class="' . esc_attr( $css_classes ) . '"' : '';
			$output .= $css_classes;
			$output .= ">$link\n";
		} elseif ( isset( $args['separator'] ) ) {
			$output .= "\t$link" . $args['separator'] . "\n";
		} else {
			$output .= "\t$link<br />\n";
		}
	}

	public function end_el( &$output, $page, $depth = 0, $args = array() ) {
		parent::end_el($output, $page, $depth, $args);
	}
}