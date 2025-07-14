<?php get_header(); ?>

    <div class="container">
        <!-- Breadcrumbs -->
        <?php blogsemantic_breadcrumbs(); ?>

        <div class="row">
            <!-- Post Content -->
            <div class="col-lg-8">
                <?php while (have_posts()) : the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('post-single'); ?>>
                        <!-- Post Header -->
                        <header class="post-header mb-4">
                            <?php
                            $categories = get_the_category();
                            if ($categories) :
                                ?>
                                <div class="mb-3">
                                    <?php foreach ($categories as $category) : ?>
                                        <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>"
                                           class="badge bg-primary text-decoration-none me-2">
                                            <?php echo esc_html($category->name); ?>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>

                            <h1 class="post-title mb-3"><?php the_title(); ?></h1>

                            <div class="post-meta d-flex flex-wrap align-items-center text-muted mb-4">
                                <div class="me-4 mb-2">
                                    <i class="bi bi-person me-1"></i>
                                    <span>oleh <?php the_author_posts_link(); ?></span>
                                </div>
                                <div class="me-4 mb-2">
                                    <i class="bi bi-calendar3 me-1"></i>
                                    <time datetime="<?php echo get_the_date('c'); ?>"><?php echo get_the_date(); ?></time>
                                </div>
                                <div class="me-4 mb-2">
                                    <i class="bi bi-eye me-1"></i>
                                    <span><?php echo number_format(blogsemantic_get_post_views()); ?> views</span>
                                </div>
                                <?php if (get_comments_number()) : ?>
                                    <div class="mb-2">
                                        <i class="bi bi-chat me-1"></i>
                                        <a href="#comments" class="text-muted text-decoration-none">
                                            <?php echo get_comments_number(); ?> komentar
                                        </a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </header>

                        <!-- Featured Image -->
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="post-thumbnail mb-4">
                                <?php the_post_thumbnail('large', array('class' => 'img-fluid rounded')); ?>
                            </div>
                        <?php endif; ?>

                        <!-- Post Content -->
                        <div class="post-content">
                            <?php the_content(); ?>

                            <?php
                            wp_link_pages(array(
                                'before' => '<div class="page-links mt-4"><span class="page-links-title">Halaman:</span>',
                                'after'  => '</div>',
                            ));
                            ?>
                        </div>

                        <!-- Post Footer -->
                        <footer class="post-footer mt-5 pt-4" style="border-top: 1px solid #dee2e6;">
                            <!-- Tags -->
                            <?php
                            $tags = get_the_tags();
                            if ($tags) :
                                ?>
                                <div class="post-tags mb-4">
                                    <h6 class="mb-3">Tags:</h6>
                                    <div class="d-flex flex-wrap gap-2">
                                        <?php foreach ($tags as $tag) : ?>
                                            <a href="<?php echo get_tag_link($tag->term_id); ?>"
                                               class="badge bg-secondary text-decoration-none">
                                                <?php echo esc_html($tag->name); ?>
                                            </a>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- Share Buttons -->
                            <div class="post-share mb-4">
                                <h6 class="mb-3">Share this post:</h6>
                                <div class="d-flex gap-2">
                                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink()); ?>"
                                       target="_blank" rel="noopener" class="btn btn-outline-primary btn-sm">
                                        <i class="bi bi-facebook"></i> Facebook
                                    </a>
                                    <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(get_permalink()); ?>&text=<?php echo urlencode(get_the_title()); ?>"
                                       target="_blank" rel="noopener" class="btn btn-outline-info btn-sm">
                                        <i class="bi bi-twitter"></i> Twitter
                                    </a>
                                    <a href="https://wa.me/?text=<?php echo urlencode(get_the_title() . ' - ' . get_permalink()); ?>"
                                       target="_blank" rel="noopener" class="btn btn-outline-success btn-sm">
                                        <i class="bi bi-whatsapp"></i> WhatsApp
                                    </a>
                                    <button class="btn btn-outline-secondary btn-sm" onclick="copyToClipboard('<?php echo get_permalink(); ?>')">
                                        <i class="bi bi-link-45deg"></i> Copy Link
                                    </button>
                                </div>
                            </div>

                            <!-- Author Bio -->
                            <div class="author-bio p-4" style="background: #f8f9fa; border-radius: 8px;">
                                <div class="d-flex">
                                    <div class="author-avatar me-3">
                                        <?php echo get_avatar(get_the_author_meta('ID'), 80, '', '', array('class' => 'rounded-circle')); ?>
                                    </div>
                                    <div class="author-info">
                                        <h6 class="mb-2"><?php the_author(); ?></h6>
                                        <?php if (get_the_author_meta('description')) : ?>
                                            <p class="text-muted mb-2"><?php echo get_the_author_meta('description'); ?></p>
                                        <?php endif; ?>
                                        <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"
                                           class="btn btn-outline-primary btn-sm">
                                            Lihat semua artikel
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </footer>
                    </article>

                    <!-- Related Posts -->
                    <?php
                    $related_posts = get_posts(array(
                        'category__in'   => wp_get_post_categories(get_the_ID()),
                        'numberposts'    => 3,
                        'post__not_in'   => array(get_the_ID()),
                        'orderby'        => 'rand'
                    ));

                    if ($related_posts) :
                        ?>
                        <section class="related-posts mt-5 pt-5" style="border-top: 2px solid #dee2e6;">
                            <h3 class="mb-4">Artikel Terkait</h3>
                            <div class="row">
                                <?php foreach ($related_posts as $post) : setup_postdata($post); ?>
                                    <div class="col-md-4 mb-4">
                                        <article class="post-card">
                                            <?php if (has_post_thumbnail()) : ?>
                                                <div class="post-img" style="background-image: url('<?php echo get_the_post_thumbnail_url(get_the_ID(), 'medium'); ?>'); background-size: cover; background-position: center;">
                                                </div>
                                            <?php else : ?>
                                                <div class="post-img">
                                                    <i class="bi bi-file-text" style="font-size: 2rem;"></i>
                                                </div>
                                            <?php endif; ?>

                                            <div class="p-3">
                                                <h6 class="mb-2">
                                                    <a href="<?php the_permalink(); ?>" class="text-decoration-none"><?php the_title(); ?></a>
                                                </h6>
                                                <small class="text-muted"><?php echo blogsemantic_time_ago(); ?></small>
                                            </div>
                                        </article>
                                    </div>
                                <?php endforeach; wp_reset_postdata(); ?>
                            </div>
                        </section>
                    <?php endif; ?>

                    <!-- Navigation -->
                    <nav class="post-navigation mt-5 pt-4" style="border-top: 1px solid #dee2e6;">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <?php
                                $prev_post = get_previous_post();
                                if ($prev_post) :
                                    ?>
                                    <a href="<?php echo get_permalink($prev_post->ID); ?>" class="text-decoration-none">
                                        <div class="nav-item p-3 border rounded">
                                            <small class="text-muted d-block">
                                                <i class="bi bi-arrow-left me-1"></i> Artikel Sebelumnya
                                            </small>
                                            <strong><?php echo get_the_title($prev_post->ID); ?></strong>
                                        </div>
                                    </a>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-6 mb-3">
                                <?php
                                $next_post = get_next_post();
                                if ($next_post) :
                                    ?>
                                    <a href="<?php echo get_permalink($next_post->ID); ?>" class="text-decoration-none">
                                        <div class="nav-item p-3 border rounded text-end">
                                            <small class="text-muted d-block">
                                                Artikel Berikutnya <i class="bi bi-arrow-right ms-1"></i>
                                            </small>
                                            <strong><?php echo get_the_title($next_post->ID); ?></strong>
                                        </div>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </nav>

                    <!-- Comments -->
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

    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                // Show success message
                const button = event.target.closest('button');
                const originalText = button.innerHTML;
                button.innerHTML = '<i class="bi bi-check"></i> Copied!';
                button.classList.replace('btn-outline-secondary', 'btn-success');

                setTimeout(function() {
                    button.innerHTML = originalText;
                    button.classList.replace('btn-success', 'btn-outline-secondary');
                }, 2000);
            });
        }
    </script>

<?php get_footer(); ?>