<?php
/**
 * Template Name: News
 *
 * @package TailPress
 */

get_header();

$news_categories = get_categories([
    'taxonomy' => 'category',
    'hide_empty' => true,
]);

$initial_news_query = new WP_Query([
    'post_type' => 'post',
    'post_status' => 'publish',
    'posts_per_page' => 12,
    'orderby' => 'date',
    'order' => 'DESC',
]);
?>

<style>
    .news-category-btn {
        opacity: 0.5;
        transition: opacity 220ms ease;
    }

    .news-category-btn:hover,
    .news-category-btn.is-active {
        opacity: 1;
    }
</style>

<section class="bg-beige-1 pb-16 pt-8 md:pt-10 min-h-[80vh]">
    <div class="grid grid-cols-1 gap-8 px-6 md:grid-cols-[220px_1fr] md:gap-10 md:px-8">
        <aside class="md:sticky md:top-24 md:self-start">
            <p class="mb-8 text-[0.74rem] uppercase tracking-[0.48em] text-[#2d2d2d]">News</p>

            <button type="button" id="news-filter-toggle"
                class="inline-flex items-center gap-3 border-0 bg-transparent p-0 text-[0.72rem] uppercase tracking-[0.42em] text-[#5a5a5a]">
                <span id="news-filter-count"
                    class="inline-flex h-7 min-w-7 items-center justify-center rounded-full bg-[#2e2e2e] px-2 text-[0.76rem] font-medium tracking-normal text-white">0</span>
                <span id="news-filter-toggle-label">Filter +</span>
            </button>

            <div id="news-filter-panel" class="mt-6 hidden">
                <ul class="m-0 list-none space-y-4 p-0">
                    <li>
                        <button type="button"
                            class="news-category-btn is-active text-left text-[2rem] leading-[1.12] text-[#171717] max-md:text-[1.8rem]"
                            data-category-id="">
                            All
                        </button>
                    </li>
                    <?php foreach ($news_categories as $category): ?>
                        <li>
                            <button type="button"
                                class="news-category-btn text-left text-[2rem] leading-[1.12] text-[#171717] max-md:text-[1.8rem]"
                                data-category-id="<?php echo esc_attr((string) $category->term_id); ?>">
                                <?php echo esc_html($category->name); ?>
                            </button>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </aside>

        <div>
            <div id="news-track" class="overflow-x-auto pb-4 [scrollbar-width:thin]">
                <div id="news-cards" class="flex min-w-max gap-6 md:gap-8">
                    <?php echo arti_render_news_cards_html($initial_news_query); ?>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    jQuery(function ($) {
        const $toggle = $('#news-filter-toggle');
        const $panel = $('#news-filter-panel');
        const $toggleLabel = $('#news-filter-toggle-label');
        const $counter = $('#news-filter-count');
        const $cards = $('#news-cards');
        const $track = $('#news-track');
        const selected = new Set();

        function updateCounter() {
            const count = selected.size;
            $counter.text(count);
        }

        function updateAllState() {
            if (selected.size === 0) {
                $('.news-category-btn[data-category-id=""]').addClass('is-active');
            } else {
                $('.news-category-btn[data-category-id=""]').removeClass('is-active');
            }
        }

        function fetchNews() {
            $.ajax({
                url: '<?php echo esc_url(admin_url('admin-ajax.php')); ?>',
                method: 'POST',
                dataType: 'json',
                data: {
                    action: 'arti_filter_news_posts',
                    nonce: '<?php echo esc_js(wp_create_nonce('arti_filter_news_nonce')); ?>',
                    categories: Array.from(selected),
                },
                beforeSend: function () {
                    $cards.css('opacity', '0.35');
                },
                success: function (response) {
                    if (!response || !response.success || !response.data) {
                        return;
                    }
                    $cards.html(response.data.html);
                },
                complete: function () {
                    $cards.css('opacity', '1');
                }
            });
        }

        $toggle.on('click', function () {
            $panel.toggleClass('hidden');
            const isOpen = !$panel.hasClass('hidden');
            $toggleLabel.text(isOpen ? 'Filter -' : 'Filter +');
        });

        // Use vertical wheel movement to scroll news items horizontally.
        $track.on('wheel', function (event) {
            const nativeEvent = event.originalEvent;
            const deltaY = nativeEvent.deltaY || 0;
            const deltaX = nativeEvent.deltaX || 0;

            if (Math.abs(deltaY) > Math.abs(deltaX)) {
                event.preventDefault();
                this.scrollLeft += deltaY;
            }
        });

        $(document).on('click', '.news-category-btn', function () {
            const id = String($(this).data('category-id') || '');

            if (id === '') {
                selected.clear();
                $('.news-category-btn').removeClass('is-active');
            } else {
                if (selected.has(id)) {
                    selected.delete(id);
                    $(this).removeClass('is-active');
                } else {
                    selected.add(id);
                    $(this).addClass('is-active');
                }
            }

            updateAllState();
            updateCounter();
            fetchNews();
        });

        updateAllState();
        updateCounter();
    });
</script>

<?php
get_footer();
