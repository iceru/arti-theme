<?php
/**
 * Template Name: Homepage
 *
 * @package TailPress
 */

get_header();
?>

<section
    class="relative flex min-h-[72vh] items-center justify-center bg-[#D4CFC7] bg-[radial-gradient(circle_at_1px_1px,rgba(0,0,0,0.14)_1px,transparent_1px)] bg-[size:38px_38px] px-6 py-16 md:min-h-[78vh]">
    <nav class="flex items-center gap-10 md:gap-16 text-zinc-800 text-sm  tracking-[0.45em] uppercase font-medium">
        <a href="/studio" class="!no-underline hover:opacity-70 transition">Studio</a>
        <a href="#" class="!no-underline hover:opacity-70 transition">Works</a>
    </nav>
</section>

<?php
get_footer();
?>