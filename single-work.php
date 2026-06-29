<?php
/**
 * Single Work template.
 *
 * @package TailPress
 */

get_header();
?>

<style>
    body.single-work-hero-visible:not(.site-menu-open) header,
    body.single-work-hero-visible:not(.site-menu-open) header>div {
        background: transparent !important;
        box-shadow: none !important;
        transition: background-color 220ms ease, box-shadow 220ms ease;
    }

    .work-credits summary::-webkit-details-marker {
        display: none;
    }

    .work-credits summary::marker {
        content: "";
    }

    .work-credits__icon {
        transition: transform 220ms ease;
    }

    .work-credits[open] .work-credits__icon {
        transform: rotate(180deg);
    }

    @keyframes work-hero-zoom-out {
        from {
            transform: scale(1.2);
        }

        to {
            transform: scale(1);
        }
    }

    .work-hero-media {
        animation: work-hero-zoom-out 7000ms cubic-bezier(0.22, 1, 0.36, 1) both;
        transform-origin: center;
        will-change: transform;
        position: relative;
        z-index: 0;
    }

    #work-hero {
        isolation: isolate;
        border-bottom-right-radius: 180px;
    }

    #work-hero::after {
        content: "";
        position: absolute;
        inset: 0;
        z-index: 1;
        background: linear-gradient(to top, rgba(0, 0, 0, 0.95) 0%, rgba(0, 0, 0, 0.62) 24%, rgba(0, 0, 0, 0) 62%);
        pointer-events: none;
    }

    .work-hero-content {
        z-index: 2;
    }

    .work-hero-icon {
        z-index: 3;
    }

    @media (min-width: 768px) {
        #work-hero {
            border-bottom-right-radius: 327px;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .work-hero-media {
            animation: none;
        }
    }

    .entry-content :where(p, h1, h2, h3, h4, h5, h6, figure, .wp-block-image, .wp-block-gallery, .wp-block-columns, .wp-block-group) {
        margin-top: 0 !important;
        margin-bottom: 1em !important;
    }

    @media (max-width: 781px) {
        .entry-content>.wp-block-columns {
            display: flex !important;
            flex-direction: column;
        }

        .entry-content>.wp-block-columns>.wp-block-column:has(.work-info) {
            order: 2;
        }

        .entry-content>.wp-block-columns>.wp-block-column:not(:has(.work-info)) {
            order: 1;
        }
    }

    @media (min-width: 782px) {
        .entry-content :where(.wp-block-column > :last-child, .wp-block-group > :last-child, :last-child) {
            margin-bottom: 0 !important;
        }

        .entry-content>.wp-block-columns {
            display: grid !important;
            grid-template-columns: minmax(0, 33%) minmax(0, 1fr);
            gap: 4em;
        }

        .entry-content>.wp-block-columns>.wp-block-column {
            min-width: 0;
        }
    }
</style>

<?php
$work_taxonomy = arti_get_work_taxonomy();

$get_first_field = static function (array $keys, $default = '') {
    foreach ($keys as $key) {
        $values = [];

        if (function_exists('get_field')) {
            $values[] = get_field($key);
        }

        $post_id = get_the_ID();
        if ($post_id) {
            $values[] = get_post_meta($post_id, $key, true);
        }

        foreach ($values as $value) {
            if (is_array($value)) {
                if (!empty($value)) {
                    return $value;
                }
                continue;
            }

            if (is_string($value) && trim($value) !== '') {
                return $value;
            }

            if (!empty($value)) {
                return $value;
            }
        }
    }

    return $default;
};

$resolve_attachment_id = static function ($item): int {
    if (is_numeric($item)) {
        return (int) $item;
    }

    if (is_array($item)) {
        if (!empty($item['ID']) && is_numeric($item['ID'])) {
            return (int) $item['ID'];
        }
        if (!empty($item['id']) && is_numeric($item['id'])) {
            return (int) $item['id'];
        }
    }

    if (is_object($item) && isset($item->ID) && is_numeric($item->ID)) {
        return (int) $item->ID;
    }

    return 0;
};
?>

<?php while (have_posts()):
    the_post(); ?>
    <?php
    $terms = $work_taxonomy ? get_the_terms(get_the_ID(), $work_taxonomy) : [];
    $work_type = (!is_wp_error($terms) && !empty($terms)) ? $terms[0]->name : 'Residential';

    $location = (string) $get_first_field(['location', 'project_location'], '');
    $year = (string) $get_first_field(['year', 'project_year'], '');
    $site_area = (string) $get_first_field(['site_area', 'project_site_area'], '');
    $floor_area = (string) $get_first_field(['floor_area', 'project_floor_area'], '');
    $floors = (string) $get_first_field(['floors', 'stories', 'project_floors'], '');
    $bedrooms = (string) $get_first_field(['bedrooms', 'project_bedrooms'], '');
    $client = (string) $get_first_field(['client', 'project_client'], '');
    $status = (string) $get_first_field(['status', 'project_status'], '');

    $intro_title = (string) $get_first_field(['intro_title', 'project_intro_title'], '');
    $intro_text = (string) $get_first_field(['intro_text', 'project_intro_text'], '');
    $concept_text = (string) $get_first_field(['concept_text', 'project_concept_text'], '');

    $gallery_primary = $get_first_field(['project_gallery', 'gallery', 'detail_gallery'], []);
    $gallery_process = $get_first_field(['process_gallery', 'process_images', 'sketch_gallery'], []);
    $model_image = $get_first_field(['model_image', 'project_model_image'], '');
    $icon_inside = $get_first_field(['icon_inside', 'project_icon_inside'], '');
    $credits = [];

    for ($credit_index = 1; $credit_index <= 4; $credit_index++) {
        $credit_value = (string) $get_first_field(["credit_{$credit_index}"], '');
        $credit_value = trim($credit_value);

        if ($credit_value !== '') {
            $credits[] = $credit_value;
        }
    }

    $render_work_info = static function (string $extra_classes = '') use ($work_type, $site_area, $floor_area, $bedrooms, $floors, $client, $credits): string {
        ob_start();
        ?>
        <aside class="<?php echo esc_attr(trim("work-info min-w-0 border-t border-zinc-500/35 pt-3 {$extra_classes}")); ?>">
            <div class="m-0 text-[1.7rem] leading-none text-zinc-800">
                <?php echo esc_html($work_type); ?>
            </div>
            <div class="mt-8 gap-y-12 gap-x-6 grid grid-cols-2 mb-12">
                <?php if ($site_area !== ''): ?>
                    <div>
                        <div
                            class="text-[9px] uppercase tracking-[0.28em] text-light-brown font-medium pb-[18px] border-b border-beige-2 mb-2">
                            Site Area / M2</div>
                        <div class="text-[28px] text-dark-brown">
                            <?php echo esc_html($site_area); ?>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if ($floor_area !== ''): ?>
                    <div>
                        <div
                            class="text-[9px] uppercase tracking-[0.28em] text-light-brown font-medium pb-[18px] border-b border-beige-2 mb-2">
                            Flor Area / M2</div>
                        <div class="text-[28px] text-dark-brown">
                            <?php echo esc_html($floor_area); ?>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if ($bedrooms !== ''): ?>
                    <div>
                        <div
                            class="text-[9px] uppercase tracking-[0.28em] text-light-brown font-medium pb-[18px] border-b border-beige-2 mb-2">
                            Bedrooms</div>
                        <div class="text-[28px] text-dark-brown">
                            <?php echo esc_html($bedrooms); ?>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if ($floors !== ''): ?>
                    <div>
                        <div
                            class="text-[9px] uppercase tracking-[0.28em] text-light-brown font-medium pb-[18px] border-b border-beige-2 mb-2">
                            Floors</div>
                        <div class="text-[28px] text-dark-brown">
                            <?php echo esc_html($floors); ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <?php if ($client !== ''): ?>
                <div>
                    <div
                        class="text-[9px] uppercase tracking-[0.28em] text-light-brown font-medium pb-[18px] border-b border-beige-2 mb-2">
                        Client</div>
                    <div class="text-[28px] text-dark-brown">
                        <?php echo esc_html($client); ?>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (!empty($credits)): ?>
                <details class="work-credits mt-14">
                    <summary
                        class="flex cursor-pointer list-none items-center justify-between gap-6 border-b border-beige-2 pb-[18px] text-[9px] font-medium uppercase tracking-[0.28em] text-light-brown">
                        <span>Credits</span>
                        <span class="work-credits__icon h-2 w-2 rotate-45 border-b border-r border-light-brown"
                            aria-hidden="true"></span>
                    </summary>
                    <div class="grid gap-x-16 gap-y-6 pt-5 text-[12px] leading-tight text-dark-brown grid-cols-2">
                        <?php foreach ($credits as $credit): ?>
                            <div class="m-0">
                                <?php echo esc_html($credit); ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </details>
            <?php endif; ?>
        </aside>
        <?php
        return (string) ob_get_clean();
    };

    add_shortcode('work_info', static function () use ($render_work_info): string {
        return $render_work_info();
    });

    $content_has_work_info_shortcode = has_shortcode((string) get_post_field('post_content', get_the_ID()), 'work_info');

    $prev_work = null;
    $next_work = null;
    $ordered_work_ids = get_posts([
        'post_type' => 'work',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'orderby' => 'date',
        'order' => 'ASC',
        'fields' => 'ids',
    ]);

    $current_work_index = array_search(get_the_ID(), $ordered_work_ids, true);

    if ($current_work_index !== false) {
        $prev_work_id = $ordered_work_ids[$current_work_index - 1] ?? 0;
        $next_work_id = $ordered_work_ids[$current_work_index + 1] ?? 0;

        $prev_work = $prev_work_id ? get_post((int) $prev_work_id) : null;
        $next_work = $next_work_id ? get_post((int) $next_work_id) : null;
    }
    ?>

    <article <?php post_class('bg-beige-1 text-zinc-800 pb-16 md:pb-20'); ?>>
        <div class="mx-auto max-w-[1800px]">
            <section id="work-hero" class="relative overflow-hidden -mt-[78px]">
                <?php if (has_post_thumbnail()): ?>
                    <?php the_post_thumbnail('full', ['class' => 'work-hero-media block w-full h-[95vh] md:h-[74vh] xl:h-[95vh] object-cover']); ?>
                <?php else: ?>
                    <div class="work-hero-media h-[95vh] w-full bg-black/10 md:h-[74vh] xl:h-[95vh]">
                    </div>
                <?php endif; ?>

                <div class="work-hero-content absolute inset-x-0 bottom-0 w-full h-full flex flex-col justify-end overflow-hidden
                    pb-16 md:pb-11 pt-16 pl-4 md:pl-9">
                    <h1 class="relative z-10 m-0 text-[28px] uppercase tracking-[0.31em] mb-7 text-white ">
                        <?php the_title(); ?>
                    </h1>
                    <div
                        class="relative z-10 mt-2 flex flex-wrap items-center gap-x-16 md:gap-x-32 gap-y-1 text-[12px] uppercase tracking-[0.3em] text-light-brown">

                        <span><?php echo esc_html($work_type); ?></span>
                        <?php if ($status !== ''): ?>
                            <span><?php echo esc_html($status); ?></span>
                        <?php endif; ?>
                    </div>
                </div>

                <?php
                $icon_inside_url = '';
                $icon_inside_id = $resolve_attachment_id($icon_inside);

                if ($icon_inside_id) {
                    $icon_inside_url = (string) wp_get_attachment_image_url($icon_inside_id, 'full');
                } elseif (is_array($icon_inside) && !empty($icon_inside['url'])) {
                    $icon_inside_url = (string) $icon_inside['url'];
                } elseif (is_string($icon_inside) && trim($icon_inside) !== '') {
                    $icon_inside_url = $icon_inside;
                }

                if ($icon_inside_url === '') {
                    $icon_inside_url = get_theme_file_uri('/images/logo-short.png');
                }
                ?>
                <div class="work-hero-icon absolute right-4 bottom-3 flex md:bottom-10 md:right-12">
                    <img src="<?php echo esc_url($icon_inside_url); ?>" alt="" class="h-8 w-8 object-contain md:h-6">
                </div>
            </section>

            <!-- <section class="grid grid-cols-1 gap-8 py-12 md:grid-cols-[220px_1fr_1fr] md:gap-8 md:py-16">
                <p class="m-0 pt-1 text-[12px] uppercase tracking-[0.32em] text-zinc-700/80">
                    <?php echo esc_html($intro_title !== '' ? $intro_title : 'Project Overview'); ?>
                </p>
                <p class="m-0 text-[0.74rem] leading-[1.95] text-zinc-700">
                    <?php echo esc_html($intro_text !== '' ? $intro_text : wp_trim_words(wp_strip_all_tags(get_the_excerpt()), 44, '...')); ?>
                </p>
                <p class="m-0 text-[0.74rem] leading-[1.95] text-zinc-700">
                    <?php echo esc_html($concept_text !== '' ? $concept_text : 'This section is editable from WordPress fields, while the middle narrative below can be fully customized from the post content editor.'); ?>
                </p>
            </section> -->

            <section class="mx-auto mt-16 px-4 md:mt-32 md:px-9">
                <div class="entry-content text-zinc-800/85
                    [&_p]:px-0 [&_p]:text-light-brown [&_p]:text-[12px]
                    [&_h2]:px-0 [&_h2]:text-dark-brown [&_h2]:text-[12px] [&_h2]:mt-0 [&_h2]:uppercase [&_h2]:mb-4 [&_h2]:md:mb-7 [&_h2]:tracking-[0.31em] [&_h2]:font-medium
                    md:[&_.wp-block-column.gallery]:-mr-9 md:[&_.wp-block-column.gallery-right]:!-mr-9 [&_.wp-block-column.gallery-left]:!-ml-4 md:[&_.wp-block-column.gallery-left]:!-ml-9
                    [&_figure]:my-8 [&_figure]:!-mx-4 md:[&_figure]:!mx-0 [&_figure]:px-0 [&_figcaption]:px-4 [&_figcaption]:mt-2 [&_figcaption]:text-[0.66rem] [&_figcaption]:text-light-brown md:[&_figcaption]:px-9
                    [&_img]:block [&_img]:h-auto [&_img]:w-full [&_img]:object-cover">
                    <?php the_content(); ?>
                </div>
            </section>

            <?php if (is_array($gallery_primary) && !empty($gallery_primary)): ?>
                <section class="mx-auto mt-14 max-w-[980px] space-y-3 md:space-y-4">
                    <?php
                    $primary_count = count($gallery_primary);
                    $first_image = $gallery_primary[0];
                    $second_image = $primary_count > 1 ? $gallery_primary[1] : null;
                    $third_image = $primary_count > 2 ? $gallery_primary[2] : null;
                    ?>
                    <div>
                        <?php
                        $first_image_id = $resolve_attachment_id($first_image);
                        if ($first_image_id) {
                            echo wp_get_attachment_image($first_image_id, 'full', false, ['class' => 'block w-full h-auto object-cover']);
                        }
                        ?>
                    </div>
                    <?php if ($second_image || $third_image): ?>
                        <div class="grid grid-cols-1 gap-3 md:grid-cols-2 md:gap-4">
                            <?php if ($second_image): ?>
                                <?php
                                $second_image_id = $resolve_attachment_id($second_image);
                                if ($second_image_id) {
                                    echo wp_get_attachment_image($second_image_id, 'large', false, ['class' => 'block w-full h-[220px] md:h-[260px] object-cover']);
                                }
                                ?>
                            <?php endif; ?>
                            <?php if ($third_image): ?>
                                <?php
                                $third_image_id = $resolve_attachment_id($third_image);
                                if ($third_image_id) {
                                    echo wp_get_attachment_image($third_image_id, 'large', false, ['class' => 'block w-full h-[220px] md:h-[260px] object-cover']);
                                }
                                ?>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                    <?php if ($primary_count > 3): ?>
                        <?php for ($i = 3; $i < $primary_count; $i++): ?>
                            <div>
                                <?php
                                $image_id = $resolve_attachment_id($gallery_primary[$i]);
                                if ($image_id) {
                                    echo wp_get_attachment_image($image_id, 'full', false, ['class' => 'block w-full h-auto object-cover']);
                                }
                                ?>
                            </div>
                        <?php endfor; ?>
                    <?php endif; ?>
                </section>
            <?php endif; ?>

            <?php if (is_array($gallery_process) && !empty($gallery_process)): ?>
                <section class="mx-auto mt-14 grid max-w-[980px] grid-cols-1 gap-3 md:grid-cols-2 md:gap-4">
                    <?php foreach ($gallery_process as $process_image): ?>
                        <?php
                        $process_image_id = $resolve_attachment_id($process_image);
                        if ($process_image_id) {
                            echo wp_get_attachment_image($process_image_id, 'large', false, ['class' => 'block w-full h-[240px] md:h-[340px] object-cover']);
                        }
                        ?>
                    <?php endforeach; ?>
                </section>
            <?php endif; ?>

            <?php if (!$content_has_work_info_shortcode): ?>
                <section
                    class="mx-auto mt-14 grid min-w-0 grid-cols-1 gap-[4em] px-4 md:grid-cols-[minmax(0,33%)_minmax(0,1fr)] md:px-9">
                    <aside class="min-w-0 order-2 md:order-1 border-t border-zinc-500/35 pt-3 md:w-[258px]">
                        <h2 class="m-0 text-[1.7rem] leading-none text-zinc-800">
                            <?php echo esc_html($work_type); ?>
                        </h2>
                        <div class="mt-8 gap-y-12 gap-x-6 grid grid-cols-2 mb-12">
                            <?php if ($site_area !== ''): ?>
                                <div class="">
                                    <div class="text-[9px] uppercase tracking-[0.28em] text-light-brown font-medium 
                                    pb-[18px] border-b border-beige-2 mb-2">
                                        Site Area / M2</div>
                                    <div class="text-[28px] text-dark-brown">
                                        <?php echo esc_html($site_area); ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php if ($floor_area !== ''): ?>
                                <div class="">
                                    <div class="text-[9px] uppercase tracking-[0.28em] text-light-brown font-medium 
                                    pb-[18px] border-b border-beige-2 mb-2">
                                        Floor Area / M2</div>
                                    <div class="text-[28px] text-dark-brown">
                                        <?php echo esc_html($floor_area); ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php if ($bedrooms !== ''): ?>
                                <div class="">
                                    <div class="text-[9px] uppercase tracking-[0.28em] text-light-brown font-medium 
                                    pb-[18px] border-b border-beige-2 mb-2">
                                        Bedrooms</div>
                                    <div class="text-[28px] text-dark-brown">
                                        <?php echo esc_html($bedrooms); ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php if ($floors !== ''): ?>
                                <div class="">
                                    <div class="text-[9px] uppercase tracking-[0.28em] text-light-brown font-medium 
                                    pb-[18px] border-b border-beige-2 mb-2">
                                        Floors</div>
                                    <div class="text-[28px] text-dark-brown">
                                        <?php echo esc_html($floors); ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>

                        <?php if ($client !== ''): ?>
                            <div class="">
                                <div class="text-[9px] uppercase tracking-[0.28em] text-light-brown font-medium 
                                pb-[18px] border-b border-beige-2 mb-2">
                                    Client</div>
                                <div class="text-[28px] text-dark-brown">
                                    <?php echo esc_html($client); ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($credits)): ?>
                            <details class="work-credits mt-14">
                                <summary
                                    class="flex cursor-pointer list-none items-center justify-between gap-6 border-b border-beige-2 pb-[18px] text-[9px] font-medium uppercase tracking-[0.28em] text-light-brown">
                                    <span>Credits</span>
                                    <span class="work-credits__icon h-2 w-2 rotate-45 border-b border-r border-light-brown"
                                        aria-hidden="true"></span>
                                </summary>
                                <div class="grid gap-x-16 gap-y-6 pt-5 text-[12px] leading-tight text-dark-brown grid-cols-2">
                                    <?php foreach ($credits as $credit): ?>
                                        <p class="m-0">
                                            <?php echo esc_html($credit); ?>
                                        </p>
                                    <?php endforeach; ?>
                                </div>
                            </details>
                        <?php endif; ?>
                    </aside>

                    <div class="min-w-0 order-1 md:order-2">
                        <div class="w-full">
                            <?php if (is_numeric($model_image)): ?>
                                <?php echo wp_get_attachment_image((int) $model_image, 'full', false, ['class' => 'block h-auto w-[calc(100%+1rem)] max-w-none object-cover md:w-[calc(100%+2.25rem)]']); ?>
                            <?php elseif (is_array($model_image) && !empty($model_image['url'])): ?>
                                <img src="<?php echo esc_url($model_image['url']); ?>"
                                    alt="<?php echo esc_attr(get_the_title()); ?>"
                                    class="block h-auto w-[calc(100%+1rem)] max-w-none object-cover md:w-[calc(100%+2.25rem)]">
                            <?php elseif (is_string($model_image) && trim($model_image) !== ''): ?>
                                <img src="<?php echo esc_url($model_image); ?>" alt="<?php echo esc_attr(get_the_title()); ?>"
                                    class="block h-auto w-[calc(100%+1rem)] max-w-none object-cover md:w-[calc(100%+2.25rem)]">
                            <?php elseif (has_post_thumbnail()): ?>
                                <?php the_post_thumbnail('large', ['class' => 'block h-auto w-[calc(100%+1rem)] max-w-none object-cover md:w-[calc(100%+2.25rem)]']); ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </section>
            <?php endif; ?>

            <section class="mt-16 hidden min-w-0 gap-[4em] px-4 md:grid md:grid-cols-[minmax(0,33%)_minmax(0,1fr)] md:px-9">
                <div aria-hidden="true"></div>
                <div class="min-w-0">
                    <p class="m-0 text-[10px] uppercase tracking-[0.3em] text-light-brown">Explore Other Works</p>
                    <div class="mt-4 grid grid-cols-2 items-center gap-4 border-t border-beige-2 pt-4">
                        <div>
                            <?php if ($prev_work instanceof WP_Post): ?>
                                <a href="<?php echo esc_url(get_permalink($prev_work->ID)); ?>"
                                    class="inline-flex items-center gap-2 !no-underline text-[10px] uppercase tracking-[0.3em] text-zinc-700 hover:opacity-70">
                                    <img src="<?php echo esc_url(get_template_directory_uri() . '/images/arrow-right.png'); ?>"
                                        alt="" class="h-3 w-3 rotate-180 object-contain">
                                    <span>Prev: <?php echo esc_html(get_the_title($prev_work->ID)); ?></span>
                                </a>
                            <?php endif; ?>
                        </div>
                        <div class="text-right">
                            <?php if ($next_work instanceof WP_Post): ?>
                                <a href="<?php echo esc_url(get_permalink($next_work->ID)); ?>"
                                    class="inline-flex items-center justify-end gap-2 !no-underline text-[10px] uppercase tracking-[0.3em] text-zinc-700 hover:opacity-70">
                                    <span>Next: <?php echo esc_html(get_the_title($next_work->ID)); ?></span>
                                    <img src="<?php echo esc_url(get_template_directory_uri() . '/images/arrow-right.png'); ?>"
                                        alt="" class="h-3 w-3 object-contain">
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </article>
<?php endwhile; ?>

<script>
    (function () {
        var hero = document.getElementById('work-hero');

        if (!hero) {
            return;
        }

        function updateHeaderState() {
            var rect = hero.getBoundingClientRect();
            document.body.classList.toggle('single-work-hero-visible', rect.bottom > 0);
        }

        updateHeaderState();
        window.addEventListener('scroll', updateHeaderState, { passive: true });
        window.addEventListener('resize', updateHeaderState);
    })();
</script>

<?php
get_footer();
?>