<?php
/**
 * Theme header template.
 *
 * @package TailPress
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
    <?php wp_head(); ?>
</head>

<body <?php body_class('bg-white text-zinc-900 antialiased'); ?>>
    <?php do_action('tailpress_site_before'); ?>

    <div id="site-loader"
        class="fixed inset-0 z-[100] flex items-center justify-center bg-beige-2 opacity-100 transition-opacity duration-700">
        <div class="relative flex h-28 w-28 items-center justify-center">
            <video class="h-20 w-20 object-contain opacity-90" autoplay muted loop playsinline>
                <source src="<?php echo esc_url(get_theme_file_uri('/images/loader.mp4')); ?>" type="video/mp4">
            </video>
            <span class="absolute text-5xl leading-none text-zinc-800 animate-pulse" aria-hidden="true">a</span>
        </div>
    </div>

    <div id="page" class="min-h-screen flex flex-col opacity-0 transition-opacity duration-700">
        <?php do_action('tailpress_header'); ?>

        <header id="site-header" class="relative z-[60] bg-beige-1 py-5 px-8 transition-colors duration-300">
            <div class="flex items-center justify-between">
                <a href="<?php echo esc_url(home_url('/')); ?>"
                    class="!no-underline text-zinc-900 text-4xl md:text-5xl font-light leading-none tracking-tight lowercase">
                    <img src="<?php echo esc_url(get_theme_file_uri('/images/logo.png')); ?>" alt="">
                </a>
                <button id="site-menu-toggle" type="button" aria-label="Open menu" aria-expanded="false"
                    aria-controls="site-menu-overlay"
                    class="relative inline-flex h-10 w-10 items-center justify-center text-zinc-500 transition hover:text-zinc-700">
                    <span
                        class="site-menu-line site-menu-line-top absolute block h-px w-8 -translate-y-1 bg-current transition-transform duration-300"></span>
                    <span
                        class="site-menu-line site-menu-line-bottom absolute block h-px w-8 translate-y-1 bg-current transition-transform duration-300"></span>
                </button>
            </div>
        </header>

        <div id="site-menu-overlay"
            class="pointer-events-none fixed inset-x-0 top-[88px] z-50 -translate-y-8 opacity-0 transition-all duration-500 ease-out max-md:top-[88px]">
            <div class="mx-0 bg-beige-2/95 px-6 md:px-12 pt-12 pb-8 shadow-xl backdrop-blur-[1px]">
                <div class="grid grid-cols-1 md:grid-cols-12 gap-8 md:gap-6">
                    <nav class="md:col-span-5 grid grid-cols-2 gap-y-8 text-sm uppercase tracking-[0.42em]">
                        <a href="<?php echo esc_url(home_url('/studio')); ?>"
                            class="!no-underline text-zinc-900 hover:opacity-70">Studio</a>
                        <a href="/news" class="!no-underline text-zinc-900 hover:opacity-70">News</a>
                        <a href="/works" class="!no-underline text-zinc-900 hover:opacity-70">Works</a>
                        <a href="/contact" class="!no-underline text-zinc-900 hover:opacity-70">Contact</a>
                    </nav>
                    <div class="md:col-span-7"></div>
                    <p class="md:col-span-3 text-zinc-600 text-sm">&copy; Copyright Arti Design Studio,
                        <?php echo esc_html(date_i18n('Y')); ?>
                    </p>
                    <p class="md:col-span-2 text-zinc-600 text-sm">Instagram</p>
                    <p class="md:col-span-4 text-zinc-600 text-sm">Jl. Horizon Broadway, Kec. Cisauk, Tangerang, Banten
                        &mdash; 15345</p>
                    <div class="md:col-span-3 flex md:justify-end"><span
                            class="text-5xl leading-none text-zinc-800 font-serif">a</span></div>
                </div>
            </div>
        </div>

        <div id="content" class="site-content grow">
            <?php do_action('tailpress_content_start'); ?>
            <main>
