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
    $loader_animation_uri = get_theme_file_uri('/images/arti-logo-a.json');
    $header_logo_animation_uri = get_theme_file_uri('/images/logo-arti-full.json');
    ?>

    <div id="site-loader"
        class="fixed inset-0 z-[100] flex items-center justify-center bg-beige-2 opacity-100 transition-opacity duration-700">
        <div class="relative flex h-28 w-28 items-center justify-center">
            <div id="loader-logo-animation" class="h-[33px] w-[33px] opacity-90"
                data-animation-path="<?php echo esc_url($loader_animation_uri); ?>" aria-hidden="true"></div>
        </div>
    </div>

    <script>
        (function () {
            function initLogoAnimations() {
                var animationContainer = document.getElementById('loader-logo-animation');
                var headerLogoAnimationContainer = document.getElementById('header-logo-animation');
                var headerLogoLink = document.getElementById('header-logo-link');

                if (!animationContainer && !headerLogoAnimationContainer) {
                    return;
                }

                function loadLogoAnimations() {
                    if (!window.lottie) {
                        return;
                    }

                    if (animationContainer) {
                        window.lottie.loadAnimation({
                            container: animationContainer,
                            renderer: 'svg',
                            loop: true,
                            autoplay: true,
                            path: animationContainer.getAttribute('data-animation-path')
                        });
                    }

                    if (headerLogoAnimationContainer && headerLogoLink) {
                        var headerLogoAnimation = window.lottie.loadAnimation({
                            container: headerLogoAnimationContainer,
                            renderer: 'svg',
                            rendererSettings: {
                                preserveAspectRatio: 'xMidYMid meet'
                            },
                            loop: true,
                            autoplay: false,
                            path: headerLogoAnimationContainer.getAttribute('data-animation-path')
                        });

                        function fitHeaderLogoToArtwork() {
                            var logoSvg = headerLogoAnimationContainer.querySelector('svg');
                            var logoArtwork = logoSvg ? logoSvg.firstElementChild : null;

                            if (!logoSvg || !logoArtwork || !logoArtwork.getBBox) {
                                return;
                            }

                            var logoBounds = logoArtwork.getBBox();

                            if (!logoBounds.width || !logoBounds.height) {
                                return;
                            }

                            var logoPaddingX = 12;
                            var logoOffsetX = 10;
                            var logoWidth = headerLogoAnimationContainer.getBoundingClientRect().width || 54;
                            logoSvg.setAttribute(
                                'viewBox',
                                (logoBounds.x - logoPaddingX - logoOffsetX) + ' ' + logoBounds.y + ' ' + (logoBounds.width + (logoPaddingX * 2)) + ' ' + logoBounds.height
                            );
                            logoSvg.style.display = 'block';
                            logoSvg.style.overflow = 'visible';
                            logoSvg.style.height = '27px';
                            logoSvg.style.width = logoWidth + 'px';
                            headerLogoAnimationContainer.style.height = '27px';
                            headerLogoAnimationContainer.style.width = logoWidth + 'px';
                        }

                        function playHeaderLogoAnimation() {
                            headerLogoAnimation.goToAndPlay(0, true);
                        }

                        function stopHeaderLogoAnimation() {
                            headerLogoAnimation.goToAndStop(0, true);
                        }

                        headerLogoAnimation.addEventListener('DOMLoaded', function () {
                            fitHeaderLogoToArtwork();
                            stopHeaderLogoAnimation();
                        });
                        headerLogoLink.addEventListener('mouseenter', playHeaderLogoAnimation);
                        headerLogoLink.addEventListener('focus', playHeaderLogoAnimation);
                        headerLogoLink.addEventListener('mouseleave', stopHeaderLogoAnimation);
                        headerLogoLink.addEventListener('blur', stopHeaderLogoAnimation);
                    }
                }

                if (window.lottie) {
                    loadLogoAnimations();
                    return;
                }

                var lottieScript = document.createElement('script');
                lottieScript.src = 'https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.12.2/lottie.min.js';
                lottieScript.onload = loadLogoAnimations;
                document.head.appendChild(lottieScript);
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', initLogoAnimations);
                return;
            }

            initLogoAnimations();
        })();
    </script>

    <div id="page" class="min-h-screen flex flex-col opacity-0 transition-opacity duration-700">
        <?php do_action('tailpress_header'); ?>

        <header id="site-header"
            class="fixed top-0 inset-x-0 z-40 bg-beige-1 py-5 px-4 md:px-9 transition-colors duration-300">
            <div class="flex items-center justify-between">
                <a id="header-logo-link" href="<?php echo esc_url(home_url('/')); ?>"
                    class="inline-flex items-center !no-underline text-zinc-900"
                    aria-label="<?php echo esc_attr(get_bloginfo('name')); ?>">
                    <div id="header-logo-animation" class="pointer-events-none ml-2 h-[27px] !w-[54px] overflow-visible"
                        data-animation-path="<?php echo esc_url($header_logo_animation_uri); ?>" aria-hidden="true">
                    </div>
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
                    class="hidden md:grid grid-cols-1 gap-4 text-light-brown text-sm md:grid-cols-12 md:gap-6 text-[12px]">
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
                <div class="grid grid-cols-2 md:hidden text-light-brown text-[12px] mt-24">
                    <a href="#" target="_blank">Instagram</a>
                    <p>Jl. Horizon Broadway, Kec. Cisauk, Tangerang, Banten
                        &mdash; 15345</p>
                </div>
                <div class="flex md:hidden justify-between items-end mt-8 text-light-brown text-[12px]">
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

        <div id="content" class="site-content grow pt-[78px]">
            <?php do_action('tailpress_content_start'); ?>
            <main>