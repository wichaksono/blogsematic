<?php
/**
 * BlogSemantic functions and definitions
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Theme setup
 */
function blogsemantic_setup() {
    // Add theme support for title tag
    add_theme_support('title-tag');

    // Add theme support for post thumbnails
    add_theme_support('post-thumbnails');

    // Add theme support for HTML5
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));

    // Add theme support for custom logo
    add_theme_support('custom-logo', array(
        'height'      => 60,
        'width'       => 200,
        'flex-height' => true,
        'flex-width'  => true,
    ));

    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'blogsemantic'),
        'footer'  => __('Footer Menu', 'blogsemantic'),
    ));
}
add_action('after_setup_theme', 'blogsemantic_setup');

/**
 * Enqueue scripts and styles
 */
function blogsemantic_scripts() {
    // Enqueue Bootstrap CSS
    wp_enqueue_style('bootstrap', 'https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css', array(), '5.3.0');

    // Enqueue Bootstrap Icons
    wp_enqueue_style('bootstrap-icons', 'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css', array(), '1.10.0');

    // Enqueue theme style
    wp_enqueue_style('blogsemantic-style', get_stylesheet_uri(), array('bootstrap'), wp_get_theme()->get('Version'));

    // Enqueue Bootstrap JS
    wp_enqueue_script('bootstrap', 'https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js', array(), '5.3.0', true);

    // Enqueue theme script
    wp_enqueue_script('blogsemantic-script', get_template_directory_uri() . '/assets/js/theme.js', array('bootstrap'), wp_get_theme()->get('Version'), true);

    // Localize script for AJAX
    wp_localize_script('blogsemantic-script', 'blogsemantic_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('blogsemantic_nonce'),
    ));
}
add_action('wp_enqueue_scripts', 'blogsemantic_scripts');

/**
 * Register widget areas
 */
function blogsemantic_widgets_init() {
    // Primary Sidebar
    register_sidebar(array(
        'name'          => __('Primary Sidebar', 'blogsemantic'),
        'id'            => 'sidebar-1',
        'description'   => __('Add widgets here to appear in your sidebar.', 'blogsemantic'),
        'before_widget' => '<div class="sidebar-widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ));

    // Footer Widget Areas
    for ($i = 1; $i <= 4; $i++) {
        register_sidebar(array(
            'name'          => sprintf(__('Footer Widget Area %d', 'blogsemantic'), $i),
            'id'            => 'footer-' . $i,
            'description'   => sprintf(__('Footer widget area %d', 'blogsemantic'), $i),
            'before_widget' => '<div class="footer-widget">',
            'after_widget'  => '</div>',
            'before_title'  => '<h5 class="footer-title">',
            'after_title'   => '</h5>',
        ));
    }
}
add_action('widgets_init', 'blogsemantic_widgets_init');

/**
 * Custom excerpt length
 */
function blogsemantic_excerpt_length($length) {
    return 20;
}
add_filter('excerpt_length', 'blogsemantic_excerpt_length');

/**
 * Custom excerpt more
 */
function blogsemantic_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'blogsemantic_excerpt_more');

/**
 * Get featured posts
 */
function blogsemantic_get_featured_posts($limit = 3) {
    $args = array(
        'post_type'      => 'post',
        'posts_per_page' => $limit,
        'meta_query'     => array(
            array(
                'key'     => '_blogsemantic_featured',
                'value'   => '1',
                'compare' => '='
            )
        )
    );

    $featured_posts = get_posts($args);

    // If no featured posts, get latest posts
    if (empty($featured_posts)) {
        $args = array(
            'post_type'      => 'post',
            'posts_per_page' => $limit,
            'orderby'        => 'date',
            'order'          => 'DESC'
        );
        $featured_posts = get_posts($args);
    }

    return $featured_posts;
}

/**
 * Get popular posts
 */
function blogsemantic_get_popular_posts($limit = 5) {
    $args = array(
        'post_type'      => 'post',
        'posts_per_page' => $limit,
        'meta_key'       => 'post_views_count',
        'orderby'        => 'meta_value_num',
        'order'          => 'DESC'
    );

    $popular_posts = get_posts($args);

    // If no view count, get latest posts
    if (empty($popular_posts)) {
        $args = array(
            'post_type'      => 'post',
            'posts_per_page' => $limit,
            'orderby'        => 'comment_count',
            'order'          => 'DESC'
        );
        $popular_posts = get_posts($args);
    }

    return $popular_posts;
}

/**
 * Track post views with protection (1 visitor per day per post)
 */
function blogsemantic_track_post_views($post_id) {
    if (!is_single()) return;
    if (empty($post_id)) {
        global $post;
        $post_id = $post->ID;
    }

    // Get visitor IP and user agent for unique identification
    $visitor_ip = $_SERVER['REMOTE_ADDR'];
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    $visitor_hash = md5($visitor_ip . $user_agent);

    // Create unique key for this visitor and post
    $view_key = 'post_view_' . $post_id . '_' . $visitor_hash;

    // Check if this visitor has already viewed this post today
    $today = date('Y-m-d');
    $last_viewed = get_transient($view_key);

    // If not viewed today, count the view
    if ($last_viewed !== $today) {
        $views = get_post_meta($post_id, 'post_views_count', true);
        $views = empty($views) ? 0 : $views;
        $views++;

        update_post_meta($post_id, 'post_views_count', $views);

        // Set transient for 24 hours to prevent duplicate counting
        set_transient($view_key, $today, DAY_IN_SECONDS);
    }
}
add_action('wp_head', 'blogsemantic_track_post_views');

/**
 * Get post views count
 */
function blogsemantic_get_post_views($post_id = null) {
    if (!$post_id) {
        global $post;
        $post_id = $post->ID;
    }

    $views = get_post_meta($post_id, 'post_views_count', true);
    return empty($views) ? 0 : $views;
}

/**
 * Time ago function
 */
function blogsemantic_time_ago($post_id = null) {
    if (!$post_id) {
        global $post;
        $post_id = $post->ID;
    }

    $date = get_the_date('Y-m-d H:i:s', $post_id);
    return human_time_diff(strtotime($date), current_time('timestamp')) . ' lalu';
}

/**
 * Custom body classes
 */
function blogsemantic_body_classes($classes) {
    // Add class for pages without sidebar
    if (!is_active_sidebar('sidebar-1')) {
        $classes[] = 'no-sidebar';
    }

    return $classes;
}
add_filter('body_class', 'blogsemantic_body_classes');

/**
 * Add meta box for featured posts
 */
function blogsemantic_add_meta_boxes() {
    add_meta_box(
        'blogsemantic_featured',
        __('Featured Post', 'blogsemantic'),
        'blogsemantic_featured_meta_box_callback',
        'post',
        'side',
        'high'
    );
}
add_action('add_meta_boxes', 'blogsemantic_add_meta_boxes');

/**
 * Featured post meta box callback
 */
function blogsemantic_featured_meta_box_callback($post) {
    wp_nonce_field('blogsemantic_featured_nonce', 'blogsemantic_featured_nonce');
    $featured = get_post_meta($post->ID, '_blogsemantic_featured', true);
    ?>
    <label>
        <input type="checkbox" name="blogsemantic_featured" value="1" <?php checked($featured, '1'); ?>>
        <?php _e('Mark as featured post', 'blogsemantic'); ?>
    </label>
    <?php
}

/**
 * Save featured post meta
 */
function blogsemantic_save_featured_meta($post_id) {
    if (!isset($_POST['blogsemantic_featured_nonce']) ||
        !wp_verify_nonce($_POST['blogsemantic_featured_nonce'], 'blogsemantic_featured_nonce')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    $featured = isset($_POST['blogsemantic_featured']) ? '1' : '0';
    update_post_meta($post_id, '_blogsemantic_featured', $featured);
}
add_action('save_post', 'blogsemantic_save_featured_meta');

/**
 * Bootstrap 5 Nav Walker for Desktop Menu
 */
class WP_Bootstrap_Navwalker extends Walker_Nav_Menu {

    public function start_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"dropdown-menu\">\n";
    }

    public function end_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul>\n";
    }

    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $indent = ($depth) ? str_repeat("\t", $depth) : '';

        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;

        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));

        if (in_array('menu-item-has-children', $classes)) {
            $class_names .= ' dropdown';
        }

        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

        $id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args);
        $id = $id ? ' id="' . esc_attr($id) . '"' : '';

        $output .= $indent . '<li' . $id . $class_names . '>';

        $attributes = !empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
        $attributes .= !empty($item->target) ? ' target="' . esc_attr($item->target) . '"' : '';
        $attributes .= !empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) . '"' : '';
        $attributes .= !empty($item->url) ? ' href="' . esc_attr($item->url) . '"' : '';

        $item_output = isset($args->before) ? $args->before : '';

        if (in_array('menu-item-has-children', $classes)) {
            $item_output .= '<a class="nav-link dropdown-toggle" data-bs-toggle="dropdown"' . $attributes . '>';
        } else {
            $item_output .= '<a class="nav-link"' . $attributes . '>';
        }

        $item_output .= (isset($args->link_before) ? $args->link_before : '') . apply_filters('the_title', $item->title, $item->ID) . (isset($args->link_after) ? $args->link_after : '');
        $item_output .= '</a>';
        $item_output .= isset($args->after) ? $args->after : '';

        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }

    public function end_el(&$output, $item, $depth = 0, $args = null) {
        $output .= "</li>\n";
    }
}

/**
 * Bootstrap 5 Nav Walker for Mobile Menu
 */
class WP_Bootstrap_Navwalker_Mobile extends Walker_Nav_Menu {

    public function start_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<div class=\"ps-3\">\n";
    }

    public function end_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</div>\n";
    }

    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $indent = ($depth) ? str_repeat("\t", $depth) : '';

        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;

        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

        $id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args);
        $id = $id ? ' id="' . esc_attr($id) . '"' : '';

        $attributes = !empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
        $attributes .= !empty($item->target) ? ' target="' . esc_attr($item->target) . '"' : '';
        $attributes .= !empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) . '"' : '';
        $attributes .= !empty($item->url) ? ' href="' . esc_attr($item->url) . '"' : '';

        $item_output = isset($args->before) ? $args->before : '';

        // Add appropriate Bootstrap icon based on menu item
        $icon = $this->get_menu_icon($item->title);

        $item_output .= '<a class="nav-link"' . $attributes . '>';
        $item_output .= '<i class="bi ' . $icon . '"></i> ';
        $item_output .= (isset($args->link_before) ? $args->link_before : '') . apply_filters('the_title', $item->title, $item->ID) . (isset($args->link_after) ? $args->link_after : '');
        $item_output .= '</a>';
        $item_output .= isset($args->after) ? $args->after : '';

        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }

    public function end_el(&$output, $item, $depth = 0, $args = null) {
        $output .= "\n";
    }

    private function get_menu_icon($title) {
        $title_lower = strtolower($title);

        if (strpos($title_lower, 'beranda') !== false || strpos($title_lower, 'home') !== false) {
            return 'bi-house';
        } elseif (strpos($title_lower, 'artikel') !== false || strpos($title_lower, 'blog') !== false) {
            return 'bi-newspaper';
        } elseif (strpos($title_lower, 'kategori') !== false || strpos($title_lower, 'category') !== false) {
            return 'bi-tags';
        } elseif (strpos($title_lower, 'tentang') !== false || strpos($title_lower, 'about') !== false) {
            return 'bi-person';
        } elseif (strpos($title_lower, 'kontak') !== false || strpos($title_lower, 'contact') !== false) {
            return 'bi-envelope';
        } else {
            return 'bi-link-45deg';
        }
    }
}

/**
 * Custom pagination function
 */
function blogsemantic_pagination() {
    global $wp_query;

    $total = $wp_query->max_num_pages;

    if ($total > 1) {
        $current_page = max(1, get_query_var('paged'));

        echo '<nav class="pagination-wrapper mt-5">';
        echo '<div class="pagination d-flex justify-content-center flex-wrap">';

        echo paginate_links(array(
            'base'      => get_pagenum_link(1) . '%_%',
            'format'    => '/page/%#%',
            'current'   => $current_page,
            'total'     => $total,
            'prev_text' => '<i class="bi bi-chevron-left"></i> Sebelumnya',
            'next_text' => 'Berikutnya <i class="bi bi-chevron-right"></i>',
            'type'      => 'plain',
            'end_size'  => 1,
            'mid_size'  => 2,
        ));

        echo '</div>';
        echo '</nav>';
    }
}

/**
 * Custom comment callback
 */
function blogsemantic_comment_callback($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment;

    switch ($comment->comment_type) :
        case 'pingback' :
        case 'trackback' :
            ?>
            <li class="pingback">
            <p><?php _e('Pingback:', 'blogsemantic'); ?> <?php comment_author_link(); ?><?php edit_comment_link(__('Edit', 'blogsemantic'), '<span class="edit-link">', '</span>'); ?></p>
            <?php
            break;
        default :
            ?>
            <li <?php comment_class('comment'); ?> id="comment-<?php comment_ID(); ?>">
                <article class="comment-body">
                    <div class="comment-author vcard">
                        <?php echo get_avatar($comment, 50); ?>
                        <div class="comment-metadata">
                            <h6 class="comment-author-name"><?php comment_author_link(); ?></h6>
                            <p class="comment-meta">
                                <time datetime="<?php comment_time('c'); ?>">
                                    <i class="bi bi-calendar3 me-1"></i>
                                    <?php comment_date(); ?> <?php comment_time(); ?>
                                </time>
                                <?php edit_comment_link(__('Edit', 'blogsemantic'), '<span class="edit-link ms-2"><i class="bi bi-pencil"></i> ', '</span>'); ?>
                            </p>
                        </div>
                    </div>

                    <?php if ('0' == $comment->comment_approved) : ?>
                        <p class="comment-awaiting-moderation alert alert-info">
                            <i class="bi bi-clock me-1"></i>
                            <?php _e('Your comment is awaiting moderation.', 'blogsemantic'); ?>
                        </p>
                    <?php endif; ?>

                    <div class="comment-content">
                        <?php comment_text(); ?>
                    </div>

                    <?php comment_reply_link(array_merge($args, array(
                        'reply_text' => '<i class="bi bi-reply me-1"></i>' . __('Reply', 'blogsemantic'),
                        'depth'      => $depth,
                        'max_depth'  => $args['max_depth']
                    ))); ?>
                </article>
            </li>
            <?php
            break;
    endswitch;
}

/**
 * Custom comment form
 */
function blogsemantic_comment_form($args = array()) {
    global $post;

    if (!comments_open()) {
        return;
    }

    $user = wp_get_current_user();
    $user_identity = $user->exists() ? $user->display_name : '';

    $req = get_option('require_name_email');
    $aria_req = ($req ? " aria-required='true'" : '');

    $fields = array(
        'author' => '<div class="comment-form-author">
                        <label for="author">' . __('Name', 'blogsemantic') . ($req ? ' <span class="required text-danger">*</span>' : '') . '</label>
                        <input id="author" name="author" type="text" value="' . esc_attr($user_identity) . '" size="30" class="form-control"' . $aria_req . ' />
                    </div>',
        'email'  => '<div class="comment-form-email">
                        <label for="email">' . __('Email', 'blogsemantic') . ($req ? ' <span class="required text-danger">*</span>' : '') . '</label>
                        <input id="email" name="email" type="email" value="' . esc_attr($user->user_email) . '" size="30" class="form-control"' . $aria_req . ' />
                    </div>',
        'url'    => '<div class="comment-form-url">
                        <label for="url">' . __('Website', 'blogsemantic') . '</label>
                        <input id="url" name="url" type="url" value="' . esc_attr($user->user_url) . '" size="30" class="form-control" />
                    </div>',
    );

    $defaults = array(
        'fields'               => $fields,
        'comment_field'        => '<div class="comment-form-comment">
                                      <label for="comment">' . __('Comment', 'blogsemantic') . ' <span class="required text-danger">*</span></label>
                                      <textarea id="comment" name="comment" cols="45" rows="8" class="form-control" aria-required="true"></textarea>
                                  </div>',
        'must_log_in'          => '<p class="must-log-in alert alert-info">
                                      <i class="bi bi-info-circle me-1"></i>
                                      ' . sprintf(__('You must be <a href="%s">logged in</a> to post a comment.', 'blogsemantic'), wp_login_url(apply_filters('the_permalink', get_permalink($post->ID)))) . '
                                  </p>',
        'logged_in_as'         => '<p class="logged-in-as">
                                      <i class="bi bi-person-check me-1"></i>
                                      ' . sprintf(__('Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>', 'blogsemantic'), admin_url('profile.php'), $user_identity, wp_logout_url(apply_filters('the_permalink', get_permalink($post->ID)))) . '
                                  </p>',
        'comment_notes_before' => '<p class="comment-notes">
                                      <i class="bi bi-info-circle me-1"></i>
                                      ' . __('Your email address will not be published. Required fields are marked *', 'blogsemantic') . '
                                  </p>',
        'comment_notes_after'  => '',
        'id_form'              => 'commentform',
        'id_submit'            => 'submit',
        'class_submit'         => 'submit btn btn-primary',
        'name_submit'          => 'submit',
        'title_reply'          => __('Leave a Comment', 'blogsemantic'),
        'title_reply_to'       => __('Leave a Reply to %s', 'blogsemantic'),
        'cancel_reply_link'    => __('Cancel Reply', 'blogsemantic'),
        'label_submit'         => __('Post Comment', 'blogsemantic'),
        'submit_button'        => '<input name="%1$s" type="submit" id="%2$s" class="%3$s" value="%4$s" />',
        'format'               => 'html5',
    );

    $args = wp_parse_args($args, $defaults);

    comment_form($args);
}

/**
 * Breadcrumbs function
 */
function blogsemantic_breadcrumbs() {
    // Settings
    $separator = '<i class="bi bi-chevron-right mx-2"></i>';
    $home_title = 'Beranda';

    // Get the query & post information
    global $post, $wp_query;

    // Do not display on the homepage
    if (!is_front_page()) {

        // Build the breadcrumbs
        echo '<nav aria-label="breadcrumb" class="breadcrumbs mb-4">';
        echo '<ol class="breadcrumb">';

        // Home page
        echo '<li class="breadcrumb-item"><a href="' . get_home_url() . '" title="' . $home_title . '"><i class="bi bi-house-door"></i> ' . $home_title . '</a></li>';

        if (is_archive() && !is_tax() && !is_category() && !is_tag()) {
            echo '<li class="breadcrumb-item active" aria-current="page">' . post_type_archive_title('', false) . '</li>';

        } else if (is_archive() && is_tax() && !is_category() && !is_tag()) {
            // If post is a custom post type
            $post_type = get_post_type();

            // If it is a custom post type display name and link
            if ($post_type != 'post') {
                $post_type_object = get_post_type_object($post_type);
                $post_type_archive = get_post_type_archive_link($post_type);

                echo '<li class="breadcrumb-item"><a href="' . $post_type_archive . '" title="' . $post_type_object->labels->name . '">' . $post_type_object->labels->name . '</a></li>';
            }

            $custom_tax_name = get_queried_object()->name;
            echo '<li class="breadcrumb-item active" aria-current="page">' . $custom_tax_name . '</li>';

        } else if (is_single()) {

            // If post is a custom post type
            $post_type = get_post_type();

            // If it is a custom post type display name and link
            if ($post_type != 'post') {
                $post_type_object = get_post_type_object($post_type);
                $post_type_archive = get_post_type_archive_link($post_type);

                echo '<li class="breadcrumb-item"><a href="' . $post_type_archive . '" title="' . $post_type_object->labels->name . '">' . $post_type_object->labels->name . '</a></li>';
            }

            // Get post category info
            $category = get_the_category();

            if (!empty($category)) {
                // Get last category post is in
                $last_category = end(array_values($category));

                // Get parent any categories and create array
                $get_cat_parents = rtrim(get_category_parents($last_category->term_id, true, ','), ',');
                $cat_parents = explode(',', $get_cat_parents);

                // Loop through parent categories and store in variable $cat_display
                $cat_display = '';
                foreach ($cat_parents as $parents) {
                    $cat_display .= '<li class="breadcrumb-item">' . $parents . '</li>';
                }

                // If the post is in a category, display the category
                if (!empty($last_category)) {
                    echo $cat_display;
                }
            }

            // Current post
            echo '<li class="breadcrumb-item active" aria-current="page">' . get_the_title() . '</li>';

        } else if (is_category()) {

            // Category page
            echo '<li class="breadcrumb-item active" aria-current="page">Kategori: ' . single_cat_title('', false) . '</li>';

        } else if (is_page()) {

            // Standard page
            if ($post->post_parent) {

                // If child page, get parents
                $anc = get_post_ancestors($post->ID);

                // Get parents in the right order
                $anc = array_reverse($anc);

                // Parent page loop
                if (!isset($parents)) $parents = null;
                foreach ($anc as $ancestor) {
                    $parents .= '<li class="breadcrumb-item"><a href="' . get_permalink($ancestor) . '" title="' . get_the_title($ancestor) . '">' . get_the_title($ancestor) . '</a></li>';
                }

                // Display parent pages
                echo $parents;

                // Current page
                echo '<li class="breadcrumb-item active" aria-current="page">' . get_the_title() . '</li>';

            } else {

                // Just display current page if not a child page
                echo '<li class="breadcrumb-item active" aria-current="page">' . get_the_title() . '</li>';

            }

        } else if (is_tag()) {

            // Tag page
            echo '<li class="breadcrumb-item active" aria-current="page">Tag: ' . single_tag_title('', false) . '</li>';

        } else if (is_author()) {

            // Author page
            global $author;
            $userdata = get_userdata($author);
            echo '<li class="breadcrumb-item active" aria-current="page">Penulis: ' . $userdata->display_name . '</li>';

        } else if (get_query_var('paged')) {

            // Paginated archives
            echo '<li class="breadcrumb-item active" aria-current="page">Halaman ' . get_query_var('paged') . '</li>';

        } else if (is_search()) {

            // Search results page
            echo '<li class="breadcrumb-item active" aria-current="page">Hasil Pencarian: "' . get_search_query() . '"</li>';

        } elseif (is_404()) {

            // 404 page
            echo '<li class="breadcrumb-item active" aria-current="page">Halaman Tidak Ditemukan</li>';
        }

        echo '</ol>';
        echo '</nav>';

    }
}