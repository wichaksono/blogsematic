<?php get_header(); ?>

    <div class="container">
        <!-- Breadcrumbs -->
        <?php blogsemantic_breadcrumbs(); ?>

        <div class="row">
            <!-- Page Content -->
            <div class="col-lg-8">
                <?php while (have_posts()) : the_post(); ?>
                    <article id="page-<?php the_ID(); ?>" <?php post_class('page-single'); ?>>
                        <!-- Page Header -->
                        <header class="page-header mb-4">
                            <h1 class="page-title mb-3"><?php the_title(); ?></h1>

                            <?php if (get_the_date() !== get_the_modified_date()) : ?>
                                <div class="page-meta text-muted mb-4">
                                    <small>
                                        <i class="bi bi-calendar3 me-1"></i>
                                        Diperbarui: <time datetime="<?php echo get_the_modified_date('c'); ?>"><?php echo get_the_modified_date(); ?></time>
                                    </small>
                                </div>
                            <?php endif; ?>
                        </header>

                        <!-- Featured Image -->
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="page-thumbnail mb-4">
                                <?php the_post_thumbnail('large', array('class' => 'img-fluid rounded')); ?>
                            </div>
                        <?php endif; ?>

                        <!-- Page Content -->
                        <div class="page-content">
                            <?php the_content(); ?>

                            <?php
                            wp_link_pages(array(
                                'before' => '<div class="page-links mt-4"><span class="page-links-title">Halaman:</span>',
                                'after'  => '</div>',
                            ));
                            ?>
                        </div>

                        <!-- Page Footer -->
                        <?php if (is_page_template('page-contact.php') || is_page('contact') || is_page('kontak')) : ?>
                            <footer class="page-footer mt-5 pt-4" style="border-top: 1px solid #dee2e6;">
                                <!-- Contact Information -->
                                <div class="contact-info">
                                    <div class="row">
                                        <div class="col-md-4 mb-4">
                                            <div class="contact-item text-center p-4" style="background: #f8f9fa; border-radius: 8px;">
                                                <i class="bi bi-envelope display-6 text-primary mb-3"></i>
                                                <h6>Email</h6>
                                                <p class="text-muted mb-0">info@<?php echo str_replace('www.', '', $_SERVER['HTTP_HOST']); ?></p>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-4">
                                            <div class="contact-item text-center p-4" style="background: #f8f9fa; border-radius: 8px;">
                                                <i class="bi bi-phone display-6 text-primary mb-3"></i>
                                                <h6>Telepon</h6>
                                                <p class="text-muted mb-0">+62 123 456 789</p>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-4">
                                            <div class="contact-item text-center p-4" style="background: #f8f9fa; border-radius: 8px;">
                                                <i class="bi bi-geo-alt display-6 text-primary mb-3"></i>
                                                <h6>Alamat</h6>
                                                <p class="text-muted mb-0">Jakarta, Indonesia</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </footer>
                        <?php endif; ?>
                    </article>

                    <!-- Comments (if enabled for pages) -->
                    <?php
                    if (comments_open() || get_comments_number()) :
                        comments_template();
                    endif;
                    ?>

                <?php endwhile; ?>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <?php get_sidebar(); ?>
            </div>
        </div>
    </div>

<?php get_footer(); ?>