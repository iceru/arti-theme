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
            class="hidden md:block relative min-h-full border-r border-black/8 bg-[radial-gradient(circle_at_1px_1px,rgba(0,0,0,0.16)_1px,transparent_1px)] bg-[size:25px_25px] max-md:border-r-0 max-md:border-b max-md:border-black/8 max-md:bg-[size:22px_22px]"
            aria-label="Studio sections">
            <nav
                class="sticky top-11 flex flex-col gap-3.5 px-8 pt-32 pb-8 max-md:static max-md:flex-row max-md:flex-wrap max-md:gap-x-5 max-md:gap-y-4 max-md:px-5 max-md:pt-8 max-md:pb-6">
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
        </aside>

        <div class="px-4 md:px-8 pt-32 max-md:px-5 max-md:pt-14">
            <section class="min-h-[84vh] max-md:min-h-0" aria-labelledby="studio-about-title">
                <h4 class="mb-10 md:mb-14 text-[12px] uppercase tracking-[31%] font-medium text-light-brown"
                    id="about-us">About
                    Us
                </h4>
                <h1 class="mb-7 text-sm leading-[1.2] font-medium uppercase tracking-[0.18em] text-dark-brown max-md:text-[1.32rem] max-md:tracking-[0.14em]"
                    id="studio-about-title">
                    Collaboration In Form
                </h1>
                <p
                    class="m-0 max-w-[620px] text-[0.82rem] leading-[1.85] text-light-brown max-md:text-[0.78rem] max-md:leading-[1.7]">
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

            <section class="pt-12 max-md:pt-10" id="the-arti-way" aria-labelledby="arti-way-title">
                <div class="border-t border-black/15 pt-4">
                    <h4 class="mb-10 md:mb-14 text-[12px] uppercase tracking-[0.5em] text-light-brown">The Arti Way</h4>
                    <h3 class="mb-5 text-sm leading-[1.2] font-medium uppercase tracking-[0.2em] text-light-brown max-md:text-[1.22rem]"
                        id="arti-way-title">
                        PRACTICED WITHIN, REFLECTED BEYOND
                    </h3>
                    <p class="m-0 max-w-[428px] text-[9px] leading-[1.8] text-light-brown">
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
                            aria-expanded="true">
                            <span
                                class="arti-way-number md:w-20 shrink-0 text-[12px] tracking-[0.4em] text-black/70">01</span>
                            <span
                                class="arti-way-label w-44 shrink-0 text-[12px] font-semibold uppercase tracking-[0.42em] text-[#2d2d2d] max-md:w-auto">Artisan</span>
                            <span class="arti-way-title text-[12px] text-black/72">Design with Depth &amp;
                                Character</span>
                        </button>
                        <div class="arti-way-panel px-0 ">
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

            <section class="pt-20 max-md:pt-14" id="expertise" aria-labelledby="expertise-title">
                <div class="border-t border-black/15 pt-6">
                    <p class="mb-10 text-[12px] uppercase tracking-[0.5em] text-black/66">Expertise</p>
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
                    <div class="space-y-24 max-md:space-y-16">
                        <?php
                        $expertise_index = 0;
                        while ($expertise_query->have_posts()):
                            $expertise_query->the_post();
                            $expertise_index++;

                            $expertise_description = function_exists('get_field') ? get_field('description') : '';
                            $expertise_items = function_exists('get_field') ? get_field('expertise_items') : [];
                            ?>
                            <article>
                                <h2 class="mb-6 text-[1.55rem] leading-[1.2] font-medium uppercase tracking-[0.2em] text-dark-brown max-md:text-[1.1rem]"
                                    id="<?php echo esc_attr($expertise_index === 1 ? 'expertise-title' : 'expertise-title-' . $expertise_index); ?>">
                                    <?php the_title(); ?>
                                </h2>

                                <?php if (!empty($expertise_description)): ?>
                                    <p class="m-0 mb-12 max-w-[820px] text-[0.78rem] leading-[1.8] text-light-brown">
                                        <?php echo esc_html($expertise_description); ?>
                                    </p>
                                <?php endif; ?>

                                <?php if (!empty($expertise_items) && is_array($expertise_items)): ?>
                                    <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
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
                                            <article>
                                                <div class="overflow-hidden bg-black/5">
                                                    <?php if (!empty($item_image_url)): ?>
                                                        <img src="<?php echo esc_url($item_image_url); ?>"
                                                            alt="<?php echo esc_attr($item_title); ?>"
                                                            class="block aspect-[16/10] w-full object-cover">
                                                    <?php else: ?>
                                                        <div class="aspect-[16/10] w-full bg-black/10"></div>
                                                    <?php endif; ?>
                                                </div>
                                                <?php if (!empty($item_title)): ?>
                                                    <h3 class="mt-4 text-[12px] font-semibold uppercase tracking-[0.42em] text-[#2d2d2d]">
                                                        <?php echo esc_html($item_title); ?>
                                                    </h3>
                                                <?php endif; ?>
                                            </article>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            </article>
                        <?php endwhile; ?>
                    </div>
                    <?php wp_reset_postdata(); ?>
                <?php endif; ?>
            </section>

            <section class="pt-20 max-md:pt-14" id="experiences" aria-labelledby="experiences-title">
                <div class="border-t border-black/15 pt-6">
                    <p class="mb-10 text-[12px] uppercase tracking-[0.5em] text-black/66">Experiences</p>
                </div>

                <?php
                $experiences_query = new WP_Query([
                    'post_type' => ['experience', 'experiences'],
                    'posts_per_page' => 6,
                    'orderby' => 'menu_order',
                    'order' => 'ASC',
                ]);
                ?>

                <div>
                    <h2 class="mb-6 text-[1.55rem] leading-[1.2] font-medium uppercase tracking-[0.2em] text-dark-brown max-md:text-[1.1rem]"
                        id="experiences-title">
                        Practice Through Places
                    </h2>

                    <?php if ($experiences_query->have_posts()): ?>
                        <ul class="m-0 list-none divide-y divide-black/12 p-0">
                            <?php while ($experiences_query->have_posts()):
                                $experiences_query->the_post(); ?>
                                <li class="py-4 text-[0.78rem] leading-[1.8] text-dark-brown"><?php the_title(); ?></li>
                            <?php endwhile; ?>
                        </ul>
                        <?php wp_reset_postdata(); ?>
                    <?php else: ?>
                        <ul class="m-0 list-none divide-y divide-black/12 p-0">
                            <li class="py-4 text-[0.78rem] leading-[1.8] text-dark-brown">
                                Example (no data): Community Design Residency - Jakarta
                            </li>
                        </ul>
                    <?php endif; ?>
                </div>
            </section>

            <section class="pt-20 max-md:pt-14" id="awards" aria-labelledby="awards-title">
                <div class="border-t border-black/15 pt-6">
                    <p class="mb-10 text-[12px] uppercase tracking-[0.5em] text-black/66">Awards</p>

                    <p class="m-0 mb-16 max-w-[860px] text-[0.78rem] leading-[1.8] text-light-brown max-md:mb-12">
                        Arti Design Studio is a multi-disciplinary and award-winning practice that places
                        sustainability,
                        community, and craftsmanship at the heart of every project.
                    </p>
                </div>

                <?php
                $awards_query = new WP_Query([
                    'post_type' => 'awards',
                    'posts_per_page' => -1,
                    'orderby' => 'meta_value_num',
                    'meta_key' => 'year',
                    'order' => 'DESC',
                ]);
                ?>

                <div>
                    <div
                        class="grid grid-cols-[6fr_1fr] md:grid-cols-[1fr_260px] gap-4 border-b border-black/12 py-4 text-[9px] tracking-[0.08em] text-light-brown">
                        <p class="m-0">List</p>
                        <p class="m-0 hidden md:block">Year</p>
                    </div>

                    <?php if ($awards_query->have_posts()): ?>
                        <?php while ($awards_query->have_posts()):
                            $awards_query->the_post();
                            $award_year = function_exists('get_field') ? get_field('year') : '';
                            if (empty($award_year)) {
                                $award_year = get_the_date('Y');
                            }
                            ?>
                            <div
                                class="grid grid-cols-[6fr_1fr] md:grid-cols-[1fr_260px] gap-4 border-b border-black/12 py-5 text-[9px] leading-[1.7] text-dark-brown">
                                <p class="m-0"><?php the_title(); ?></p>
                                <p class="m-0 "><?php echo esc_html((string) $award_year); ?></p>
                            </div>
                        <?php endwhile; ?>
                        <?php wp_reset_postdata(); ?>
                    <?php else: ?>
                        <div
                            class="grid grid-cols-[6fr_1fr] md:grid-cols-[1fr_260px] gap-4 border-b border-black/12 py-5 text-[9px] leading-[1.7] text-dark-brown">
                            <p class="m-0">Example 1 (no data): National Architecture Merit Award - Best Installation</p>
                            <p class="m-0 ">2022</p>
                        </div>
                        <div
                            class="grid grid-cols-[6fr_1fr] md:grid-cols-[1fr_260px] gap-4 border-b border-black/12 py-5 text-[9px] leading-[1.7] text-dark-brown">
                            <p class="m-0">Example 2 (no data): Regional Design Prize - Community Space Category</p>
                            <p class="m-0 ">2019</p>
                        </div>
                    <?php endif; ?>
                </div>
            </section>
        </div>
    </div>
</section>

<?php
get_footer();
?>