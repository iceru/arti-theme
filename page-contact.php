<?php
/**
 * Template Name: Contact
 *
 * @package TailPress
 */

get_header();
?>

<style>
    .contact-tab-trigger[aria-selected="true"] {
        border-bottom-width: 2px;
    }

    .contact-tab-trigger[aria-selected="false"] {
        border-bottom-width: 1px;
    }

    .contact-form-shell input::placeholder,
    .contact-form-shell textarea::placeholder {
        color: var(--color-light-brown);
        font-size: 10px;
        letter-spacing: 0.28em;
        opacity: 1;
        text-transform: uppercase;
    }

    .contact-form-shell select {
        background-image: url("data:image/svg+xml,%3Csvg width='14' height='8' viewBox='0 0 14 8' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1 1L7 7L13 1' stroke='%23686868' stroke-width='1.2' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E");
        background-position: right 0.125rem center;
        background-repeat: no-repeat;
        background-size: 14px 8px;
        padding-right: 1.75rem !important;
    }

    .contact-form-shell select.is-placeholder {
        color: var(--color-light-brown);
        font-size: 10px;
        letter-spacing: 0.28em;
        text-transform: uppercase;
    }

    .contact-form-shell select option {
        color: var(--color-dark-brown);
        font-size: 0.95rem;
        letter-spacing: normal;
        text-transform: none;
    }

    .contact-form-shell select option[value=""] {
        color: var(--color-light-brown);
    }

    .contact-form-shell input[type="submit"] {
        background-image: url("<?php echo esc_url(get_theme_file_uri('/images/arrow-right.png')); ?>") !important;
        background-position: right center !important;
        background-repeat: no-repeat !important;
        background-size: 20px auto !important;
        min-width: 76px;
        padding-right: 24px !important;
        text-align: left;
    }
</style>

<?php while (have_posts()):
    the_post(); ?>
    <section class="bg-beige-1 px-4 pb-20 pt-6 md:px-9 md:pb-28 md:pt-10">
        <div class="flex w-full flex-wrap md:flex-nowrap gap-12 2xl:gap-24">
            <div class="w-full lg:w-1/2 2xl:w-[40%] order-2 md:order-1">
                <h1 class="m-0 uppercase font-medium tracking-[0.31em] text-dark-brown">
                    Connect With Us
                </h1>

                <p class="mb-0 mt-8 md:mt-9 max-w-[430px] text-[12px] leading-[1.8] text-dark-brown">
                    Let&apos;s begin with a conversation. Tell us about your project, and we&apos;ll explore how to
                    translate your vision into a considered, well-executed outcome.
                </p>

                <?php
                $contact_tabs = [
                    'press' => 'Press',
                    'collaboration' => 'Collaboration',
                    'enquiries' => 'Enquiries',
                    'career' => 'Career',
                ];

                $get_contact_form_id = static function (string $title): int {
                    static $form_ids_by_title = null;

                    if ($form_ids_by_title === null) {
                        $form_ids_by_title = [];

                        if (class_exists('WPCF7_ContactForm') && method_exists('WPCF7_ContactForm', 'find')) {
                            $contact_forms = WPCF7_ContactForm::find();

                            foreach ($contact_forms as $contact_form) {
                                if (is_object($contact_form) && method_exists($contact_form, 'title') && method_exists($contact_form, 'id')) {
                                    $form_ids_by_title[$contact_form->title()] = (int) $contact_form->id();
                                }
                            }
                        }

                        $contact_forms = get_posts([
                            'post_type' => 'wpcf7_contact_form',
                            'post_status' => 'any',
                            'posts_per_page' => -1,
                            'no_found_rows' => true,
                        ]);

                        foreach ($contact_forms as $contact_form) {
                            if ($contact_form instanceof WP_Post) {
                                $form_ids_by_title[get_the_title($contact_form)] = (int) $contact_form->ID;
                            }
                        }
                    }

                    return !empty($form_ids_by_title[$title]) ? (int) $form_ids_by_title[$title] : 0;
                };

                $get_contact_form_shortcode = static function (string $title, int $form_id = 0): string {
                    if ($form_id <= 0) {
                        return '';
                    }

                    return sprintf(
                        '[contact-form-7 id="%d" title="%s"]',
                        $form_id,
                        esc_attr($title)
                    );
                };

                $normalize_contact_form_shortcode = static function (string $shortcode, string $fallback_title) use ($get_contact_form_id, $get_contact_form_shortcode): string {
                    $shortcode = trim($shortcode);

                    if ($shortcode === '' || strpos($shortcode, '[contact-form-7') === false) {
                        return $shortcode;
                    }

                    $title = $fallback_title;
                    if (preg_match('/\btitle=(["\'])(.*?)\1/', $shortcode, $title_match)) {
                        $title = html_entity_decode($title_match[2], ENT_QUOTES, get_bloginfo('charset'));
                    }

                    $form_id = 0;
                    if (preg_match('/\bid=(["\']?)(\d+)\1/', $shortcode, $id_match)) {
                        $form_id = (int) $id_match[2];
                    }

                    if ($form_id <= 0 || get_post_type($form_id) !== 'wpcf7_contact_form') {
                        $form_id = $get_contact_form_id($title);
                    }

                    return $get_contact_form_shortcode($title, $form_id);
                };

                $populate_preferred_role_select = static function (string $html): string {
                    if (!function_exists('arti_get_preferred_role_options')) {
                        return $html;
                    }

                    $role_options = arti_get_preferred_role_options();
                    if (empty($role_options)) {
                        return $html;
                    }

                    $option_html = '<option value="">Preferred Role</option>';
                    foreach ($role_options as $role_option) {
                        $option_html .= sprintf(
                            '<option value="%1$s">%2$s</option>',
                            esc_attr($role_option),
                            esc_html($role_option)
                        );
                    }

                    return (string) preg_replace(
                        '/(<select\b[^>]*\bname=(["\']?)preferred[-_]?roles?(?:\[\])?\2[^>]*>).*?(<\/select>)/is',
                        '$1' . $option_html . '$3',
                        $html
                    );
                };

                $contact_form_shortcodes = [
                    'press' => $get_contact_form_shortcode('Press', $get_contact_form_id('Press')),
                    'collaboration' => $get_contact_form_shortcode('Collaboration', $get_contact_form_id('Collaboration')),
                    'enquiries' => $get_contact_form_shortcode('Enquiries', $get_contact_form_id('Enquiries')),
                    'career' => $get_contact_form_shortcode('Career', $get_contact_form_id('Career')),
                ];

                if (function_exists('get_field')) {
                    $acf_contact_shortcodes = get_field('contact_form_shortcodes');

                    foreach ($contact_tabs as $tab_key => $tab_label) {
                        $acf_shortcode = '';

                        if (is_array($acf_contact_shortcodes) && !empty($acf_contact_shortcodes[$tab_key])) {
                            $acf_shortcode = $acf_contact_shortcodes[$tab_key];
                        }

                        if ($acf_shortcode === '') {
                            $acf_shortcode = get_field("contact_{$tab_key}_shortcode");
                        }

                        if ($acf_shortcode === '') {
                            $acf_shortcode = get_field("{$tab_key}_shortcode");
                        }

                        $acf_shortcode = trim((string) $acf_shortcode);

                        if ($acf_shortcode !== '') {
                            $contact_form_shortcodes[$tab_key] = $normalize_contact_form_shortcode($acf_shortcode, $tab_label);
                        }
                    }
                }
                ?>

                <div class="contact-tabs mt-14" data-contact-tabs>
                    <div class="grid gap-x-2 gap-y-4 grid-cols-4">
                        <?php
                        $tab_index = 0;
                        foreach ($contact_tabs as $tab_key => $tab_label):
                            $tab_index++;
                            $is_active = $tab_index === 1;
                            ?>
                            <button type="button"
                                class="contact-tab-trigger border-0 text-[7px] md:text-[10px] bg-transparent pb-[9px] text-left uppercase font-medium tracking-[0.28em] transition-colors duration-200 <?php echo $is_active ? 'border-b-2 border-zinc-500 text-zinc-700' : 'border-b border-zinc-400/45 text-zinc-700/50'; ?>"
                                data-tab-trigger="<?php echo esc_attr($tab_key); ?>"
                                aria-selected="<?php echo $is_active ? 'true' : 'false'; ?>">
                                <?php echo esc_html($tab_label); ?>
                            </button>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div
                    class="contact-form-shell mt-10 max-w-[760px]
                    [&_.wpcf7-form]:space-y-4
                    [&_.wpcf7-form-control-wrap]:block
                    [&_p]:m-0
                    placeholder:text-[10px] placeholder:tracking-[0.28em]
                    [&_label]:block [&_label]:text-[0.74rem] [&_label]:uppercase [&_label]:tracking-[0.34em] [&_label]:text-zinc-500
                    [&_input:not([type=submit])]:mt-2 [&_input:not([type=submit])]:block [&_input:not([type=submit])]:w-full [&_input:not([type=submit])]:border-0 [&_input:not([type=submit])]:border-b [&_input:not([type=submit])]:border-zinc-400/65 [&_input:not([type=submit])]:bg-transparent [&_input:not([type=submit])]:px-0 [&_input:not([type=submit])]:pb-4 [&_input:not([type=submit])]:pt-2 [&_input:not([type=submit])]:text-[0.95rem] [&_input:not([type=submit])]:text-zinc-700 [&_input:not([type=submit])]:outline-none [&_input:not([type=submit])]:placeholder:text-[10px] [&_input:not([type=submit])]:placeholder:tracking-[0.28em]
                    [&_select]:mt-2 [&_select]:block [&_select]:w-full [&_select]:appearance-none [&_select]:border-0 [&_select]:border-b [&_select]:border-zinc-400/65 [&_select]:bg-transparent [&_select]:px-0 [&_select]:pb-4 [&_select]:pt-2 [&_select]:text-[0.95rem] [&_select]:text-zinc-700 [&_select]:outline-none
                    [&_textarea]:mt-2 [&_textarea]:block [&_textarea]:h-40 [&_textarea]:w-full [&_textarea]:resize-none [&_textarea]:border-0 [&_textarea]:border-b [&_textarea]:border-zinc-400/65 [&_textarea]:bg-transparent [&_textarea]:px-0 [&_textarea]:pb-4 [&_textarea]:pt-2 [&_textarea]:text-[0.95rem] [&_textarea]:text-zinc-700 [&_textarea]:outline-none [&_textarea]:placeholder:text-[10px] [&_textarea]:placeholder:tracking-[0.28em]
                    [&_.wpcf7-not-valid-tip]:mt-2 [&_.wpcf7-not-valid-tip]:text-[0.72rem]
                    [&_.wpcf7-response-output]:!mx-0 [&_.wpcf7-response-output]:!mt-6 [&_.wpcf7-response-output]:rounded-none [&_.wpcf7-response-output]:border-zinc-400/70 [&_.wpcf7-response-output]:px-3 [&_.wpcf7-response-output]:py-2 [&_.wpcf7-response-output]:text-[0.75rem]
                    [&_input[type=submit]]:ml-auto [&_input[type=submit]]:mt-10 [&_input[type=submit]]:block [&_input[type=submit]]:cursor-pointer [&_input[type=submit]]:border-0 [&_input[type=submit]]:bg-transparent [&_input[type=submit]]:py-0 [&_input[type=submit]]:pl-0 [&_input[type=submit]]:text-[12px] [&_input[type=submit]]:font-medium [&_input[type=submit]]:uppercase [&_input[type=submit]]:tracking-[0.34em] [&_input[type=submit]]:text-light-brown">
                    <?php foreach ($contact_tabs as $tab_key => $tab_label): ?>
                        <?php
                        $tab_shortcode = $contact_form_shortcodes[$tab_key] ?? '';
                        ?>
                        <div class="contact-tab-panel <?php echo $tab_key === 'press' ? '' : 'hidden'; ?>"
                            data-tab-panel="<?php echo esc_attr($tab_key); ?>">
                            <?php
                            if ($tab_shortcode !== '') {
                                echo $populate_preferred_role_select(do_shortcode($tab_shortcode));
                            } else {
                                echo '<p class="text-[0.85rem] text-light-brown">No form is set yet for ' . esc_html($tab_label) . '.</p>';
                            }
                            ?>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="mt-20 grid max-w-[520px] grid-cols-[120px_1fr] gap-y-7 text-[0.78rem] md:mt-24 text-[12px]">
                    <p class="m-0 uppercase tracking-[0.28em] text-light-brown">Email</p>
                    <p class="m-0 text-dark-brown tracking-wide">info@arti-design.com</p>
                    <p class="m-0 uppercase tracking-[0.28em] text-light-brown">Whatsapp</p>
                    <p class="m-0 text-dark-brown tracking-wide">+62 878 8742 6318</p>
                    <p class="m-0 uppercase tracking-[0.28em] text-light-brown">Instagram</p>
                    <p class="m-0 text-dark-brown tracking-wide">@arti.designstudio</p>
                </div>
            </div>

            <div class="w-full lg:w-1/2 2xl:w-[60%] order-1 md:order-2">
                <div>
                    <?php if (has_post_thumbnail()): ?>
                        <?php the_post_thumbnail('full', ['class' => 'block w-full object-cover rounded-br-[250px] h-[80vh]']); ?>
                    <?php else: ?>
                        <img src="<?php echo esc_url(get_theme_file_uri('/images/contact.png')); ?>" alt="Contact"
                            class="block h-full md:h-[80vh] w-full object-cover rounded-br-[120px] md:rounded-br-[250px]">
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </section>
<?php endwhile; ?>

<script>
    (function () {
        function updateSelectPlaceholder(select) {
            var selectedOption = select.options[select.selectedIndex];
            var isPlaceholder = select.value === '' || Boolean(selectedOption && selectedOption.disabled && selectedOption.value === '');

            select.classList.toggle('is-placeholder', isPlaceholder);
        }

        function initContactSelects(scope) {
            var container = scope || document;
            var selects = container.querySelectorAll('.contact-form-shell select');

            selects.forEach(function (select) {
                updateSelectPlaceholder(select);

                if (select.dataset.placeholderReady === 'true') {
                    return;
                }

                select.dataset.placeholderReady = 'true';
                select.addEventListener('change', function (event) {
                    updateSelectPlaceholder(select);

                    if (/^preferred[-_]?roles?(?:\[\])?$/i.test(select.name)) {
                        event.stopPropagation();
                    }
                });
            });
        }

        function updatePanelControls() {
            var panels = document.querySelectorAll('[data-tab-panel]');

            panels.forEach(function (panel) {
                var isActive = !panel.classList.contains('hidden');
                var controls = panel.querySelectorAll('input, select, textarea, button');

                controls.forEach(function (control) {
                    if (
                        control.type === 'submit' ||
                        control.type === 'hidden' ||
                        control.name.indexOf('_wpcf7') === 0
                    ) {
                        return;
                    }

                    control.disabled = !isActive;
                });
            });
        }

        function initContactTabsValidation() {
            var triggers = document.querySelectorAll('[data-tab-trigger]');

            updatePanelControls();

            triggers.forEach(function (trigger) {
                if (trigger.dataset.validationReady === 'true') {
                    return;
                }

                trigger.dataset.validationReady = 'true';
                trigger.addEventListener('click', function () {
                    window.requestAnimationFrame(updatePanelControls);
                });
            });
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', function () {
                initContactSelects(document);
                initContactTabsValidation();
            });
        } else {
            initContactSelects(document);
            initContactTabsValidation();
        }

        window.addEventListener('load', updatePanelControls);

        document.addEventListener('wpcf7reset', function (event) {
            window.setTimeout(function () {
                initContactSelects(event.target);
                updatePanelControls();
            }, 0);
        });
    })();
</script>

<?php
get_footer();
?>