<?php

if (is_file(__DIR__ . '/vendor/autoload_packages.php')) {
    require_once __DIR__ . '/vendor/autoload_packages.php';
}

function tailpress(): TailPress\Framework\Theme
{
    return TailPress\Framework\Theme::instance()
        ->assets(
            fn($manager) => $manager
                ->withCompiler(
                    new TailPress\Framework\Assets\ViteCompiler,
                    fn($compiler) => $compiler
                        ->registerAsset('resources/css/app.css')
                        ->registerAsset('resources/js/app.js')
                        ->editorStyleFile('resources/css/editor-style.css')
                )
                ->enqueueAssets()
        )
        ->features(fn($manager) => $manager->add(TailPress\Framework\Features\MenuOptions::class))
        ->menus(fn($manager) => $manager->add('primary', __('Primary Menu', 'tailpress')))
        ->themeSupport(fn($manager) => $manager->add([
            'title-tag',
            'custom-logo',
            'post-thumbnails',
            'align-wide',
            'wp-block-styles',
            'responsive-embeds',
            'html5' => [
                'search-form',
                'comment-form',
                'comment-list',
                'gallery',
                'caption',
            ]
        ]));
}

tailpress();

add_action('wp_enqueue_scripts', function () {
    wp_enqueue_script('jquery');
    wp_enqueue_style(
        'arti-fonts',
        get_theme_file_uri('/fonts/stylesheet.css'),
        [],
        filemtime(get_theme_file_path('/fonts/stylesheet.css'))
    );
});

/**
 * Register editable preferred roles for contact form dropdowns.
 */
function arti_register_preferred_role_post_type(): void
{
    register_post_type('preferred_role', [
        'labels' => [
            'name' => __('Preferred Roles', 'tailpress'),
            'singular_name' => __('Preferred Role', 'tailpress'),
            'add_new_item' => __('Add New Preferred Role', 'tailpress'),
            'edit_item' => __('Edit Preferred Role', 'tailpress'),
            'new_item' => __('New Preferred Role', 'tailpress'),
            'view_item' => __('View Preferred Role', 'tailpress'),
            'search_items' => __('Search Preferred Roles', 'tailpress'),
            'not_found' => __('No preferred roles found', 'tailpress'),
            'not_found_in_trash' => __('No preferred roles found in Trash', 'tailpress'),
        ],
        'public' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_icon' => 'dashicons-groups',
        'supports' => ['title', 'page-attributes'],
        'has_archive' => false,
        'rewrite' => false,
        'show_in_rest' => true,
    ]);
}

add_action('init', 'arti_register_preferred_role_post_type');

/**
 * Get preferred role titles for contact form select options.
 *
 * @return string[]
 */
function arti_get_preferred_role_options(): array
{
    $roles = get_posts([
        'post_type' => 'preferred_role',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'orderby' => [
            'menu_order' => 'ASC',
            'title' => 'ASC',
        ],
        'no_found_rows' => true,
    ]);

    $options = [];

    foreach ($roles as $role) {
        if (!$role instanceof WP_Post) {
            continue;
        }

        $role_title = trim(get_the_title($role));
        if ($role_title !== '') {
            $options[] = $role_title;
        }
    }

    return $options;
}

/**
 * Replace the preferred role CF7 select options with Preferred Role posts.
 *
 * @param object $tag Contact Form 7 form tag.
 * @return object
 */
function arti_populate_preferred_role_cf7_select($tag)
{
    $tag_name = '';
    if (is_array($tag) && isset($tag['name'])) {
        $tag_name = (string) $tag['name'];
    } elseif (is_object($tag) && isset($tag->name)) {
        $tag_name = (string) $tag->name;
    }

    if (!preg_match('/^preferred[-_]?roles?$/i', $tag_name)) {
        return $tag;
    }

    $role_options = arti_get_preferred_role_options();

    if (empty($role_options)) {
        return $tag;
    }

    $placeholder = 'Preferred Role';
    if (is_array($tag) && !empty($tag['values'][0])) {
        $placeholder = (string) $tag['values'][0];
    } elseif (is_array($tag) && !empty($tag['labels'][0])) {
        $placeholder = (string) $tag['labels'][0];
    } elseif (is_object($tag) && !empty($tag->values[0])) {
        $placeholder = (string) $tag->values[0];
    } elseif (is_object($tag) && !empty($tag->labels[0])) {
        $placeholder = (string) $tag->labels[0];
    }

    $options = array_merge([$placeholder], $role_options);

    if (is_array($tag)) {
        $tag['values'] = $options;
        $tag['labels'] = $options;
        $tag['raw_values'] = $options;
    } else {
        $tag->values = $options;
        $tag->labels = $options;
        $tag->raw_values = $options;
    }

    return $tag;
}

add_filter('wpcf7_form_tag', 'arti_populate_preferred_role_cf7_select', 10, 1);

/**
 * Render news cards HTML for AJAX and template usage.
 *
 * @param WP_Query $query News query instance.
 * @return string
 */
function arti_render_news_cards_html(WP_Query $query): string
{
    ob_start();

    if ($query->have_posts()):
        while ($query->have_posts()):
            $query->the_post();
            ?>
            <article class="w-[40%] shrink-0">
                <a href="<?php the_permalink(); ?>" class="group block !no-underline">
                    <div class="overflow-hidden">
                        <?php if (has_post_thumbnail()): ?>
                            <?php the_post_thumbnail('large', ['class' => 'block rounded-br-[88px] md:rounded-br-[150px] h-[245px] w-full object-cover transition-transform duration-500 md:h-[420px]']); ?>
                        <?php else: ?>
                            <div class="h-[245px] w-full bg-black/12 md:h-[360px]"></div>
                        <?php endif; ?>
                    </div>
                    <h2 class="mt-5 text-[12px] font-medium uppercase tracking-[0.31em] text-dark-brown">
                        <?php echo esc_html(get_the_title()); ?>
                    </h2>
                    <span class="mt-8 inline-flex space-x-1.5 text-[9px] font-medium uppercase tracking-[0.31em] text-light-brown">
                        <span>Read More</span>
                        <img src="<?php echo esc_url(get_template_directory_uri() . '/images/arrow-right.png'); ?>"
                            alt="Arrow Right Icon" class="h-3 w-3 object-contain mt-[2px]">
                    </span>
                </a>
            </article>
            <?php
        endwhile;
        wp_reset_postdata();
    else:
        ?>
        <div class="w-[440px] shrink-0 max-md:w-[320px]">
            <p class="text-[0.82rem] text-black/60">No news posts found.</p>
        </div>
        <?php
    endif;

    return (string) ob_get_clean();
}

/**
 * AJAX filter handler for news page.
 */
function arti_filter_news_posts_ajax(): void
{
    check_ajax_referer('arti_filter_news_nonce', 'nonce');

    $raw_categories = isset($_POST['categories']) ? (array) $_POST['categories'] : [];
    $category_ids = array_values(array_filter(array_map('absint', $raw_categories)));

    $args = [
        'post_type' => 'post',
        'post_status' => 'publish',
        'posts_per_page' => 12,
        'orderby' => 'date',
        'order' => 'DESC',
    ];

    if (!empty($category_ids)) {
        $args['category__in'] = $category_ids;
    }

    $query = new WP_Query($args);
    $html = arti_render_news_cards_html($query);

    wp_send_json_success([
        'html' => $html,
        'selected_count' => count($category_ids),
    ]);
}

add_action('wp_ajax_arti_filter_news_posts', 'arti_filter_news_posts_ajax');
add_action('wp_ajax_nopriv_arti_filter_news_posts', 'arti_filter_news_posts_ajax');

/**
 * Resolve taxonomy for work post type.
 *
 * @return string|null
 */
function arti_get_work_taxonomy(): ?string
{
    $taxonomies = get_object_taxonomies('work', 'names');
    if (empty($taxonomies)) {
        return null;
    }

    if (in_array('category', $taxonomies, true)) {
        return 'category';
    }

    return (string) $taxonomies[0];
}

/**
 * Get all unique non-empty "type" field values from published work posts.
 *
 * @return string[]
 */
function arti_get_work_type_filters(): array
{
    $work_ids = get_posts([
        'post_type' => 'work',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'fields' => 'ids',
        'no_found_rows' => true,
        'orderby' => 'date',
        'order' => 'ASC',
    ]);

    if (empty($work_ids)) {
        return [];
    }

    $types = [];
    foreach ($work_ids as $work_id) {
        $raw_type = get_post_meta((int) $work_id, 'type', true);
        $type = trim((string) $raw_type);
        if ($type === '') {
            continue;
        }
        $types[] = $type;
    }

    $types = array_values(array_unique($types));
    natcasesort($types);

    return array_values($types);
}

/**
 * Render works cards HTML for AJAX and template usage.
 *
 * @param WP_Query $query    Works query instance.
 * @param string   $taxonomy Taxonomy used by work post type.
 * @return string
 */
function arti_render_work_cards_html(WP_Query $query, string $taxonomy): string
{
    ob_start();

    if ($query->have_posts()):
        while ($query->have_posts()):
            $query->the_post();

            $type = function_exists('get_field') ? (string) get_field('type') : '';
            $icon_outside = function_exists('get_field') ? get_field('icon_outside') : '';
            $terms = get_the_terms(get_the_ID(), $taxonomy);
            $category_label = (!is_wp_error($terms) && !empty($terms)) ? $terms[0]->name : '';
            ?>
            <article
                class="grid 2xl:grid-cols-[minmax(0,60%)_minmax(0,1fr)] grid-cols-[minmax(0,68%)_minmax(0,1fr)] gap-0 max-md:grid-cols-1">
                <a href="<?php the_permalink(); ?>" class="group block !no-underline">
                    <div class="aspect-[720/445] overflow-hidden">
                        <?php if (has_post_thumbnail()): ?>
                            <?php the_post_thumbnail('large', ['class' => 'block h-full w-full rounded-br-[110px] object-cover transition-transform duration-500 md:rounded-br-[250px]']); ?>
                        <?php else: ?>
                            <div class="h-full w-full rounded-br-[110px] bg-black/12 md:rounded-br-[250px]"></div>
                        <?php endif; ?>
                    </div>
                </a>
                <div class="flex space-x-4 px-0 pt-5 md:pt-3 md:block md:px-9">
                    <div class="mb-6 flex items-center gap-2">
                        <span class="inline-flex w-8 h-8 md:h-10 md:w-10 items-center">
                            <?php
                            if (is_numeric($icon_outside)) {
                                echo wp_get_attachment_image((int) $icon_outside, 'thumbnail', false, ['class' => 'h-10 w-10 object-contain']);
                            } elseif (is_array($icon_outside) && !empty($icon_outside['url'])) {
                                echo '<img src="' . esc_url($icon_outside['url']) . '" alt="" class="h-10 w-10 object-contain">';
                            } elseif (is_string($icon_outside) && trim($icon_outside) !== '') {
                                echo '<img src="' . esc_url($icon_outside) . '" alt="" class="h-10 w-10 object-contain">';
                            } else {
                                echo '<span class="block h-3 w-3 rounded-full bg-white/90"></span>';
                            }
                            ?>
                        </span>
                    </div>
                    <div>
                        <h2 class="m-0 text-[12px] font-medium uppercase tracking-[0.31em] text-dark-brown">
                            <?php echo esc_html(get_the_title()); ?>
                        </h2>
                        <!-- <?php if (!empty($category_label)): ?>
                        <p class="mt-1 text-[0.62rem] text-black/52"><?php echo esc_html($category_label); ?></p>
                    <?php endif; ?> -->
                        <?php if (!empty($type)): ?>
                            <p class="mt-1 md:mt-2 text-[12px] tracking-[0.1em] text-light-brown">
                                <?php echo esc_html($type); ?>
                            </p>
                        <?php endif; ?>
                    </div>
                </div>
            </article>
            <?php
        endwhile;
        wp_reset_postdata();
    else:
        ?>
        <article class=" bg-black/[0.04] px-6 py-10 md:rounded-br-[120px] md:px-10 md:py-14">
            <h2 class="m-0 text-[12px] font-medium uppercase tracking-[0.31em] text-dark-brown">
                No Works Found
            </h2>
            <p class="mt-3 text-[11px] uppercase tracking-[0.16em] text-light-brown">
                Try another filter or search keyword.
            </p>
        </article>
        <?php
    endif;

    return (string) ob_get_clean();
}

/**
 * AJAX filter handler for works page.
 */
function arti_filter_work_posts_ajax(): void
{
    check_ajax_referer('arti_filter_work_nonce', 'nonce');

    $taxonomy = arti_get_work_taxonomy();
    $render_taxonomy = $taxonomy ?: 'category';

    $raw_types = isset($_POST['types']) ? (array) $_POST['types'] : [];
    $types = array_values(array_filter(array_map(
        static fn($value): string => trim(sanitize_text_field((string) $value)),
        $raw_types
    )));
    $types = array_values(array_unique($types));
    $search = isset($_POST['search']) ? sanitize_text_field((string) $_POST['search']) : '';

    $args = [
        'post_type' => 'work',
        'post_status' => 'publish',
        'posts_per_page' => 12,
        'orderby' => 'date',
        'order' => 'ASC',
        's' => $search,
    ];

    if (!empty($types)) {
        $args['meta_query'] = [
            [
                'key' => 'type',
                'value' => $types,
                'compare' => 'IN',
            ],
        ];
    }

    $query = new WP_Query($args);
    $html = arti_render_work_cards_html($query, $render_taxonomy);

    wp_send_json_success([
        'html' => $html,
        'selected_count' => count($types),
    ]);
}

add_action('wp_ajax_arti_filter_work_posts', 'arti_filter_work_posts_ajax');
add_action('wp_ajax_nopriv_arti_filter_work_posts', 'arti_filter_work_posts_ajax');
