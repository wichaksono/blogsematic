<?php get_header(); ?>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row" id="featuredPosts">
                <?php
                $featured_posts = blogsemantic_get_featured_posts(3);
                if ($featured_posts) :
                    foreach ($featured_posts as $post) :
                        setup_postdata($post);
                        $categories = get_the_category();
                        $primary_category = !empty($categories) ? $categories[0] : null;
                        ?>
                        <div class="col-lg-4 col-md-6 mb-4">
                            <article class="featured-post">
                                <?php if (has_post_thumbnail()) : ?>
                                    <div class="featured-post-img" style="background-image: url('<?php echo get_the_post_thumbnail_url(get_the_ID(), 'medium_large'); ?>'); background-size: cover; background-position: center;">
                                    </div>
                                <?php else : ?>
                                    <div class="featured-post-img">
                                        <i class="bi bi-image"></i>
                                    </div>
                                <?php endif; ?>

                                <div class="featured-post-overlay">
                                    <div class="featured-post-meta">
                                        <?php if ($primary_category) : ?>
                                            <span class="badge bg-primary"><?php echo esc_html($primary_category->name); ?></span>
                                        <?php endif; ?>
                                        <small class="text-white-50"><?php echo blogsemantic_time_ago(); ?></small>
                                    </div>
                                    <h3 class="featured-post-title">
                                        <a href="<?php the_permalink(); ?>" class="text-white text-decoration-none"><?php the_title(); ?></a>
                                    </h3>
                                </div>
                            </article>
                        </div>
                    <?php
                    endforeach;
                    wp_reset_postdata();
                else :
                    ?>
                    <!-- Default featured posts if none set -->
                    <div class="col-lg-4 col-md-6 mb-4">
                        <article class="featured-post">
                            <div class="featured-post-img">
                                <i class="bi bi-image"></i>
                            </div>
                            <div class="featured-post-overlay">
                                <div class="featured-post-meta">
                                    <span class="badge bg-primary">Tutorial</span>
                                    <small class="text-white-50">2 hari lalu</small>
                                </div>
                                <h3 class="featured-post-title">Panduan Lengkap Semantic HTML</h3>
                            </div>
                        </article>
                    </div>

                    <div class="col-lg-4 col-md-6 mb-4">
                        <article class="featured-post">
                            <div class="featured-post-img">
                                <i class="bi bi-code-slash"></i>
                            </div>
                            <div class="featured-post-overlay">
                                <div class="featured-post-meta">
                                    <span class="badge bg-success">Web Dev</span>
                                    <small class="text-white-50">3 hari lalu</small>
                                </div>
                                <h3 class="featured-post-title">Bootstrap 5 Tanpa jQuery</h3>
                            </div>
                        </article>
                    </div>

                    <div class="col-lg-4 col-md-6 mb-4">
                        <article class="featured-post">
                            <div class="featured-post-img">
                                <i class="bi bi-speedometer2"></i>
                            </div>
                            <div class="featured-post-overlay">
                                <div class="featured-post-meta">
                                    <span class="badge bg-warning">Performance</span>
                                    <small class="text-white-50">5 hari lalu</small>
                                </div>
                                <h3 class="featured-post-title">Optimasi Kecepatan Website</h3>
                            </div>
                        </article>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Ads Banner -->
    <div class="container">
        <div class="ads-banner">
            Ads 728 X 90 px
        </div>
    </div>

    <!-- Main Content -->
    <div class="container">
        <div class="row">
            <!-- Latest Posts -->
            <div class="col-lg-8">
                <h2 class="h3 mb-4">Latest Posts</h2>
                <div class="row">
                    <?php
                    if (have_posts()) :
                        $post_count = 0;
                        while (have_posts()) : the_post();
                            $categories = get_the_category();
                            $primary_category = !empty($categories) ? $categories[0] : null;
                            $post_count++;
                            ?>
                            <div class="col-md-6">
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
                                        <?php if ($primary_category) : ?>
                                            <span class="badge bg-info mb-2"><?php echo esc_html($primary_category->name); ?></span>
                                        <?php endif; ?>

                                        <h3 class="h6 mb-2" style="color: #1a202c;">
                                            <a href="<?php the_permalink(); ?>" class="text-decoration-none" style="color: inherit;"><?php the_title(); ?></a>
                                        </h3>

                                        <p class="text-muted small mb-3"><?php echo get_the_excerpt(); ?></p>

                                        <small class="text-muted">
                                            oleh <?php the_author(); ?> • <?php echo blogsemantic_time_ago(); ?>
                                        </small>
                                    </div>
                                </article>
                            </div>

                            <?php
                            // Add ads after every 4 posts
                            if ($post_count % 4 == 0) :
                                ?>
                                <div class="col-12">
                                    <div class="ads-banner">
                                        Ads 728 X 90 px
                                    </div>
                                </div>
                            <?php endif; ?>

                        <?php
                        endwhile;
                    else :
                        ?>
                        <div class="col-12">
                            <div class="text-center py-5">
                                <i class="bi bi-journal-x" style="font-size: 4rem; color: #6c757d;"></i>
                                <h3 class="mt-3">Belum Ada Artikel</h3>
                                <p class="text-muted">Silakan kembali lagi nanti untuk artikel terbaru.</p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Pagination -->
                <?php blogsemantic_pagination(); ?>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <?php get_sidebar(); ?>
            </div>
        </div>
    </div>

<?php get_footer(); ?>