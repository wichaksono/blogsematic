<?php get_header(); ?>

    <div class="container">
        <!-- Breadcrumbs -->
        <?php blogsemantic_breadcrumbs(); ?>

        <div class="row">
            <!-- Archive Content -->
            <div class="col-lg-8">
                <!-- Archive Header -->
                <header class="archive-header mb-5">
                    <?php if (is_category()) : ?>
                        <h1 class="archive-title">Kategori: <?php single_cat_title(); ?></h1>
                        <?php if (category_description()) : ?>
                            <div class="archive-description text-muted">
                                <?php echo category_description(); ?>
                            </div>
                        <?php endif; ?>
                    <?php elseif (is_tag()) : ?>
                        <h1 class="archive-title">Tag: <?php single_tag_title(); ?></h1>
                        <?php if (tag_description()) : ?>
                            <div class="archive-description text-muted">
                                <?php echo tag_description(); ?>
                            </div>
                        <?php endif; ?>
                    <?php elseif (is_author()) : ?>
                        <h1 class="archive-title">Penulis: <?php echo get_the_author(); ?></h1>
                        <?php if (get_the_author_meta('description')) : ?>
                            <div class="archive-description text-muted">
                                <?php echo get_the_author_meta('description'); ?>
                            </div>
                        <?php endif; ?>
                    <?php elseif (is_date()) : ?>
                        <h1 class="archive-title">
                            <?php
                            if (is_year()) {
                                echo 'Tahun: ' . get_the_date('Y');
                            } elseif (is_month()) {
                                echo 'Bulan: ' . get_the_date('F Y');
                            } elseif (is_day()) {
                                echo 'Tanggal: ' . get_the_date();
                            }
                            ?>
                        </h1>
                    <?php else : ?>
                        <h1 class="archive-title"><?php the_archive_title(); ?></h1>
                        <?php if (the_archive_description()) : ?>
                            <div class="archive-description text-muted">
                                <?php the_archive_description(); ?>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>

                    <div class="archive-meta mt-3">
                        <small class="text-muted">
                            <i class="bi bi-file-text me-1"></i>
                            <?php echo $wp_query->found_posts; ?> artikel ditemukan
                        </small>
                    </div>
                </header>

                <!-- Posts Listing -->
                <?php if (have_posts()) : ?>
                    <div class="posts-listing">
                        <?php $post_count = 0; ?>
                        <?php while (have_posts()) : the_post(); ?>
                            <?php
                            $categories = get_the_category();
                            $primary_category = !empty($categories) ? $categories[0] : null;
                            $post_count++;
                            ?>

                            <article class="post-item mb-4 pb-4" style="border-bottom: 1px solid #dee2e6;">
                                <div class="row align-items-center">
                                    <!-- Post Image -->
                                    <div class="col-md-4 mb-3 mb-md-0">
                                        <div class="post-thumbnail">
                                            <?php if (has_post_thumbnail()) : ?>
                                                <a href="<?php the_permalink(); ?>">
                                                    <img src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'medium'); ?>"
                                                         alt="<?php the_title_attribute(); ?>"
                                                         class="img-fluid rounded"
                                                         style="width: 100%; height: 200px; object-fit: cover;">
                                                </a>
                                            <?php else : ?>
                                                <a href="<?php the_permalink(); ?>">
                                                    <div class="post-placeholder rounded d-flex align-items-center justify-content-center"
                                                         style="width: 100%; height: 200px; background: linear-gradient(45deg, #f8f9fa, #e9ecef);">
                                                        <i class="bi bi-file-text" style="font-size: 3rem; color: #6c757d;"></i>
                                                    </div>
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <!-- Post Content -->
                                    <div class="col-md-8">
                                        <div class="post-content">
                                            <!-- Post Meta -->
                                            <div class="post-meta mb-2">
                                                <?php if ($primary_category) : ?>
                                                    <a href="<?php echo esc_url(get_category_link($primary_category->term_id)); ?>"
                                                       class="badge bg-primary text-decoration-none me-2">
                                                        <?php echo esc_html($primary_category->name); ?>
                                                    </a>
                                                <?php endif; ?>
                                                <small class="text-muted">
                                                    <i class="bi bi-calendar3 me-1"></i><?php echo blogsemantic_time_ago(); ?>
                                                    <span class="mx-2">•</span>
                                                    <i class="bi bi-person me-1"></i><?php the_author(); ?>
                                                    <span class="mx-2">•</span>
                                                    <i class="bi bi-eye me-1"></i><?php echo number_format(blogsemantic_get_post_views()); ?> views
                                                </small>
                                            </div>

                                            <!-- Post Title -->
                                            <h3 class="post-title h5 mb-2">
                                                <a href="<?php the_permalink(); ?>" class="text-decoration-none">
                                                    <?php the_title(); ?>
                                                </a>
                                            </h3>

                                            <!-- Post Excerpt -->
                                            <p class="post-excerpt text-muted mb-3">
                                                <?php echo get_the_excerpt(); ?>
                                            </p>

                                            <!-- Read More -->
                                            <a href="<?php the_permalink(); ?>" class="btn btn-outline-primary btn-sm">
                                                Baca Selengkapnya <i class="bi bi-arrow-right ms-1"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </article>

                            <?php
                            // Add ads after every 5 posts
                            if ($post_count % 5 == 0) :
                                ?>
                                <div class="ads-banner">
                                    Ads 728 X 90 px
                                </div>
                            <?php endif; ?>

                        <?php endwhile; ?>
                    </div>

                    <!-- Pagination -->
                    <?php blogsemantic_pagination(); ?>

                <?php else : ?>
                    <div class="no-posts text-center py-5">
                        <i class="bi bi-journal-x" style="font-size: 4rem; color: #6c757d;"></i>
                        <h3 class="mt-3">Tidak Ada Artikel</h3>
                        <p class="text-muted">Maaf, tidak ada artikel yang ditemukan untuk kriteria ini.</p>
                        <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-primary">
                            <i class="bi bi-house me-2"></i>Kembali ke Beranda
                        </a>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <?php get_sidebar(); ?>
            </div>
        </div>
    </div>

<?php get_footer(); ?>