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
</style>

<?php while (have_posts()):
    the_post(); ?>
    <section class="bg-beige-1 px-4 pb-20 pt-6 md:px-9 md:pb-28 md:pt-10">
        <div class="flex w-full gap-10 2xl:gap-24">
            <div class="w-1/2 2xl:w-[40%]">
                <h1 class="m-0 uppercase font-medium tracking-[0.31em] text-dark-brown">
                    Connect With Us
                </h1>

                <p class="mb-0 mt-9 max-w-[430px] text-[12px] leading-[1.8] text-dark-brown">
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

                $contact_form_shortcodes = [
                    'press' => '[contact-form-7 id="064323f" title="Press"]',
                    'collaboration' => '',
                    'enquiries' => '',
                    'career' => '',
                ];
                ?>

                <div class="contact-tabs mt-14" data-contact-tabs>
                    <div class="grid grid-cols-2 gap-x-2 gap-y-4 md:grid-cols-4">
                        <?php
                        $tab_index = 0;
                        foreach ($contact_tabs as $tab_key => $tab_label):
                            $tab_index++;
                            $is_active = $tab_index === 1;
                            ?>
                            <button type="button"
                                class="contact-tab-trigger border-0 text-[10px] bg-transparent pb-[9px] text-left uppercase font-medium tracking-[0.28em] transition-colors duration-200 <?php echo $is_active ? 'border-b-2 border-zinc-500 text-zinc-700' : 'border-b border-zinc-400/45 text-zinc-700/50'; ?>"
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
                    [&_label]:block [&_label]:text-[0.74rem] [&_label]:uppercase [&_label]:tracking-[0.34em] [&_label]:text-zinc-500
                    [&_input:not([type=submit])]:mt-2 [&_input:not([type=submit])]:block [&_input:not([type=submit])]:w-full [&_input:not([type=submit])]:border-0 [&_input:not([type=submit])]:border-b [&_input:not([type=submit])]:border-zinc-400/65 [&_input:not([type=submit])]:bg-transparent [&_input:not([type=submit])]:px-0 [&_input:not([type=submit])]:pb-4 [&_input:not([type=submit])]:pt-2 [&_input:not([type=submit])]:text-[0.95rem] [&_input:not([type=submit])]:text-zinc-700 [&_input:not([type=submit])]:outline-none
                    [&_textarea]:mt-2 [&_textarea]:block [&_textarea]:h-40 [&_textarea]:w-full [&_textarea]:resize-none [&_textarea]:border-0 [&_textarea]:border-b [&_textarea]:border-zinc-400/65 [&_textarea]:bg-transparent [&_textarea]:px-0 [&_textarea]:pb-4 [&_textarea]:pt-2 [&_textarea]:text-[0.95rem] [&_textarea]:text-zinc-700 [&_textarea]:outline-none
                    [&_.wpcf7-not-valid-tip]:mt-2 [&_.wpcf7-not-valid-tip]:text-[0.72rem]
                    [&_.wpcf7-response-output]:!mx-0 [&_.wpcf7-response-output]:!mt-6 [&_.wpcf7-response-output]:rounded-none [&_.wpcf7-response-output]:border-zinc-400/70 [&_.wpcf7-response-output]:px-3 [&_.wpcf7-response-output]:py-2 [&_.wpcf7-response-output]:text-[0.75rem]
                    [&_input[type=submit]]:ml-auto [&_input[type=submit]]:mt-10 [&_input[type=submit]]:inline-flex [&_input[type=submit]]:cursor-pointer [&_input[type=submit]]:border-0 [&_input[type=submit]]:bg-transparent [&_input[type=submit]]:px-0 [&_input[type=submit]]:text-[0.86rem] [&_input[type=submit]]:uppercase [&_input[type=submit]]:tracking-[0.34em] [&_input[type=submit]]:text-zinc-700">
                    <?php foreach ($contact_tabs as $tab_key => $tab_label): ?>
                        <?php
                        $tab_shortcode = $contact_form_shortcodes[$tab_key] ?? '';
                        ?>
                        <div class="contact-tab-panel <?php echo $tab_key === 'press' ? '' : 'hidden'; ?>"
                            data-tab-panel="<?php echo esc_attr($tab_key); ?>">
                            <?php
                            if ($tab_shortcode !== '') {
                                echo do_shortcode($tab_shortcode);
                            } elseif ($tab_key === 'press') {
                                the_content();
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

            <div class="w-1/2 2xl:w-[60%]">
                <div>
                    <?php if (has_post_thumbnail()): ?>
                        <?php the_post_thumbnail('full', ['class' => 'block w-full object-cover rounded-br-[250px] h-[80vh]']); ?>
                    <?php else: ?>
                        <img src="<?php echo esc_url(get_theme_file_uri('/images/contact.png')); ?>" alt="Contact"
                            class="block h-[80vh] w-full object-cover rounded-br-[250px]">
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </section>
<?php endwhile; ?>

<?php
get_footer();
?>
