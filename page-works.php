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
?>

<style>
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
        font-size: 9px;
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

    @media (max-width: 768px) {
        .works-filter-btn {
            font-size: 9px;
        }
    }
</style>

<section class="bg-beige-1 pb-16 pt-8 md:pt-10 min-h-[80vh]">
    <div class="px-4 md:px-8">
        <div class="mb-8 flex items-start justify-between gap-6 md:py-10">
            <div class="w-full">
                <button type="button" id="works-filter-toggle"
                    class="inline-flex items-center gap-3 border-0 bg-transparent p-0 text-[0.72rem] uppercase tracking-[0.42em] text-[#5a5a5a]">
                    <span id="works-filter-count"
                        class="inline-flex h-7 min-w-7 items-center justify-center rounded-full bg-[#2e2e2e] px-2 text-[0.76rem] font-medium tracking-normal text-white">0</span>
                    <span id="works-filter-toggle-label">Filter +</span>
                </button>

                <div id="works-filter-panel" class="md:mt-10 is-collapsed">
                    <ul class="m-0 grid list-none gap-y-6 gap-x-10 p-0 md:grid-cols-3 max-w-[500px]">
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
                <div class="flex items-center gap-3 pb-2">
                    <input type="search" id="works-search" placeholder="Search"
                        class="w-full border-0 bg-transparent p-0 text-right text-[12px] uppercase tracking-[0.42em] text-dark-brown border-b border-beige-2 pb-4 placeholder:text-[#7a7a7a] focus:outline-none">
                    <img src="<?php echo esc_url(get_template_directory_uri() . '/images/search.png'); ?>"
                        alt="Search Icon" class="h-4 w-4 object-contain mb-4">
                </div>
            </div>
        </div>

        <div class="flex">
            <p class="hidden md:block mb-8 text-[12px] uppercase tracking-[0.31em]
            text-dark-brown w-[22%] font-medium">
                Works</p>

            <div id="works-cards" class="space-y-14 w-full">
                <?php echo arti_render_work_cards_html($initial_works_query, $work_taxonomy ?: 'category'); ?>
            </div>
        </div>
    </div>
</section>

<script>
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
