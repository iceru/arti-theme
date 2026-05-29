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
            <article class="w-[440px] shrink-0 max-md:w-[320px]">
                <a href="<?php the_permalink(); ?>" class="group block !no-underline">
                    <div class="overflow-hidden bg-black/8">
                        <?php if (has_post_thumbnail()): ?>
                            <?php the_post_thumbnail('large', ['class' => 'block h-[300px] w-full object-cover transition-transform duration-500 group-hover:scale-[1.03] md:h-[360px]']); ?>
                        <?php else: ?>
                            <div class="h-[300px] w-full bg-black/12 md:h-[360px]"></div>
                        <?php endif; ?>
                    </div>
                    <h2 class="mt-5 text-[12px] font-medium uppercase tracking-[0.38em] text-[#2f2f2f]">
                        <?php echo esc_html(get_the_title()); ?>
                    </h2>
                    <span class="mt-8 inline-block text-[0.58rem] uppercase tracking-[0.38em] text-[#575757]">
                        Read More ->
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

            $status = function_exists('get_field') ? (string) get_field('status') : '';
            $icon_outside = function_exists('get_field') ? get_field('icon_outside') : '';
            $icon_inside = function_exists('get_field') ? get_field('icon_inside') : '';
            $terms = get_the_terms(get_the_ID(), $taxonomy);
            $category_label = (!is_wp_error($terms) && !empty($terms)) ? $terms[0]->name : '';
            ?>
            <article class="grid grid-cols-[1fr_300px] gap-6 max-md:grid-cols-1 max-md:gap-4">
                <a href="<?php the_permalink(); ?>" class="group block !no-underline">
                    <div class="overflow-hidden bg-black/8">
                        <?php if (has_post_thumbnail()): ?>
                            <?php the_post_thumbnail('large', ['class' => 'block h-[420px] rounded-br-[110px] md:rounded-br-[250px] w-full object-cover transition-transform duration-500 group-hover:scale-[1.02] max-md:h-[260px]']); ?>
                        <?php else: ?>
                            <div class="h-[420px] w-full bg-black/12 max-md:h-[260px] rounded-br-[110px] md:rounded-br-[250px]"></div>
                        <?php endif; ?>
                    </div>
                </a>
                <div class="pt-3">
                    <div class="mb-6 flex items-center gap-2">
                        <span class="inline-flex h-8 w-8 items-center justify-center rounded-sm bg-[#3b3b3b] text-white">
                            <?php
                            if (is_numeric($icon_outside)) {
                                echo wp_get_attachment_image((int) $icon_outside, 'thumbnail', false, ['class' => 'h-5 w-5 object-contain']);
                            } elseif (is_array($icon_outside) && !empty($icon_outside['url'])) {
                                echo '<img src="' . esc_url($icon_outside['url']) . '" alt="" class="h-5 w-5 object-contain">';
                            } else {
                                echo '<span class="block h-3 w-3 rounded-full bg-white/90"></span>';
                            }
                            ?>
                        </span>
                    </div>
                    <h2 class="m-0 text-[12px] font-medium uppercase tracking-[0.38em] text-[#2f2f2f]">
                        <?php echo esc_html(get_the_title()); ?>
                    </h2>
                    <?php if (!empty($category_label)): ?>
                        <p class="mt-1 text-[0.62rem] text-black/52"><?php echo esc_html($category_label); ?></p>
                    <?php endif; ?>
                    <!-- <?php if (!empty($status)): ?>
        <p class="mt-2 text-[0.6rem] uppercase tracking-[0.28em] text-black/46"><?php echo esc_html($status); ?></p>
        <?php endif; ?> -->
                </div>
            </article>
            <?php
        endwhile;
        wp_reset_postdata();
    else:
        ?>
        <article class="grid grid-cols-[1fr_300px] gap-6 max-md:grid-cols-1 max-md:gap-4">
            <div>
                <div class="h-[420px] w-full bg-black/12 max-md:h-[260px] rounded-br-[110px] md:rounded-br-[250px]"></div>
            </div>
            <div class="pt-3">
                <div class="mb-6 flex items-center gap-2">
                    <span class="inline-flex h-8 w-8 items-center justify-center rounded-sm bg-[#3b3b3b] text-white">
                        <span class="block h-3 w-3 rounded-full bg-white/90"></span>
                    </span>
                </div>
                <h2 class="m-0 text-[12px] font-medium uppercase tracking-[0.38em] text-[#2f2f2f]">
                    Example (no data): Sample Work Showcase
                </h2>
                <p class="mt-1 text-[0.62rem] text-black/52">Residential</p>
                <p class="mt-2 text-[0.6rem] uppercase tracking-[0.28em] text-black/46">Concept</p>
            </div>
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
    if (!$taxonomy) {
        wp_send_json_success([
            'html' => arti_render_work_cards_html(new WP_Query(['post_type' => 'work', 'posts_per_page' => 0]), 'category'),
            'selected_count' => 0,
        ]);
    }

    $raw_terms = isset($_POST['terms']) ? (array) $_POST['terms'] : [];
    $term_ids = array_values(array_filter(array_map('absint', $raw_terms)));
    $search = isset($_POST['search']) ? sanitize_text_field((string) $_POST['search']) : '';

    $args = [
        'post_type' => 'work',
        'post_status' => 'publish',
        'posts_per_page' => 12,
        'orderby' => 'date',
        'order' => 'DESC',
        's' => $search,
    ];

    if (!empty($term_ids)) {
        $args['tax_query'] = [
            [
                'taxonomy' => $taxonomy,
                'field' => 'term_id',
                'terms' => $term_ids,
            ],
        ];
    }

    $query = new WP_Query($args);
    $html = arti_render_work_cards_html($query, $taxonomy);

    wp_send_json_success([
        'html' => $html,
        'selected_count' => count($term_ids),
    ]);
}

add_action('wp_ajax_arti_filter_work_posts', 'arti_filter_work_posts_ajax');
add_action('wp_ajax_nopriv_arti_filter_work_posts', 'arti_filter_work_posts_ajax');
