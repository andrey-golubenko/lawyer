<?php
function lawyer_the_breadcrumb(){
	global $post;
	if(!is_home()){
		echo '<span class="mr-2"> <a href=" '.site_url().' ">Главная <i class="ion-ios-arrow-forward"></i></a></span>';
		if(is_single()){ // записи
			echo '<span class="mr-2">' . get_the_category_list(', ') . ' <i class="ion-ios-arrow-forward"></i></span>';
			echo '<span class="mr-2">' . the_title() . '</span>';
		}
		elseif (is_page()) { // страницы
			if ($post->post_parent ) {
				$parent_id  = $post->post_parent;
				$breadcrumbs = array();
				while ($parent_id) {
					$page = get_page($parent_id);
					$breadcrumbs[] = '<span class="mr-2"><a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '  <i class="ion-ios-arrow-forward"></i></a></span>';
					$parent_id  = $page->post_parent;
				}
				$breadcrumbs = array_reverse($breadcrumbs);
				foreach ($breadcrumbs as $crumb) echo $crumb;
			}
			echo the_title() . ' <i class="ion-ios-arrow-forward"></i>' ;
		}
		elseif (is_category()) { // категории
			global $wp_query;
			$obj_cat = $wp_query->get_queried_object();
			$current_cat = $obj_cat->term_id;
			$current_cat = get_category($current_cat);
			$parent_cat = get_category($current_cat->parent);
			if ($current_cat->parent != 0)
				echo(get_category_parents($parent_cat, TRUE, ' <i class="ion-ios-arrow-forward"></i> '));
			echo single_cat_title('<span class="mr-2">') . '</span>';
		}
		elseif (is_search()) { // страницы поиска
			echo 'Результаты поиска для "' . get_search_query() . '"';
		}
		elseif (is_tag()) { // теги (метки)
			echo ' <span class="mr-2">' . single_tag_title('', false)  . '</span>';
		}
		elseif (is_day()) { // архивы (по дням)
			echo '<span class="mr-2"><a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . ' <i class="ion-ios-arrow-forward"></i></a></span>  ';
			echo '<span class="mr-2"><a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . ' <i class="ion-ios-arrow-forward"></i></a></span> ';
			echo '<span class="mr-2">' . get_the_time('d') . '</span>';
		}
		elseif (is_month()) { // архивы (по месяцам)
			echo '<span class="mr-2"><a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . ' <i class="ion-ios-arrow-forward"></i></a></span>';
			echo '<span class="mr-2">' . get_the_time('F') . '</span> ';
		}
		elseif (is_year()) { // архивы (по годам)
			echo ' <span class="mr-2">' . get_the_time('Y') . '</span>';
		}
		elseif (is_author()) { // авторы
			global $author;
			$userdata = get_userdata($author);
			echo ' <span class="mr-2">Опубликовал(а) ' . $userdata->display_name . '</span>';
		} elseif (is_404()) { // если страницы не существует
			echo 'Ошибка 404';
		}

		if (get_query_var('paged')) // номер текущей страницы
			echo ' (' . get_query_var('paged').'-я страница)';

	} else { // главная
		$pageNum=(get_query_var('paged')) ? get_query_var('paged') : 1;
		if($pageNum>1)
			echo '<span class="mr-2"><a href="'.site_url().'">Главная <i class="ion-ios-arrow-forward"></i></a></span><span class="mr-2"> '.$pageNum.'-я страница</span>';
		else
			echo '<span class="mr-2">Вы находитесь на Главной странице</span>>';
	}
}