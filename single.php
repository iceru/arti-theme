<?php
/**
 * Single post template file.
 *
 * @package TailPress
 */

get_header();
?>

<?php if (have_posts()): ?>
    <?php while (have_posts()):
        the_post(); ?>
        <article <?php post_class('bg-beige-1 text-zinc-800 px-0 md:px-9 pb-20 md:pb-32 min-h-[80vh]'); ?>>
            <div class="mx-auto max-w-[1600px]">
                <?php if (has_post_thumbnail()): ?>
                    <figure class="m-0 px-0">
                        <?php the_post_thumbnail('full', ['class' => 'block w-full h-[67vh] md:h-[75vh] object-cover rounded-bl-[2.5rem] md:rounded-bl-[7.5rem]', 'loading' => 'eager']); ?>
                    </figure>
                <?php endif; ?>

                <header
                    class="pt-8 md:pt-16 px-4 md:px-0 grid grid-cols-1 md:grid-cols-[minmax(120px,160px)_minmax(0,780px)] gap-y-3 md:gap-x-10 items-start">
                    <p class="m-0 text-[0.62rem] tracking-[0.26em] uppercase text-light-brown">
                        <?php echo esc_html(get_the_date('d F Y')); ?>
                    </p>
                    <h1 class="m-0 max-w-[46rem] uppercase font-medium tracking-[0.31em]">
                        <?php the_title(); ?>
                    </h1>
                </header>

                <div
                    class="mt-8 md:mt-14 px-4 md:px-0 grid grid-cols-1 md:grid-cols-[minmax(120px,160px)_minmax(0,780px)] md:gap-x-10">
                    <div aria-hidden="true"></div>
                    <div class="entry-content max-w-[900px] !text-light-brown
                        [&_p]:m-0 [&_p]:mb-6 [&_p]:text-[0.87rem] [&_p]:leading-[2] [&_p]:tracking-[0.02em]
                        [&_h2]:mt-12 md:[&_h2]:mt-20 [&_h2]:mb-8 [&_h2]:text-base [&_h2]:leading-[1.6] [&_h2]:tracking-[0.2em] md:[&_h2]:tracking-[0.34em] [&_h2]:uppercase [&_h2]:font-medium
                        [&_h3]:mt-12 md:[&_h3]:mt-20 [&_h3]:mb-8 [&_h3]:text-base [&_h3]:leading-[1.6] [&_h3]:tracking-[0.2em] md:[&_h3]:tracking-[0.34em] [&_h3]:uppercase [&_h3]:font-medium
                        [&_figure]:mt-12 md:[&_figure]:mt-32 [&_figure]:mb-0 [&_img]:block [&_img]:w-full [&_img]:max-w-[860px]
                        [&_figcaption]:mt-3 [&_figcaption]:text-[0.72rem] [&_figcaption]:text-light-brown">
                        <?php the_content(); ?>
                    </div>
                </div>
            </div>
        </article>
    <?php endwhile; ?>
<?php endif; ?>

<?php
get_footer();
