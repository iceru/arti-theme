<?php
/**
 * Template Name: Homepage
 *
 * @package TailPress
 */

get_header();
?>

<section
    class="homepage-hero relative flex min-h-[72vh] items-center justify-center overflow-hidden bg-beige-1 px-6 py-16 md:min-h-[78vh]"
    style="--hero-bg:url('<?php echo esc_url(get_theme_file_uri('/images/bg.png')); ?>');">
    <canvas class="homepage-hero__canvas absolute inset-0 h-full w-full"></canvas>

    <nav
        class="relative z-10 flex items-center gap-10 text-zinc-800 text-[12px] bg-beige-1 py-8 px-8 tracking-[0.45em] uppercase font-medium md:gap-16">
        <a href="/studio" class="!no-underline hover:opacity-70 transition">Studio</a>
        <a href="/works" class="!no-underline hover:opacity-70 transition">Works</a>
    </nav>
</section>

<?php
get_footer();
?>