<?php get_header(); ?>

    <div class="container">
        <div class="row">
            <!-- 404 Content -->
            <div class="col-lg-8 mx-auto">
                <div class="error-404 text-center py-5">
                    <!-- 404 Icon -->
                    <div class="error-icon mb-4">
                        <i class="bi bi-exclamation-triangle" style="font-size: 8rem; color: #ffc107;"></i>
                    </div>

                    <!-- Error Message -->
                    <h1 class="error-title display-1 fw-bold text-muted mb-3">404</h1>
                    <h2 class="error-subtitle h3 mb-4">Halaman Tidak Ditemukan</h2>
                    <p class="error-description text-muted mb-5">
                        Maaf, halaman yang Anda cari tidak dapat ditemukan.
                        Mungkin halaman telah dipindahkan, dihapus, atau URL yang Anda masukkan salah.
                    </p>

                    <!-- Search Form -->
                    <div class="error-search mb-5">
                        <h5 class="mb-3">Coba cari yang Anda butuhkan:</h5>
                        <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>" class="search-form">
                            <div class="input-group justify-content-center">
                                <div style="max-width: 400px; width: 100%;">
                                    <div class="input-group">
                                        <input type="text"
                                               class="form-control"
                                               name="s"
                                               placeholder="Ketik kata kunci...">
                                        <button class="btn btn-primary" type="submit">
                                            <i class="bi bi-search"></i> Cari
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Quick Actions -->
                    <div class="error-actions mb-5">
                        <h5 class="mb-3">Atau pilih salah satu opsi di bawah:</h5>
                        <div class="d-flex flex-wrap gap-3 justify-content-center">
                            <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-primary">
                                <i class="bi bi-house me-2"></i>Ke Beranda
                            </a>
                            <a href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>" class="btn btn-outline-primary">
                                <i class="bi bi-newspaper me-2"></i>Semua Artikel
                            </a>
                            <button onclick="history.back()" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left me-2"></i>Kembali
                            </button>
                        </div>
                    </div>

                    <!-- Popular Categories -->
                    <div class="popular-categories mb-5">
                        <h5 class="mb-3">Kategori Populer:</h5>
                        <?php
                        $popular_categories = get_categories(array(
                            'orderby' => 'count',
                            'order'   => 'DESC',
                            'number'  => 6,
                            'hide_empty' => true
                        ));

                        if ($popular_categories) :
                            ?>
                            <div class="d-flex flex-wrap gap-2 justify-content-center">
                                <?php foreach ($popular_categories as $category) : ?>
                                    <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>"
                                       class="btn btn-outline-info btn-sm">
                                        <i class="bi bi-tag me-1"></i><?php echo esc_html($category->name); ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Recent Posts -->
                    <div class="recent-posts">
                        <h5 class="mb-4">Artikel Terbaru:</h5>
                        <?php
                        $recent_posts = get_posts(array(
                            'numberposts' => 3,
                            'post_status' => 'publish'
                        ));

                        if ($recent_posts) :
                            ?>
                            <div class="row">
                                <?php foreach ($recent_posts as $post) : setup_postdata($post); ?>
                                    <div class="col-md-4 mb-4">
                                        <div class="card h-100">
                                            <?php if (has_post_thumbnail()) : ?>
                                                <img src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'medium'); ?>"
                                                     class="card-img-top"
                                                     alt="<?php the_title_attribute(); ?>"
                                                     style="height: 150px; object-fit: cover;">
                                            <?php else : ?>
                                                <div class="card-img-top d-flex align-items-center justify-content-center"
                                                     style="height: 150px; background: linear-gradient(45deg, #f8f9fa, #e9ecef);">
                                                    <i class="bi bi-file-text" style="font-size: 2rem; color: #6c757d;"></i>
                                                </div>
                                            <?php endif; ?>

                                            <div class="card-body">
                                                <h6 class="card-title">
                                                    <a href="<?php the_permalink(); ?>" class="text-decoration-none">
                                                        <?php the_title(); ?>
                                                    </a>
                                                </h6>
                                                <p class="card-text small text-muted">
                                                    <?php echo wp_trim_words(get_the_excerpt(), 15); ?>
                                                </p>
                                                <small class="text-muted">
                                                    <i class="bi bi-calendar3 me-1"></i><?php echo blogsemantic_time_ago(); ?>
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; wp_reset_postdata(); ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Contact Info -->
                    <div class="error-contact mt-5 pt-4" style="border-top: 1px solid #dee2e6;">
                        <h6 class="mb-3">Masih butuh bantuan?</h6>
                        <p class="text-muted mb-3">
                            Jika Anda yakin halaman ini seharusnya ada, silakan hubungi kami.
                        </p>
                        <div class="d-flex flex-wrap gap-3 justify-content-center">
                            <a href="mailto:info@<?php echo str_replace('www.', '', $_SERVER['HTTP_HOST']); ?>"
                               class="btn btn-outline-success btn-sm">
                                <i class="bi bi-envelope me-2"></i>Email Kami
                            </a>
                            <a href="#" class="btn btn-outline-info btn-sm">
                                <i class="bi bi-chat-dots me-2"></i>Live Chat
                            </a>
                        </div>
                    </div>

                    <!-- Fun Element -->
                    <div class="fun-element mt-5">
                        <p class="text-muted small">
                            <i class="bi bi-lightbulb me-1"></i>
                            <em>"Kadang yang tersesat justru menemukan hal yang lebih menarik."</em>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .error-404 {
            min-height: 70vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .error-icon {
            animation: bounce 2s infinite;
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateY(0);
            }
            40% {
                transform: translateY(-10px);
            }
            60% {
                transform: translateY(-5px);
            }
        }

        .card {
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-3px);
        }

        @media (max-width: 768px) {
            .error-title {
                font-size: 4rem;
            }

            .error-icon i {
                font-size: 5rem !important;
            }
        }
    </style>

<?php get_footer(); ?>