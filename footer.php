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

<footer id="colophon" class=" text-dark-brown bg-beige-1" role="contentinfo">
    <div class="px-4 md:px-12 py-6 md:py-12 rounded-tr-[32px] bg-beige-2">
        <?php do_action('tailpress_footer'); ?>
        <div class="grid grid-cols-2 md:grid-cols-12 gap-8 md:gap-6">
            <div class="col-span-2">
                <p class="text-[12px] tracking-[0.31em] uppercase leading-tight font-medium">Get In
                    Touch<br>With Us</p>
            </div>
            <div class="col-span-1 md:col-span-2 md:col-start-3 text-[9px]">
                <p class="mb-4 md:mb-6">Instagram</p>
                <a href="https://www.instagram.com/arti.designstudio/" target="_blank"
                    class="text-light-brown">@arti.designstudio</a>
            </div>
            <div class="col-span-1 md:col-span-2 md:col-start-5 text-[9px]">
                <p class="mb-4 md:mb-6">Email</p>
                <p class="text-light-brown">info@arti-design.com</p>
            </div>
            <div class="col-span-2 md:col-span-3 md:col-start-7 text-[9px]">
                <p class="mb-4 md:mb-6">Address</p>
                <p class="text-light-brown">Jl. Horizon Broadway, Kec. Cisauk<br>Tangerang, Banten - 15345</p>
            </div>
            <div class="hidden md:flex md:col-span-1 md:col-start-12 md:justify-end items-start">
                <img src="<?php echo esc_url(get_theme_file_uri('/images/logo-short.png')); ?>" alt=""
                    class="h-[22px] w-auto object-contain">
            </div>
        </div>

        <div class="flex justify-between items-end">
            <div class="mt-14 md:mt-24 text-[9px] text-light-brown">
                &copy; Copyright Arti Design Studio,
                <?php echo esc_html(date_i18n('Y')); ?>
            </div>
            <div class="md:hidden">
                <img src="<?php echo esc_url(get_theme_file_uri('/images/logo-short.png')); ?>" alt=""
                    class="h-[22px] w-auto object-contain">
            </div>
        </div>
    </div>
</footer>


<script src="https://unpkg.com/lenis@1.1.18/dist/lenis.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const isMobile = window.innerWidth < 1024;

        const lenis = new Lenis({
            duration: 1.2,
            easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)),
            smooth: true,
        });

        function raf(time) {
            lenis.raf(time);
            requestAnimationFrame(raf);
        }
        requestAnimationFrame(raf);

        // Handle ".is-inview" animation triggers (Previously Locomotive)
        // Disabled on mobile for cleaner UX
        if (!isMobile) {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    const targetClass = entry.target.getAttribute('data-scroll-class') ||
                        'is-inview';
                    if (entry.isIntersecting) {
                        entry.target.classList.add(targetClass);
                    }
                });
            }, {
                threshold: 0.1
            });

            document.querySelectorAll('[data-scroll]').forEach(el => observer.observe(el));
        } else {
            // Force show elements on mobile if they rely on "is-inview"
            document.querySelectorAll('[data-scroll]').forEach(el => {
                const targetClass = el.getAttribute('data-scroll-class') || 'is-inview';
                el.classList.add(targetClass);
            });
        }

        // Handle "data-scroll-speed" parallax
        lenis.on('scroll', (e) => {
            if (!isMobile) {
                AOS.refresh();

                document.querySelectorAll('[data-scroll-speed]').forEach(el => {
                    const speed = parseFloat(el.getAttribute('data-scroll-speed')) || 0;
                    const yPos = -(e.scroll * speed * 0.05);
                    el.style.transform = `translate3d(0, ${yPos}px, 0)`;
                });
            }
        });

        window.lenis = lenis;
    });

    AOS.init({
        duration: 1000,
        once: true,
        offset: 100,
        disable: 'mobile' // Built-in AOS mobile disable
    });
</script>

<?php wp_footer(); ?>
</body>

</html>