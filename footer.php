<?php
/**
 * Theme footer template.
 *
 * @package TailPress
 */
?>
</main>

<?php do_action('tailpress_content_end'); ?>
</div>

<?php do_action('tailpress_content_after'); ?>

<footer id="colophon" class=" text-zinc-800 bg-beige-1" role="contentinfo">
    <div class="px-6 md:px-12 pt-10 md:pt-14 pb-12 rounded-tr-[32px] bg-beige-2">
        <?php do_action('tailpress_footer'); ?>
        <div class="grid grid-cols-1 md:grid-cols-12 gap-8 md:gap-6">
            <div class="md:col-span-2">
                <p class="text-sm tracking-[0.4em] uppercase leading-tight font-medium">Get In
                    Touch<br>With Us</p>
            </div>
            <div class="md:col-span-2 md:col-start-3">
                <p class="text-sm mb-6">Instagram</p>
                <p class="text-zinc-600">@arti.designstudio</p>
            </div>
            <div class="md:col-span-2 md:col-start-5">
                <p class="text-sm mb-6">Email</p>
                <p class="text-zinc-600">info@arti-design.com</p>
            </div>
            <div class="md:col-span-3 md:col-start-7">
                <p class="text-sm mb-6">Address</p>
                <p class="text-zinc-600">Jl. Horizon Broadway, Kec. Cisauk<br>Tangerang, Banten - 15345</p>
            </div>
            <div class="md:col-span-1 md:col-start-12 flex md:justify-end items-start">
                <span class="text-6xl leading-none font-serif">a</span>
            </div>
        </div>

        <div class="mt-14 md:mt-24 text-sm text-zinc-600">
            &copy; Copyright Arti Design Studio, <?php echo esc_html(date_i18n('Y')); ?>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>

</html>
