<?php
/**
 * Template Name: Works
 *
 * @package TailPress
 */

get_header();

$work_taxonomy = arti_get_work_taxonomy();
$work_terms = [];
if (!empty($work_taxonomy)) {
    $work_terms = get_terms([
        'taxonomy' => $work_taxonomy,
        'hide_empty' => true,
    ]);
}

$initial_works_query = new WP_Query([
    'post_type' => 'work',
    'post_status' => 'publish',
    'posts_per_page' => 12,
    'orderby' => 'date',
    'order' => 'DESC',
]);
?>

<style>
    .works-filter-btn {
        display: inline-flex;
        align-items: center;
        gap: 12px;
        opacity: 0.9;
        transition: opacity 220ms ease, color 220ms ease;
    }

    .works-filter-btn:hover {
        opacity: 1;
    }

    .works-filter-btn .works-filter-marker {
        width: 14px;
        height: 14px;
        border-radius: 4px;
        border: 1px solid rgba(51, 51, 51, 0.35);
        background: transparent;
        transition: background-color 220ms ease, border-color 220ms ease;
    }

    .works-filter-btn.is-active .works-filter-marker {
        background: #333333;
        border-color: #333333;
    }
</style>

<section class="bg-beige-1 pb-16 pt-8 md:pt-10">
    <div class="px-4 md:px-8">
        <div class="mb-8 flex items-start justify-between gap-6 md:py-10">
            <div class="w-full">
                <div
                    class="inline-flex items-center gap-3 border-0 bg-transparent p-0 text-[0.72rem] uppercase tracking-[0.42em] text-[#5a5a5a]">
                    <span id="works-filter-count"
                        class="inline-flex h-7 min-w-7 items-center justify-center rounded-full bg-[#2e2e2e] px-2 text-[0.76rem] font-medium tracking-normal text-white">0</span>
                    <span id="works-filter-toggle-label">Filter -</span>
                </div>

                <div id="works-filter-panel" class="md:mt-10">
                    <ul class="m-0 grid list-none gap-y-6 gap-x-10 p-0 md:grid-cols-3">
                        <?php if (!empty($work_terms) && !is_wp_error($work_terms)): ?>
                            <?php foreach ($work_terms as $term): ?>
                                <li>
                                    <button type="button"
                                        class="works-filter-btn text-left text-[1.85rem] leading-[1.12] text-dark-brown max-md:text-[1.22rem]"
                                        data-term-id="<?php echo esc_attr((string) $term->term_id); ?>">
                                        <span class="works-filter-marker" aria-hidden="true"></span>
                                        <span><?php echo esc_html($term->name); ?></span>
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
                        class="w-full border-0 bg-transparent p-0 text-right text-[0.64rem] uppercase tracking-[0.42em] text-[#5a5a5a] placeholder:text-[#7a7a7a] focus:outline-none">
                    <img src="<?php echo esc_url(get_template_directory_uri() . '/images/search.png'); ?>"
                        alt="Search Icon" class="h-4 w-4 object-contain">
                </div>
            </div>
        </div>

        <div class="flex">
            <p class="hidden md:block mb-8 text-[0.74rem] uppercase tracking-[0.48em] text-[#2d2d2d] w-[22%]">Works</p>

            <div id="works-cards" class="space-y-14 w-full">
                <?php echo arti_render_work_cards_html($initial_works_query, $work_taxonomy ?: 'category'); ?>
            </div>
        </div>
    </div>
</section>

<script>
    jQuery(function ($) {
        const $panel = $('#works-filter-panel');
        const $counter = $('#works-filter-count');
        const $search = $('#works-search');
        const $cards = $('#works-cards');
        const selectedTerms = new Set();
        let searchTimer = null;

        function updateCounter() {
            $counter.text(selectedTerms.size);
        }

        function fetchWorks() {
            $.ajax({
                url: '<?php echo esc_url(admin_url('admin-ajax.php')); ?>',
                method: 'POST',
                dataType: 'json',
                data: {
                    action: 'arti_filter_work_posts',
                    nonce: '<?php echo esc_js(wp_create_nonce('arti_filter_work_nonce')); ?>',
                    terms: Array.from(selectedTerms),
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
                },
                complete: function () {
                    $cards.css('opacity', '1');
                }
            });
        }

        $(document).on('click', '.works-filter-btn', function () {
            const id = String($(this).data('term-id') || '');

            if (!id) {
                return;
            }

            if (selectedTerms.has(id)) {
                selectedTerms.delete(id);
                $(this).removeClass('is-active');
            } else {
                selectedTerms.add(id);
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

        updateCounter();
    });
</script>

<?php
get_footer();
