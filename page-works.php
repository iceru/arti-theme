<?php
/**
 * Template Name: Works
 *
 * @package TailPress
 */

get_header();

$work_taxonomy = arti_get_work_taxonomy();
$work_types = function_exists('arti_get_work_type_filters') ? arti_get_work_type_filters() : [];

$initial_works_query = new WP_Query([
    'post_type' => 'work',
    'post_status' => 'publish',
    'posts_per_page' => 12,
    'orderby' => 'date',
    'order' => 'ASC',
]);

$featured_works_query = new WP_Query([
    'post_type' => 'work',
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'orderby' => 'menu_order date',
    'order' => 'ASC',
    'meta_query' => [
        'relation' => 'OR',
        [
            'key' => 'featured_hero',
            'value' => ['1', 'Yes', 'yes', 'true', 'True'],
            'compare' => 'IN',
        ],
        [
            'key' => 'featured',
            'value' => ['1', 'Yes', 'yes'],
            'compare' => 'IN',
        ],
        [
            'key' => 'show_in_works_hero',
            'value' => ['1', 'Yes', 'yes', 'true', 'True'],
            'compare' => 'IN',
        ],
    ],
]);
?>

<style>
    .works-featured-hero__slide {
        z-index: 0;
        opacity: 0;
        pointer-events: none;
        transition: opacity 720ms ease;
    }

    .works-featured-hero__slide.is-active {
        z-index: 1;
        opacity: 1;
        pointer-events: auto;
    }

    .works-featured-hero__image {
        transform: scale(1);
    }

    .works-featured-hero__slide.is-active .works-featured-hero__image {
        animation: worksHeroZoom var(--works-hero-duration, 3000ms) linear forwards;
    }

    .works-featured-hero__progress {
        transform: scaleX(0);
        transform-origin: left center;
    }

    .works-featured-hero__progress-track {
        z-index: 2;
    }

    .works-featured-hero__progress.is-active {
        animation: worksHeroProgress var(--works-hero-duration, 3000ms) linear forwards;
    }

    @keyframes worksHeroZoom {
        from {
            transform: scale(1);
        }

        to {
            transform: scale(1.08);
        }
    }

    @keyframes worksHeroProgress {
        from {
            transform: scaleX(0);
        }

        to {
            transform: scaleX(1);
        }
    }

    #works-cards>article {
        opacity: 0.42;
        transform: scale(0.9);
        transform-origin: center center;
        transition: transform 480ms cubic-bezier(0.22, 1, 0.36, 1), opacity 420ms ease;
        will-change: transform, opacity;
    }

    #works-cards>article.is-active {
        opacity: 1;
        transform: scale(1);
    }

    .works-filter-btn {
        display: inline-flex;
        align-items: center;
        gap: 14px;
        opacity: 1;
        color: #3f3f3f;
        font-size: 12px;
        line-height: 1.2;
        letter-spacing: 0;
        transition: color 220ms ease;
    }

    .works-filter-btn:hover {
        color: #2f2f2f;
    }

    .works-filter-btn .works-filter-marker {
        display: inline-block;
        width: 12px;
        height: 12px;
        border-radius: 5px 0 5px 0;
        border: 2px solid #9a9792;
        background: transparent;
        transition: background-color 220ms ease, border-color 220ms ease;
        flex-shrink: 0;
    }

    .works-filter-btn.is-active .works-filter-marker {
        background: #2f2f2f;
        border-color: #2f2f2f;
    }

    #works-filter-panel.is-collapsed {
        display: none;
    }
</style>

<?php if ($featured_works_query->have_posts()): ?>
    <section class="works-featured-hero relative min-h-[calc(100vh-110px)] overflow-hidden bg-black text-white"
        style="--works-hero-duration: 3000ms;" data-featured-works-hero data-slide-duration="3000"
        aria-label="Featured works">
        <?php
        $featured_index = 0;
        while ($featured_works_query->have_posts()):
            $featured_works_query->the_post();
            $featured_type = function_exists('get_field') ? (string) get_field('type') : '';
            if ($featured_type === '') {
                $featured_terms = $work_taxonomy ? get_the_terms(get_the_ID(), $work_taxonomy) : [];
                $featured_type = (!is_wp_error($featured_terms) && !empty($featured_terms)) ? $featured_terms[0]->name : '';
            }
            ?>
            <article
                class="works-featured-hero__slide <?php echo $featured_index === 0 ? 'is-active' : ''; ?> absolute inset-0">
                <a href="<?php the_permalink(); ?>" class="group block h-full !no-underline text-white">
                    <?php if (has_post_thumbnail()): ?>
                        <?php the_post_thumbnail('full', ['class' => 'works-featured-hero__image block h-full w-full object-cover', 'loading' => 'eager', 'decoding' => 'async']); ?>
                    <?php else: ?>
                        <div class="works-featured-hero__image h-full w-full bg-black/30"></div>
                    <?php endif; ?>

                    <div
                        class="absolute inset-x-0 bottom-0 flex min-h-[42%] items-end bg-gradient-to-t from-black/75 to-transparent px-6 pb-10 md:px-9 md:pb-11">
                        <div class="flex w-full items-end justify-between gap-8">
                            <div>
                                <h2 class="m-0 text-[16px] font-medium uppercase tracking-[0.42em] text-white md:text-[18px]">
                                    <?php the_title(); ?>
                                </h2>
                                <?php if ($featured_type !== ''): ?>
                                    <p class="m-0 mt-3 text-[10px] font-medium uppercase tracking-[0.42em] text-white/78">
                                        <?php echo esc_html($featured_type); ?>
                                    </p>
                                <?php endif; ?>
                            </div>
                            <span class="hidden text-[10px] font-medium uppercase tracking-[0.42em] text-white/85 md:block">
                                Explore
                            </span>
                        </div>
                    </div>
                </a>
            </article>
            <?php
            $featured_index++;
        endwhile;
        wp_reset_postdata();
        ?>

        <div class="works-featured-hero__progress-track absolute inset-x-0 bottom-0 h-1 bg-white/15">
            <div class="works-featured-hero__progress is-active h-full w-full bg-beige-1"></div>
        </div>
    </section>
<?php endif; ?>

<section class="bg-beige-1 pb-16 pt-8 md:pt-10 min-h-[80vh]">
    <div class="px-4 md:px-9">
        <div class="mb-8 flex items-start justify-between gap-6 md:py-10">
            <div class="w-full">
                <button type="button" id="works-filter-toggle"
                    class="inline-flex items-center gap-3 border-0 bg-transparent p-0 text-[12px] uppercase tracking-[0.31em] text-light-brown font-medium">
                    <span id="works-filter-count"
                        class="inline-flex h-7 min-w-7 items-center justify-center rounded-full bg-dark-brown px-2 text-[12px] font-medium tracking-normal text-white">0</span>
                    <span id="works-filter-toggle-label">Filter +</span>
                </button>

                <div id="works-filter-panel" class="md:mt-10 is-collapsed">
                    <ul class="m-0 mt-4 grid list-none gap-y-3 md:gap-y-6 gap-x-10 p-0 md:grid-cols-3 max-w-[500px]">
                        <?php if (!empty($work_types)): ?>
                            <?php foreach ($work_types as $type): ?>
                                <li>
                                    <button type="button" class="works-filter-btn text-left "
                                        data-work-type="<?php echo esc_attr($type); ?>">
                                        <span class="works-filter-marker" aria-hidden="true"></span>
                                        <span class="tracking-wider"><?php echo esc_html($type); ?></span>
                                    </button>
                                </li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>

            <div class="w-full max-w-[320px]">
                <label for="works-search" class="sr-only">Search works</label>
                <div class="flex items-center justify-end gap-3 pb-2">
                    <input type="search" id="works-search" placeholder="Search"
                        class="w-0 border-0 border-b border-beige-2 bg-transparent p-0 pb-4 text-right text-[12px] uppercase tracking-[0.42em] text-dark-brown opacity-0 transition-all duration-200 placeholder:text-[#7a7a7a] focus:w-full focus:opacity-100 focus:outline-none md:w-full md:opacity-100">
                    <label for="works-search" class="mb-4 cursor-pointer">
                        <img src="<?php echo esc_url(get_template_directory_uri() . '/images/search.png'); ?>"
                            alt="Search Icon" class="h-4 w-4 object-contain">
                    </label>
                </div>
            </div>
        </div>

    </div>

    <div class="grid grid-cols-[300px_1fr] gap-12 max-md:grid-cols-1 max-md:gap-0">
        <p class="hidden md:block sticky top-36 self-start pl-9 mb-8 text-[12px] uppercase tracking-[0.31em]
            text-dark-brown font-medium">
            Works</p>

        <div id="works-cards" class="space-y-14 w-full px-4 md:px-0 md:pl-8">
            <?php echo arti_render_work_cards_html($initial_works_query, $work_taxonomy ?: 'category'); ?>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const hero = document.querySelector('[data-featured-works-hero]');
        if (!hero) {
            return;
        }

        const slides = Array.from(hero.querySelectorAll('.works-featured-hero__slide'));
        const progress = hero.querySelector('.works-featured-hero__progress');
        const duration = Number(hero.getAttribute('data-slide-duration')) || 3000;
        let activeIndex = 0;

        hero.style.setProperty('--works-hero-duration', duration + 'ms');

        if (!slides.length || !progress) {
            return;
        }

        function restartProgress() {
            progress.classList.remove('is-active');
            void progress.offsetWidth;
            progress.classList.add('is-active');
        }

        function restartSlideAnimation(slide) {
            const image = slide.querySelector('.works-featured-hero__image');
            if (!image) {
                return;
            }

            image.style.animation = 'none';
            void image.offsetWidth;
            image.style.animation = '';
        }

        function showSlide(index) {
            slides[activeIndex].classList.remove('is-active');
            activeIndex = index;
            slides[activeIndex].classList.add('is-active');
            restartSlideAnimation(slides[activeIndex]);
            restartProgress();
        }

        restartProgress();

        if (slides.length < 2) {
            return;
        }

        window.setInterval(function () {
            showSlide((activeIndex + 1) % slides.length);
        }, duration);
    });

    jQuery(function ($) {
        const $toggle = $('#works-filter-toggle');
        const $toggleLabel = $('#works-filter-toggle-label');
        const $panel = $('#works-filter-panel');
        const $counter = $('#works-filter-count');
        const $search = $('#works-search');
        const $cards = $('#works-cards');
        const selectedTypes = new Set();
        let searchTimer = null;
        let scrollTicking = false;

        function setPanelState(isOpen) {
            $panel.toggleClass('is-collapsed', !isOpen);
            $toggleLabel.text(isOpen ? 'Filter -' : 'Filter +');
            $toggle.attr('aria-expanded', isOpen ? 'true' : 'false');
        }

        function getWorkItems() {
            return $cards.children('article');
        }

        function setActiveByIndex(index) {
            const $items = getWorkItems();
            if (!$items.length) {
                return;
            }

            const safeIndex = Math.max(0, Math.min(index, $items.length - 1));
            $items.removeClass('is-active');
            $items.eq(safeIndex).addClass('is-active');
        }

        function updateActiveItemByViewportCenter() {
            const $items = getWorkItems();
            if (!$items.length) {
                return;
            }

            const viewportCenterY = window.innerHeight / 2;
            let nearestIndex = 0;
            let nearestDistance = Infinity;

            $items.each(function (idx) {
                const rect = this.getBoundingClientRect();
                const itemCenterY = rect.top + (rect.height / 2);
                const distance = Math.abs(itemCenterY - viewportCenterY);

                if (distance < nearestDistance) {
                    nearestDistance = distance;
                    nearestIndex = idx;
                }
            });

            setActiveByIndex(nearestIndex);
        }

        function queueActiveUpdate() {
            if (scrollTicking) {
                return;
            }

            scrollTicking = true;
            window.requestAnimationFrame(function () {
                updateActiveItemByViewportCenter();
                scrollTicking = false;
            });
        }

        function initWorkScrollState() {
            setActiveByIndex(0);
        }

        function updateCounter() {
            $counter.text(selectedTypes.size);
        }

        function fetchWorks() {
            $.ajax({
                url: '<?php echo esc_url(admin_url('admin-ajax.php')); ?>',
                method: 'POST',
                dataType: 'json',
                data: {
                    action: 'arti_filter_work_posts',
                    nonce: '<?php echo esc_js(wp_create_nonce('arti_filter_work_nonce')); ?>',
                    types: Array.from(selectedTypes),
                    search: $search.val()
                },
                beforeSend: function () {
                    $cards.css('opacity', '0.35');
                },
                success: function (response) {
                    if (!response || !response.success || !response.data) {
                        return;
                    }
                    $cards.html(response.data.html);
                    $counter.text(response.data.selected_count || 0);
                    initWorkScrollState();
                    queueActiveUpdate();
                },
                complete: function () {
                    $cards.css('opacity', '1');
                }
            });
        }

        $(document).on('click', '.works-filter-btn', function () {
            const type = String($(this).data('work-type') || '').trim();

            if (!type) {
                return;
            }

            if (selectedTypes.has(type)) {
                selectedTypes.delete(type);
                $(this).removeClass('is-active');
            } else {
                selectedTypes.add(type);
                $(this).addClass('is-active');
            }

            updateCounter();
            fetchWorks();
        });

        $search.on('input', function () {
            clearTimeout(searchTimer);
            searchTimer = setTimeout(function () {
                fetchWorks();
            }, 280);
        });

        $toggle.on('click', function () {
            const isOpen = !$panel.hasClass('is-collapsed');
            setPanelState(!isOpen);
        });

        $(window).on('scroll resize', queueActiveUpdate);

        setPanelState(false);
        updateCounter();
        initWorkScrollState();
    });
</script>

<?php
get_footer();
