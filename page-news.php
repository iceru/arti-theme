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

    .news-category-btn:hover {
        color: #2f2f2f;
    }

    .news-category-btn .news-filter-marker {
        display: inline-block;
        width: 12px;
        height: 12px;
        border-radius: 5px 0 5px 0;
        border: 2px solid #9a9792;
        background: transparent;
        transition: background-color 220ms ease, border-color 220ms ease;
        flex-shrink: 0;
    }

    .news-category-btn.is-active .news-filter-marker {
        background: #2f2f2f;
        border-color: #2f2f2f;
    }

    @media (max-width: 768px) {
        .news-category-btn {
            font-size: 9px;
        }

        #news-cards > * {
            width: 100% !important;
            max-width: 100% !important;
        }
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
                <ul class="m-0 list-none space-y-2 p-0">
                    <li>
                        <button type="button" class="news-category-btn is-active text-left" data-category-id="">
                            <span class="news-filter-marker" aria-hidden="true"></span>
                            <span class="tracking-wider">All</span>
                        </button>
                    </li>
                    <?php foreach ($news_categories as $category): ?>
                        <li>
                            <button type="button" class="news-category-btn text-left"
                                data-category-id="<?php echo esc_attr((string) $category->term_id); ?>">
                                <span class="news-filter-marker" aria-hidden="true"></span>
                                <span class="tracking-wider"><?php echo esc_html($category->name); ?></span>
                            </button>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </aside>

        <div class="w-full min-w-0 overflow-hidden">
            <div id="news-track"
                class="w-full max-w-full overflow-visible pb-5 md:overflow-x-auto md:[scrollbar-color:#686868_#D4CFC7] md:[scrollbar-width:thin] md:[&::-webkit-scrollbar]:h-1.5 md:[&::-webkit-scrollbar-track]:rounded-full md:[&::-webkit-scrollbar-track]:bg-beige-1 md:[&::-webkit-scrollbar-thumb]:rounded-full md:[&::-webkit-scrollbar-thumb]:bg-beige-1 md:[&::-webkit-scrollbar-thumb]:transition-colors md:hover:[&::-webkit-scrollbar-thumb]:bg-zinc-500">
                <div id="news-cards" class="flex w-full flex-col gap-6 md:w-max md:flex-row md:gap-8">
                    <?php echo arti_render_news_cards_html($initial_news_query); ?>
                </div>
            </div>
        </div>

        <script>
            (function () {
                var newsTrack = document.getElementById('news-track');

                if (!newsTrack) {
                    return;
                }

                newsTrack.addEventListener('wheel', function (event) {
                    if (!window.matchMedia('(min-width: 768px)').matches) {
                        return;
                    }

                    if (Math.abs(event.deltaY) <= Math.abs(event.deltaX)) {
                        return;
                    }

                    var maxScrollLeft = newsTrack.scrollWidth - newsTrack.clientWidth;

                    if (maxScrollLeft <= 0) {
                        return;
                    }

                    event.preventDefault();
                    newsTrack.scrollLeft += event.deltaY;
                }, { passive: false });
            })();
        </script>
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
            if (!window.matchMedia('(min-width: 768px)').matches) {
                return;
            }

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
