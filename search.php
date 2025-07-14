<?php get_header(); ?>

    <div class="container">
        <!-- Breadcrumbs -->
        <?php blogsemantic_breadcrumbs(); ?>

        <div class="row">
            <!-- Search Results -->
            <div class="col-lg-8">
                <!-- Search Header -->
                <header class="search-header mb-5">
                    <h1 class="search-title">Hasil Pencarian</h1>
                    <?php if (get_search_query()) : ?>
                        <p class="search-query mb-3">
                            Kata kunci: <strong>"<?php echo get_search_query(); ?>"</strong>
                        </p>
                    <?php endif; ?>

                    <div class="search-meta">
                        <small class="text-muted">
                            <i class="bi bi-search me-1"></i>
                            <?php echo $wp_query->found_posts; ?> hasil ditemukan
                            <?php if (get_search_query()) : ?>
                                untuk "<em><?php echo get_search_query(); ?></em>"
                            <?php endif; ?>
                        </small>
                    </div>

                    <!-- Search Form -->
                    <div class="search-form-wrapper mt-4 p-4" style="background: #f8f9fa; border-radius: 8px;">
                        <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
                            <div class="input-group">
                                <input type="text"
                                       class="form-control"
                                       name="s"
                                       value="<?php echo get_search_query(); ?>"
                                       placeholder="Cari artikel, tutorial, tips...">
                                <button class="btn btn-primary" type="submit">
                                    <i class="bi bi-search"></i> Cari
                                </button>
                            </div>
                            <small class="form-text text-muted mt-2">
                                <i class="bi bi-lightbulb me-1"></i>
                                Tips: Gunakan kata kunci spesifik untuk hasil yang lebih akurat
                            </small>
                        </form>
                    </div>
                </header>

                <!-- Search Results -->
                <?php if (have_posts()) : ?>
                    <div class="search-results">
                        <?php $post_count = 0; ?>
                        <?php while (have_posts()) : the_post(); ?>
                            <?php
                            $categories = get_the_category();
                            $primary_category = !empty($categories) ? $categories[0] : null;
                            $post_count++;
                            ?>

                            <article class="search-item mb-4 pb-4" style="border-bottom: 1px solid #dee2e6;">
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
                                                <small class="text-primary me-2">
                                                    <i class="bi bi-file-text me-1"></i><?php echo get_post_type_object(get_post_type())->labels->singular_name; ?>
                                                </small>

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
                                                </small>
                                            </div>

                                            <!-- Post Title -->
                                            <h3 class="post-title h5 mb-2">
                                                <a href="<?php the_permalink(); ?>" class="text-decoration-none">
                                                    <?php
                                                    // Highlight search terms in title
                                                    $title = get_the_title();
                                                    $search_query = get_search_query();
                                                    if ($search_query) {
                                                        $title = preg_replace('/(' . preg_quote($search_query, '/') . ')/i', '<mark>$1</mark>', $title);
                                                    }
                                                    echo $title;
                                                    ?>
                                                </a>
                                            </h3>

                                            <!-- Post Excerpt -->
                                            <p class="post-excerpt text-muted mb-3">
                                                <?php
                                                // Get excerpt and highlight search terms
                                                $excerpt = get_the_excerpt();
                                                $search_query = get_search_query();
                                                if ($search_query) {
                                                    $excerpt = preg_replace('/(' . preg_quote($search_query, '/') . ')/i', '<mark>$1</mark>', $excerpt);
                                                }
                                                echo $excerpt;
                                                ?>
                                            </p>

                                            <!-- Post URL -->
                                            <div class="post-url mb-2">
                                                <small class="text-success">
                                                    <i class="bi bi-link-45deg me-1"></i><?php echo esc_url(get_permalink()); ?>
                                                </small>
                                            </div>

                                            <!-- Read More -->
                                            <a href="<?php the_permalink(); ?>" class="btn btn-outline-primary btn-sm">
                                                Baca Selengkapnya <i class="bi bi-arrow-right ms-1"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </article>

                            <?php
                            // Add ads after every 4 posts
                            if ($post_count % 4 == 0) :
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
                    <div class="no-results text-center py-5">
                        <i class="bi bi-search" style="font-size: 4rem; color: #6c757d;"></i>
                        <h3 class="mt-3">Tidak Ada Hasil</h3>
                        <p class="text-muted mb-4">
                            Maaf, pencarian untuk "<strong><?php echo get_search_query(); ?></strong>" tidak ditemukan.
                        </p>

                        <!-- Search Suggestions -->
                        <div class="search-suggestions">
                            <h5 class="mb-3">Saran Pencarian:</h5>
                            <ul class="list-unstyled text-muted">
                                <li class="mb-2"><i class="bi bi-check2 me-2 text-success"></i>Pastikan semua kata dieja dengan benar</li>
                                <li class="mb-2"><i class="bi bi-check2 me-2 text-success"></i>Coba kata kunci yang berbeda</li>
                                <li class="mb-2"><i class="bi bi-check2 me-2 text-success"></i>Coba kata kunci yang lebih umum</li>
                                <li class="mb-2"><i class="bi bi-check2 me-2 text-success"></i>Coba dengan lebih sedikit kata kunci</li>
                            </ul>
                        </div>

                        <!-- Popular Categories -->
                        <div class="popular-categories mt-4">
                            <h6 class="mb-3">Atau jelajahi kategori populer:</h6>
                            <?php
                            $popular_categories = get_categories(array(
                                'orderby' => 'count',
                                'order'   => 'DESC',
                                'number'  => 5
                            ));

                            if ($popular_categories) :
                                ?>
                                <div class="d-flex flex-wrap gap-2 justify-content-center">
                                    <?php foreach ($popular_categories as $category) : ?>
                                        <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>"
                                           class="btn btn-outline-secondary btn-sm">
                                            <?php echo esc_html($category->name); ?>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="mt-4">
                            <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-primary">
                                <i class="bi bi-house me-2"></i>Kembali ke Beranda
                            </a>
                        </div>
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