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

<body <?php body_class('bg-white text-zinc-900 antialiased font-sans'); ?>>
    <?php do_action('tailpress_site_before'); ?>
    <?php
    $loader_video_path = get_theme_file_path('/images/loader.mp4');
    $loader_video_uri = get_theme_file_uri('/images/loader.mp4');
    ?>

    <div id="site-loader"
        class="fixed inset-0 z-[100] flex items-center justify-center bg-beige-2 opacity-100 transition-opacity duration-700">
        <div class="relative flex h-28 w-28 items-center justify-center">
            <?php if (file_exists($loader_video_path)): ?>
                <video class="h-20 w-20 object-contain opacity-90" autoplay muted loop playsinline>
                    <source src="<?php echo esc_url($loader_video_uri); ?>" type="video/mp4">
                </video>
            <?php endif; ?>
            <span class="absolute text-5xl leading-none text-zinc-800 animate-pulse" aria-hidden="true">a</span>
        </div>
    </div>

    <div id="page" class="min-h-screen flex flex-col opacity-0 transition-opacity duration-700">
        <?php do_action('tailpress_header'); ?>

        <header id="site-header" class="relative z-40 bg-beige-1 py-5 px-4 md:px-9 transition-colors duration-300">
            <div class="flex items-center justify-between">
                <a href="<?php echo esc_url(home_url('/')); ?>"
                    class="!no-underline text-zinc-900 text-4xl md:text-5xl font-light leading-none tracking-tight lowercase">
                    <img src="<?php echo esc_url(get_theme_file_uri('/images/logo.png')); ?>" alt="">
                </a>
                <button id="site-menu-toggle" type="button" aria-label="Open menu" aria-expanded="false"
                    aria-controls="site-menu-overlay"
                    class="relative inline-flex h-10 w-10 items-center justify-center text-zinc-500 transition hover:text-zinc-700">
                    <span
                        class="site-menu-line site-menu-line-top absolute block h-px w-6 md:w-8 -translate-y-1 bg-current transition-transform duration-300"></span>
                    <span
                        class="site-menu-line site-menu-line-bottom absolute block h-px w-6 md:w-8 translate-y-1 bg-current transition-transform duration-300"></span>
                </button>
            </div>
        </header>

        <div id="site-menu-overlay"
            class="pointer-events-none fixed top-[78px] inset-0 z-50 -translate-y-8 opacity-0 transition-all duration-500 ease-out">
            <div
                class="mx-0 flex md:h-[16vh] min-h-[160px] md:max-h-[320px] flex-col justify-between bg-beige-2 px-4 pt-8 pb-6 md:px-9 md:pt-8 shadow-xl backdrop-blur-[1px]">
                <div class="grid grid-cols-1 md:grid-cols-12 gap-8 md:gap-6  relative">
                    <nav
                        class="md:col-span-6 md:col-start-4 flex flex-col md:-top-[80px] relative md:grid grid-cols-2 gap-y-8 gap-x-6 text-[12px] font-medium uppercase tracking-[0.42em]">
                        <a href="<?php echo esc_url(home_url('/studio')); ?>"
                            class="!no-underline text-zinc-900 hover:opacity-70">Studio</a>
                        <a href="/news" class="!no-underline text-zinc-900 hover:opacity-70">News</a>

                        <a href="/works" class="!no-underline text-zinc-900 hover:opacity-70">Works</a>
                        <a href="/contact" class="!no-underline text-zinc-900 hover:opacity-70">Contact</a>
                    </nav>
                </div>

                <div
                    class="hidden md:grid grid-cols-1 gap-4 text-light-brown text-sm md:grid-cols-12 md:gap-6 text-[9px]">
                    <p class="md:col-span-3">&copy; Copyright Arti Design Studio,
                        <?php echo esc_html(date_i18n('Y')); ?>
                    </p>
                    <a href="#" target="_blank" class="md:col-span-3">Instagram</a>
                    <p class="md:col-span-3">Jl. Horizon Broadway, Kec. Cisauk, Tangerang, Banten
                        &mdash; 15345</p>
                    <div class="md:col-span-3 flex md:justify-end">
                        <img src="<?php echo esc_url(get_theme_file_uri('/images/logo-short.png')); ?>" alt=""
                            class="h-5 w-auto object-contain">
                    </div>
                </div>
                <div class="grid grid-cols-2 md:hidden text-light-brown text-[9px] mt-24">
                    <a href="#" target="_blank">Instagram</a>
                    <p>Jl. Horizon Broadway, Kec. Cisauk, Tangerang, Banten
                        &mdash; 15345</p>
                </div>
                <div class="flex md:hidden justify-between items-end mt-8 text-light-brown text-[9px]">
                    <p>&copy; Copyright Arti Design Studio,
                        <?php echo esc_html(date_i18n('Y')); ?>
                    </p>
                    <div>
                        <img src="<?php echo esc_url(get_theme_file_uri('/images/logo-short.png')); ?>" alt=""
                            class="h-5 w-auto object-contain">
                    </div>
                </div>
            </div>
        </div>

        <div id="content" class="site-content grow">
            <?php do_action('tailpress_content_start'); ?>
            <main>