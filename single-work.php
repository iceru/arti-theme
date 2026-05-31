<?php
/**
 * Single Work template.
 *
 * @package TailPress
 */

get_header();
?>

<?php
$work_taxonomy = arti_get_work_taxonomy();

$get_first_field = static function (array $keys, $default = '') {
    if (!function_exists('get_field')) {
        return $default;
    }

    foreach ($keys as $key) {
        $value = get_field($key);
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

    $prev_work = get_adjacent_post(false, '', true, '');
    $next_work = get_adjacent_post(false, '', false, '');

    if (!($next_work instanceof WP_Post)) {
        $fallback_next = get_posts([
            'post_type' => 'work',
            'posts_per_page' => 1,
            'post_status' => 'publish',
            'orderby' => 'date',
            'order' => 'ASC',
            'post__not_in' => [get_the_ID()],
        ]);

        if (!empty($fallback_next) && $fallback_next[0] instanceof WP_Post) {
            $next_work = $fallback_next[0];
        }
    }
    ?>

    <article <?php post_class('bg-beige-1 text-zinc-800 px-4 md:px-7 pb-16 md:pb-20'); ?>>
        <div class="mx-auto max-w-[1800px]">
            <section class="relative overflow-hidden">
                <?php if (has_post_thumbnail()): ?>
                    <?php the_post_thumbnail('full', ['class' => 'block w-full h-[48vh] md:h-[74vh] xl:h-[84vh] object-cover rounded-br-[5rem] md:rounded-br-[11rem]']); ?>
                <?php else: ?>
                    <div class="h-[48vh] w-full rounded-br-[5rem] bg-black/10 md:h-[74vh] md:rounded-br-[11rem] xl:h-[84vh]">
                    </div>
                <?php endif; ?>

                <div
                    class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black to-transparent md:rounded-br-[11rem] pb-11 pt-16 pl-9">
                    <h1 class="m-0 text-lg uppercase tracking-[0.28em] text-white md:text-[1.75rem] md:tracking-[0.34em]">
                        <?php the_title(); ?>
                    </h1>
                    <div
                        class="mt-2 flex flex-wrap items-center gap-x-8 gap-y-1 text-[0.62rem] uppercase tracking-[0.3em] text-white/85">
                        <?php if ($location !== ''): ?>
                            <span><?php echo esc_html($location); ?></span>
                        <?php endif; ?>
                        <?php if ($year !== ''): ?>
                            <span><?php echo esc_html($year); ?></span>
                        <?php endif; ?>
                        <span><?php echo esc_html($work_type); ?></span>
                    </div>
                </div>
            </section>

            <!-- <section class="grid grid-cols-1 gap-8 py-12 md:grid-cols-[220px_1fr_1fr] md:gap-8 md:py-16">
                <p class="m-0 pt-1 text-[0.62rem] uppercase tracking-[0.32em] text-zinc-700/80">
                    <?php echo esc_html($intro_title !== '' ? $intro_title : 'Project Overview'); ?>
                </p>
                <p class="m-0 text-[0.74rem] leading-[1.95] text-zinc-700">
                    <?php echo esc_html($intro_text !== '' ? $intro_text : wp_trim_words(wp_strip_all_tags(get_the_excerpt()), 44, '...')); ?>
                </p>
                <p class="m-0 text-[0.74rem] leading-[1.95] text-zinc-700">
                    <?php echo esc_html($concept_text !== '' ? $concept_text : 'This section is editable from WordPress fields, while the middle narrative below can be fully customized from the post content editor.'); ?>
                </p>
            </section> -->

            <section class="mx-auto mt-32">
                <div class="entry-content text-zinc-800/85
                    [&_p]:text-light-brown [&_p]:text-[9px]
                    [&_h2]:text-dark-brown [&_h2]:text-[12px] [&_h2]:mt-0 [&_h2]:uppercase [&_h2]:mb-7 [&_h2]:tracking-[0.31em] [&_h2]:font-medium
                    [&_figure]:my-8 [&_figcaption]:mt-2 [&_figcaption]:text-[0.66rem] [&_figcaption]:text-light-brown
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

            <section class="mx-auto mt-14 grid grid-cols-1 gap-[2em] md:grid-cols-[33%_66%]">
                <aside class="border-t border-zinc-500/35 pt-3 w-1/2">
                    <h2 class="m-0 text-[1.7rem] leading-none text-zinc-800"><?php echo esc_html($work_type); ?></h2>
                    <dl class="mt-8 space-y-5">
                        <?php if ($site_area !== ''): ?>
                            <div class="border-b border-zinc-500/25 pb-2">
                                <dt class="text-[0.58rem] uppercase tracking-[0.28em] text-light-brown">Site Area (m2)</dt>
                                <dd class="m-0 mt-2 text-2xl text-zinc-800"><?php echo esc_html($site_area); ?></dd>
                            </div>
                        <?php endif; ?>
                        <?php if ($floors !== ''): ?>
                            <div class="border-b border-zinc-500/25 pb-2">
                                <dt class="text-[0.58rem] uppercase tracking-[0.28em] text-light-brown">Floors</dt>
                                <dd class="m-0 mt-2 text-2xl text-zinc-800"><?php echo esc_html($floors); ?></dd>
                            </div>
                        <?php endif; ?>
                        <?php if ($bedrooms !== ''): ?>
                            <div class="border-b border-zinc-500/25 pb-2">
                                <dt class="text-[0.58rem] uppercase tracking-[0.28em] text-light-brown">Bedrooms</dt>
                                <dd class="m-0 mt-2 text-2xl text-zinc-800"><?php echo esc_html($bedrooms); ?></dd>
                            </div>
                        <?php endif; ?>
                        <?php if ($client !== ''): ?>
                            <div class="border-b border-zinc-500/25 pb-2">
                                <dt class="text-[0.58rem] uppercase tracking-[0.28em] text-light-brown">Client</dt>
                                <dd class="m-0 mt-2 text-xl text-zinc-800"><?php echo esc_html($client); ?></dd>
                            </div>
                        <?php endif; ?>
                        <?php if ($status !== ''): ?>
                            <div class="border-b border-zinc-500/25 pb-2">
                                <dt class="text-[0.58rem] uppercase tracking-[0.28em] text-light-brown">Status</dt>
                                <dd class="m-0 mt-2 text-sm uppercase tracking-[0.2em] text-zinc-700">
                                    <?php echo esc_html($status); ?>
                                </dd>
                            </div>
                        <?php endif; ?>
                    </dl>
                </aside>

                <div>
                    <?php if (is_numeric($model_image)): ?>
                        <?php echo wp_get_attachment_image((int) $model_image, 'full', false, ['class' => 'block w-full h-auto object-cover']); ?>
                    <?php elseif (is_array($model_image) && !empty($model_image['url'])): ?>
                        <img src="<?php echo esc_url($model_image['url']); ?>" alt="<?php echo esc_attr(get_the_title()); ?>"
                            class="block h-auto w-full object-cover">
                    <?php elseif (is_string($model_image) && trim($model_image) !== ''): ?>
                        <img src="<?php echo esc_url($model_image); ?>" alt="<?php echo esc_attr(get_the_title()); ?>"
                            class="block h-auto w-full object-cover">
                    <?php elseif (has_post_thumbnail()): ?>
                        <?php the_post_thumbnail('large', ['class' => 'block h-auto w-full object-cover']); ?>
                    <?php endif; ?>
                </div>
            </section>

            <section class="mt-16 grid grid-cols-[33%_66%] gap-[2em]">
                <div aria-hidden="true"></div>
                <div>
                    <p class="m-0 text-[0.6rem] uppercase tracking-[0.3em] text-light-brown">Explore Other Works</p>
                    <div class="mt-4 grid grid-cols-2 items-center gap-4 border-t border-beige-2 pt-4">
                        <div>
                            <?php if ($prev_work instanceof WP_Post): ?>
                                <a href="<?php echo esc_url(get_permalink($prev_work->ID)); ?>"
                                    class="!no-underline text-[0.62rem] uppercase tracking-[0.3em] text-zinc-700 hover:opacity-70">
                                    <- Prev: <?php echo esc_html(get_the_title($prev_work->ID)); ?> </a>
                                    <?php endif; ?>
                        </div>
                        <div class="text-right">
                            <?php if ($next_work instanceof WP_Post): ?>
                                <a href="<?php echo esc_url(get_permalink($next_work->ID)); ?>"
                                    class="!no-underline text-[0.62rem] uppercase tracking-[0.3em] text-zinc-700 hover:opacity-70">
                                    Next: <?php echo esc_html(get_the_title($next_work->ID)); ?> ->
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </article>
<?php endwhile; ?>

<?php
get_footer();
?>