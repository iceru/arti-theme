<?php
/**
 * Template Name: Studio
 *
 * @package TailPress
 */

get_header();
?>

<section class="bg-beige-1 pt-4 pb-20 max-md:pb-16" aria-labelledby="studio-about-title">
    <div class="grid grid-cols-[minmax(220px,300px)_1fr] gap-8 max-md:grid-cols-1 max-md:gap-0">
        <aside
            class="hidden md:block relative min-h-full bg-beige-1 max-md:border-r-0 max-md:border-b max-md:border-black/8"
            aria-label="Studio sections">
            <div class="absolute inset-0 bg-repeat bg-[length:1500px_auto] bg-top opacity-40 pointer-events-none"
                style="background-image: url('<?php echo esc_url(get_theme_file_uri('/images/bg.png')); ?>');"></div>
            <div class="sticky top-11 ml-6 pt-28 z-10">
                <nav class="relative bg-beige-1 inline-flex flex-col gap-3 py-2 px-4 ">
                    <a href="#about-us"
                        class="studio-nav-link !no-underline font-medium text-[12px] uppercase tracking-[31%] text-dark-brown opacity-100">
                        <span class="studio-nav-dot mr-[0.45rem]">&bull;</span>About Us
                    </a>
                    <a href="#the-arti-way"
                        class="studio-nav-link !no-underline font-medium text-[12px] uppercase tracking-[31%] text-dark-brown opacity-40"><span
                            class="studio-nav-dot mr-[0.45rem] opacity-0">&bull;</span>The Arti
                        Way</a>
                    <a href="#expertise"
                        class="studio-nav-link !no-underline font-medium text-[12px] uppercase tracking-[31%] text-dark-brown opacity-40"><span
                            class="studio-nav-dot mr-[0.45rem] opacity-0">&bull;</span>Expertise</a>
                    <a href="#awards"
                        class="studio-nav-link !no-underline font-medium text-[12px] uppercase tracking-[31%] text-dark-brown opacity-40"><span
                            class="studio-nav-dot mr-[0.45rem] opacity-0">&bull;</span>Awards</a>
                </nav>
            </div>
        </aside>

        <div class="min-w-0 pt-32 max-md:px-5 max-md:pt-14">
            <section class="md:pb-32 pb-14 px-8" aria-labelledby="studio-about-title">
                <h4 class="mb-10 md:mb-14 text-[12px] uppercase tracking-[31%] font-medium text-light-brown"
                    id="about-us">About
                    Us
                </h4>
                <h1 class="mb-7 leading-[1.2] font-medium uppercase tracking-[0.18em] text-dark-brown"
                    id="studio-about-title">
                    Collaboration In Form
                </h1>
                <p
                    class="m-0 max-w-[620px] text-[12px] leading-[1.85] text-light-brown max-md:text-[12px] max-md:leading-[1.7]">
                    Established in 2020, Arti Design Studio is a Jakarta-based practice reconnecting people with nature
                    through experimental design. With a portfolio of 100+ projects and a growing skyline of completed
                    works, we use data and research to solve the environmental and societal challenges of the modern
                    city. We aren’t just designing for today; we are building the future of culture and community.
                </p>

                <div class="mt-16 flex justify-end">
                    <img src="<?php echo esc_url(get_theme_file_uri('/images/about.jpg')); ?>"
                        class="max-w-[270px] object-cover" alt="About Arti Design Studio">
                </div>
            </section>

            <section class="pt-12 max-md:pt-10 px-8" id="the-arti-way" aria-labelledby="arti-way-title">
                <div class="border-t border-black/15 pt-4">
                    <h4 class="mb-10 md:mb-14 text-[12px] uppercase tracking-[0.5em] text-light-brown">The Arti Way</h4>
                    <h3 class="mb-5 leading-[1.2] font-medium uppercase tracking-[0.2em] text-light-brown"
                        id="arti-way-title">
                        PRACTICED WITHIN, REFLECTED BEYOND
                    </h3>
                    <p class="m-0 max-w-[428px] text-[12px] leading-[1.8] text-light-brown">
                        The four principles of A.R.T.I also guide the way we design beyond the studio. They shape how
                        our work meets the world and how each project enriches daily life, respects its environments,
                        and strengthens the places it becomes part of, and relevant for the future it will take part in.
                    </p>
                </div>

                <div>
                    <img src="<?php echo esc_url(get_theme_file_uri('/images/arti-way.png')); ?>"
                        class="w-full md:max-w-[490px] my-16" alt="The Arti Way">
                </div>

                <div class="arti-way-accordion">
                    <article class="arti-way-item border-b border-black/14"
                        data-bg="<?php echo esc_url(get_theme_file_uri('/images/artisan.png')); ?>">
                        <button type="button"
                            class="arti-way-trigger flex cursor-pointer w-full items-center gap-4 px-4 py-6 md:px-10 md:py-6 text-left transition-colors duration-300 "
                            aria-expanded="false">
                            <span
                                class="arti-way-number md:w-20 shrink-0 text-[12px] tracking-[0.4em] text-black/70">01</span>
                            <span
                                class="arti-way-label w-44 shrink-0 text-[12px] font-semibold uppercase tracking-[0.42em] text-[#2d2d2d] max-md:w-auto">Artisan</span>
                            <span class="arti-way-title text-[12px] text-black/72">Design with Depth &amp;
                                Character</span>
                        </button>
                        <div class="arti-way-panel hidden px-0 ">
                            <div class="grid grid-cols-3 gap-8 max-md:grid-cols-1 max-md:gap-6 py-12">
                                <p class="m-0 text-[0.76rem] leading-[1.8] text-black/70">Design with a maker's
                                    sensitivity, shaping spaces through refined judgment, deliberate choices, and a deep
                                    respect for craft.</p>
                                <div>
                                    <h3
                                        class="mb-3 text-[0.62rem] font-semibold uppercase tracking-[31%] text-dark-brown">
                                        Building With Subtle Details</h3>
                                    <p class="m-0 text-[0.76rem] leading-[1.8] text-black/70">Focusing on proportions,
                                        materials, and crafted enriching elements that reveal their quality through
                                        daily use and closer attention.</p>
                                </div>
                                <div>
                                    <h3
                                        class="mb-3 text-[0.62rem] font-semibold uppercase tracking-[31%] text-dark-brown">
                                        Recognizable Arti-Esque Spaces</h3>
                                    <p class="m-0 text-[0.76rem] leading-[1.8] text-black/70">Shaping projects with a
                                        clear design language, creating spaces that are memorable, coherent, and
                                        reflective of ARTI's approach to making architecture.</p>
                                </div>
                            </div>
                        </div>
                    </article>

                    <article class="arti-way-item border-b border-black/14"
                        data-bg="<?php echo esc_url(get_theme_file_uri('/images/responsible.png')); ?>">
                        <button type="button"
                            class="arti-way-trigger flex cursor-pointer w-full items-center gap-4 px-4 py-6 md:px-10 md:py-6 text-left transition-colors duration-300"
                            aria-expanded="false">
                            <span
                                class="arti-way-number md:w-20 shrink-0 text-[12px] tracking-[0.4em] text-black/70">02</span>
                            <span
                                class="arti-way-label w-44 shrink-0 text-[12px] font-semibold uppercase tracking-[0.42em] text-[#2d2d2d] max-md:w-auto">Responsible</span>
                            <span class="arti-way-title text-[12px] text-black/72">Architecture that Supports
                                Life</span>
                        </button>
                        <div class="arti-way-panel hidden px-0">
                            <div class="grid grid-cols-3 gap-8 max-md:grid-cols-1 max-md:gap-6 py-14">
                                <p class="m-0 text-[0.76rem] leading-[1.8] text-black/70">We design with accountability
                                    to people and place, making architecture that serves communities, supports ecology,
                                    and remains useful over time.</p>
                                <div>
                                    <h3
                                        class="mb-3 text-[0.62rem] font-semibold uppercase tracking-[31%] text-dark-brown">
                                        Life-Centered Systems</h3>
                                    <p class="m-0 text-[0.76rem] leading-[1.8] text-black/70">Programs, circulation, and
                                        environmental strategies are integrated to improve daily comfort and long-term
                                        resilience.</p>
                                </div>
                                <div>
                                    <h3
                                        class="mb-3 text-[0.62rem] font-semibold uppercase tracking-[31%] text-dark-brown">
                                        Material Responsibility</h3>
                                    <p class="m-0 text-[0.76rem] leading-[1.8] text-black/70">From sourcing to
                                        durability, we prioritize practical and responsible decisions that reduce waste
                                        while preserving character.</p>
                                </div>
                            </div>
                        </div>
                    </article>

                    <article class="arti-way-item border-b border-black/14"
                        data-bg="<?php echo esc_url(get_theme_file_uri('/images/tradition.png')); ?>">
                        <button type="button"
                            class="arti-way-trigger flex cursor-pointer w-full items-center gap-4 px-4 py-6 md:px-10 md:py-6 text-left transition-colors duration-300"
                            aria-expanded="false">
                            <span
                                class="arti-way-number md:w-20 shrink-0 text-[12px] tracking-[0.4em] text-black/70">03</span>
                            <span
                                class="arti-way-label w-44 shrink-0 text-[12px] font-semibold uppercase tracking-[0.42em] text-[#2d2d2d] max-md:w-auto">Tradition</span>
                            <span class="arti-way-title text-[12px] text-black/72">Rooted in Culture, Responsive to
                                Place</span>
                        </button>
                        <div class="arti-way-panel hidden px-0">
                            <div class="grid grid-cols-3 gap-8 max-md:grid-cols-1 max-md:gap-6 py-14">
                                <p class="m-0 text-[0.76rem] leading-[1.8] text-black/70">Honor the narratives that came
                                    before us, weaving local heritage and community realities into designs that feel
                                    rooted and relevant.</p>
                                <div>
                                    <h3
                                        class="mb-3 text-[0.62rem] font-semibold uppercase tracking-[31%] text-dark-brown">
                                        Preserving and Elevating Cultural Values</h3>
                                    <p class="m-0 text-[0.76rem] leading-[1.8] text-black/70">Local narratives,
                                        practices, and identities are carefully studied and thoughtfully reinterpreted
                                        to strengthen a sense of belonging.</p>
                                </div>
                                <div>
                                    <h3
                                        class="mb-3 text-[0.62rem] font-semibold uppercase tracking-[31%] text-dark-brown">
                                        Site-Sensitive Design</h3>
                                    <p class="m-0 text-[0.76rem] leading-[1.8] text-black/70">Each design responds
                                        directly to climate, context, and topography so the building relates naturally
                                        to its environment.</p>
                                </div>
                            </div>
                        </div>
                    </article>

                    <article class="arti-way-item"
                        data-bg="<?php echo esc_url(get_theme_file_uri('/images/innovation.png')); ?>">
                        <button type="button"
                            class="arti-way-trigger flex cursor-pointer w-full items-center gap-4 px-4 py-6 md:px-10 md:py-6 text-left transition-colors duration-300"
                            aria-expanded="false">
                            <span
                                class="arti-way-number md:w-20 shrink-0 text-[12px] tracking-[0.4em] text-black/70">04</span>
                            <span
                                class="arti-way-label w-44 shrink-0 text-[12px] font-semibold uppercase tracking-[0.42em] text-[#2d2d2d] max-md:w-auto">Innovation</span>
                            <span class="arti-way-title text-[12px] text-black/72">Fresh Perspective for a Better
                                Future</span>
                        </button>
                        <div class="arti-way-panel hidden px-0">
                            <div class="grid grid-cols-3 gap-8 max-md:grid-cols-1 max-md:gap-6 py-14">
                                <p class="m-0 text-[0.76rem] leading-[1.8] text-black/70">We challenge assumptions and
                                    test new approaches so each project can contribute new value to its users and
                                    context.</p>
                                <div>
                                    <h3
                                        class="mb-3 text-[0.62rem] font-semibold uppercase tracking-[31%] text-dark-brown">
                                        Future-Ready Thinking</h3>
                                    <p class="m-0 text-[0.76rem] leading-[1.8] text-black/70">Spatial flexibility,
                                        environmental foresight, and design experimentation support buildings that adapt
                                        over time.</p>
                                </div>
                                <div>
                                    <h3
                                        class="mb-3 text-[0.62rem] font-semibold uppercase tracking-[31%] text-dark-brown">
                                        Cross-Disciplinary Process</h3>
                                    <p class="m-0 text-[0.76rem] leading-[1.8] text-black/70">Collaboration across
                                        craft, research, and technology allows architecture to solve complexity with
                                        clarity.</p>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>
            </section>

            <section class="min-w-0 pt-20 max-md:pt-14 pl-8" id="expertise" aria-labelledby="expertise-title">
                <div class="border-t border-black/15 pt-6">
                    <p class="mb-20 text-[12px] uppercase tracking-[0.31em] text-light-brown">Expertise</p>
                </div>

                <?php
                $expertise_query = new WP_Query([
                    'post_type' => 'expertise',
                    'posts_per_page' => -1,
                    'orderby' => 'menu_order',
                    'order' => 'ASC',
                ]);
                ?>

                <?php if ($expertise_query->have_posts()): ?>
                    <div class="min-w-0 space-y-24 max-md:space-y-16">
                        <?php
                        $expertise_index = 0;
                        while ($expertise_query->have_posts()):
                            $expertise_query->the_post();
                            $expertise_index++;

                            $expertise_description = wp_strip_all_tags(get_the_content());
                            $expertise_items = function_exists('get_field') ? get_field('expertise_items') : [];
                            ?>
                            <article class="min-w-0 overflow-hidden">
                                <h2 class="mb-8 leading-[1.2] font-medium uppercase tracking-[0.2em] text-dark-brown"
                                    id="<?php echo esc_attr($expertise_index === 1 ? 'expertise-title' : 'expertise-title-' . $expertise_index); ?>">
                                    <?php the_title(); ?>
                                </h2>

                                <?php if (!empty($expertise_description)): ?>
                                    <p class="m-0 mb-12 max-w-[721px] text-[12px] leading-[1.8] text-light-brown">
                                        <?php echo esc_html($expertise_description); ?>
                                    </p>
                                <?php endif; ?>

                                <?php if (!empty($expertise_items) && is_array($expertise_items)): ?>
                                    <?php $use_horizontal_track = count($expertise_items) > 3; ?>
                                    <div class="<?php echo $use_horizontal_track ? 'expertise-items-track w-full max-w-full overflow-x-auto overflow-y-hidden pb-3 [scrollbar-width:none] [-ms-overflow-style:none] [&::-webkit-scrollbar]:hidden' : ''; ?>"
                                        <?php echo $use_horizontal_track ? 'data-horizontal-scroll-lock="true"' : ''; ?>>
                                        <div
                                            class="<?php echo $use_horizontal_track ? 'flex w-max max-w-none gap-5' : 'grid grid-cols-1 gap-5 md:grid-cols-3'; ?>">
                                            <?php foreach ($expertise_items as $item): ?>
                                                <?php
                                                $item_title = '';
                                                $item_image_url = '';

                                                if (is_object($item) && isset($item->ID)) {
                                                    $item_title = get_the_title($item->ID);
                                                    $item_image_url = get_the_post_thumbnail_url($item->ID, 'large');
                                                    if (function_exists('get_field') && !$item_image_url) {
                                                        $item_image = get_field('image', $item->ID);
                                                        if (is_array($item_image) && !empty($item_image['url'])) {
                                                            $item_image_url = $item_image['url'];
                                                        } elseif (is_numeric($item_image)) {
                                                            $item_image_url = wp_get_attachment_image_url((int) $item_image, 'large');
                                                        }
                                                    }
                                                } elseif (is_array($item)) {
                                                    $item_title = isset($item['title']) ? (string) $item['title'] : '';
                                                    if (empty($item_title) && isset($item['name'])) {
                                                        $item_title = (string) $item['name'];
                                                    }

                                                    if (!empty($item['image']) && is_array($item['image']) && !empty($item['image']['url'])) {
                                                        $item_image_url = $item['image']['url'];
                                                    } elseif (!empty($item['image']) && is_numeric($item['image'])) {
                                                        $item_image_url = wp_get_attachment_image_url((int) $item['image'], 'large');
                                                    } elseif (!empty($item['thumbnail']) && is_array($item['thumbnail']) && !empty($item['thumbnail']['url'])) {
                                                        $item_image_url = $item['thumbnail']['url'];
                                                    }
                                                }
                                                ?>
                                                <article
                                                    class="<?php echo $use_horizontal_track ? 'w-[260px] shrink-0 md:w-[420px]' : ''; ?>">
                                                    <div class="overflow-hidden">
                                                        <?php if (!empty($item_image_url)): ?>
                                                            <img src="<?php echo esc_url($item_image_url); ?>"
                                                                alt="<?php echo esc_attr($item_title); ?>"
                                                                class="block aspect-[16/10] rounded-bl-2xl w-full object-cover">
                                                        <?php else: ?>
                                                            <div class="aspect-[16/10] w-full rounded-bl-2xl bg-black/10"></div>
                                                        <?php endif; ?>
                                                    </div>
                                                    <?php if (!empty($item_title)): ?>
                                                        <h3 class="mt-4 text-[12px] font-medium uppercase tracking-[0.31em] text-[#2d2d2d]">
                                                            <?php echo esc_html($item_title); ?>
                                                        </h3>
                                                    <?php endif; ?>
                                                </article>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </article>
                        <?php endwhile; ?>
                    </div>
                    <?php wp_reset_postdata(); ?>
                <?php endif; ?>
            </section>

            <section class="pt-20 max-md:pt-14 px-8" id="awards" aria-labelledby="awards-title">
                <div class="border-t border-black/15 pt-6">
                    <p class="mb-10 text-[12px] uppercase tracking-[0.5em] text-light-brown">Awards</p>

                    <p class="m-0 mb-16 max-w-[700px] text-[12px] leading-[1.8] text-light-brown max-md:mb-12">
                        Arti Design Studio is a multi-disciplinary and award-winning practice that places
                        sustainability, community, and craftsmanship at the heart of every project. Through
                        narrative-led design and deep engagement, we shape environments that inspire and endure.
                    </p>
                </div>

                <?php
                $awards_query = new WP_Query([
                    'post_type' => ['award', 'awards'],
                    'post_status' => 'publish',
                    'posts_per_page' => -1,
                    'orderby' => 'date',
                    'order' => 'DESC',
                ]);
                ?>

                <div>
                    <div
                        class="grid grid-cols-[6fr_1fr] md:grid-cols-[1fr_260px] gap-4 border-b border-black/12 py-4 text-[12px] tracking-[0.08em] text-light-brown">
                        <p class="m-0">List</p>
                        <p class="m-0 hidden md:block">Year</p>
                    </div>

                    <?php if ($awards_query->have_posts()): ?>
                        <?php while ($awards_query->have_posts()):
                            $awards_query->the_post();
                            $award_year = '';
                            $award_text_sources = [
                                wp_strip_all_tags(get_the_content()),
                            ];

                            foreach ($award_text_sources as $award_text_source) {
                                if (preg_match('/\b(19|20)\d{2}\b/', (string) $award_text_source, $award_year_match)) {
                                    $award_year = $award_year_match[0];
                                    break;
                                }
                            }

                            if ($award_year === '') {
                                $award_year = get_the_date('Y');
                            }
                            ?>
                            <div
                                class="grid grid-cols-[6fr_1fr] md:grid-cols-[1fr_260px] gap-4 border-b border-black/12 py-5 text-[12px] leading-[1.7] text-dark-brown">
                                <p class="m-0"><?php the_title(); ?></p>
                                <p class="m-0 "><?php echo esc_html((string) $award_year); ?></p>
                            </div>
                        <?php endwhile; ?>
                        <?php wp_reset_postdata(); ?>
                    <?php else: ?>
                        <div
                            class="grid grid-cols-[6fr_1fr] md:grid-cols-[1fr_260px] gap-4 border-b border-black/12 py-5 text-[12px] leading-[1.7] text-dark-brown">
                            <p class="m-0">Example 1 (no data): National Architecture Merit Award - Best Installation</p>
                            <p class="m-0 ">2022</p>
                        </div>
                        <div
                            class="grid grid-cols-[6fr_1fr] md:grid-cols-[1fr_260px] gap-4 border-b border-black/12 py-5 text-[12px] leading-[1.7] text-dark-brown">
                            <p class="m-0">Example 2 (no data): Regional Design Prize - Community Space Category</p>
                            <p class="m-0 ">2019</p>
                        </div>
                    <?php endif; ?>
                </div>
            </section>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tracks = Array.from(document.querySelectorAll('.expertise-items-track[data-horizontal-scroll-lock="true"]'));
        if (!tracks.length) {
            return;
        }

        const trackStates = new WeakMap();
        const SCROLL_EASE = 0.18;
        const STOP_THRESHOLD = 0.5;
        let lenisResumeTimer = 0;

        function pauseLenisBriefly() {
            if (!window.lenis || typeof window.lenis.stop !== 'function' || typeof window.lenis.start !== 'function') {
                return;
            }

            window.lenis.stop();
            window.clearTimeout(lenisResumeTimer);
            lenisResumeTimer = window.setTimeout(function () {
                window.lenis.start();
            }, 120);
        }

        function getTrackState(track) {
            if (!trackStates.has(track)) {
                trackStates.set(track, {
                    target: track.scrollLeft,
                    rafId: 0,
                });
            }
            return trackStates.get(track);
        }

        function animateTrack(track) {
            const state = getTrackState(track);
            const diff = state.target - track.scrollLeft;

            if (Math.abs(diff) <= STOP_THRESHOLD) {
                track.scrollLeft = state.target;
                state.rafId = 0;
                return;
            }

            track.scrollLeft += diff * SCROLL_EASE;
            state.rafId = window.requestAnimationFrame(function () {
                animateTrack(track);
            });
        }

        function queueTrackScroll(track, deltaY) {
            const state = getTrackState(track);
            const maxScrollLeft = Math.max(0, track.scrollWidth - track.clientWidth);
            state.target = Math.max(0, Math.min(maxScrollLeft, state.target + deltaY));

            if (!state.rafId) {
                state.rafId = window.requestAnimationFrame(function () {
                    animateTrack(track);
                });
            }
        }

        function getActiveTrack() {
            const viewportHeight = window.innerHeight || document.documentElement.clientHeight;
            return tracks.find(function (track) {
                const rect = track.getBoundingClientRect();
                const topTrigger = viewportHeight * 0.22;
                const bottomTrigger = viewportHeight * 0.92;
                return rect.top >= topTrigger && rect.bottom <= bottomTrigger;
            }) || null;
        }

        function moveTrackWithWheel(track, deltaY) {
            if (!track || deltaY === 0) {
                return false;
            }

            if (track.scrollWidth <= track.clientWidth) {
                return false;
            }

            const state = getTrackState(track);
            const maxScrollLeft = track.scrollWidth - track.clientWidth;
            const currentOrTarget = Math.max(track.scrollLeft, state.target);
            const currentOrTargetMin = Math.min(track.scrollLeft, state.target);
            const canScrollRight = currentOrTarget < (maxScrollLeft - 1);
            const canScrollLeft = currentOrTargetMin > 1;

            if ((deltaY > 0 && canScrollRight) || (deltaY < 0 && canScrollLeft)) {
                queueTrackScroll(track, deltaY);
                return true;
            }

            return false;
        }

        tracks.forEach(function (track) {
            // Strong lock when cursor is on/inside the horizontal track.
            track.addEventListener('wheel', function (event) {
                const deltaY = event.deltaY || 0;
                if (moveTrackWithWheel(track, deltaY)) {
                    event.preventDefault();
                    event.stopPropagation();
                    pauseLenisBriefly();
                }
            }, { passive: false });
        });

        // Fallback lock when cursor is outside track but Expertise area is in view.
        window.addEventListener('wheel', function (event) {
            const track = getActiveTrack();
            if (!track) {
                return;
            }

            const deltaY = event.deltaY || 0;
            if (moveTrackWithWheel(track, deltaY)) {
                event.preventDefault();
                event.stopPropagation();
                pauseLenisBriefly();
            }
        }, { passive: false });
    });
</script>

<?php
get_footer();
?>