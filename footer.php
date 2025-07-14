<!-- Footer -->
<footer class="footer">
    <div class="container">
        <!-- Brand and Quick Menu -->
        <div class="row mb-4 pb-4" style="border-bottom: 2px solid #495057;">
            <div class="col-lg-6 col-md-6 mb-4">
                <h4 class="brand-title">
                    <i class="bi bi-journal-text"></i> <?php bloginfo('name'); ?>
                </h4>
            </div>
            <div class="col-lg-6 col-md-6 mb-4 d-flex align-items-center justify-content-lg-end">
                <?php if (has_nav_menu('footer')) : ?>
                    <?php wp_nav_menu(array(
                        'theme_location' => 'footer',
                        'menu_class'     => 'd-flex flex-wrap gap-3',
                        'container'      => 'nav',
                        'depth'          => 1,
                        'fallback_cb'    => false,
                    )); ?>
                <?php else : ?>
                    <nav class="d-flex flex-wrap gap-3">
                        <a href="<?php echo esc_url(home_url('/')); ?>" class="text-decoration-none">Beranda</a>
                        <a href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>" class="text-decoration-none">Artikel</a>
                        <a href="#" class="text-decoration-none">Kategori</a>
                        <a href="#" class="text-decoration-none">Tentang</a>
                        <a href="#" class="text-decoration-none">Kontak</a>
                        <a href="#" class="text-decoration-none">Privacy</a>
                    </nav>
                <?php endif; ?>
            </div>
        </div>

        <!-- Main Footer Links -->
        <div class="row">
            <div class="col-lg-3 col-md-6 mb-4">
                <?php if (is_active_sidebar('footer-1')) : ?>
                    <?php dynamic_sidebar('footer-1'); ?>
                <?php else : ?>
                    <h5 class="footer-title">About Us</h5>
                    <p class="text-muted mb-3"><?php echo get_bloginfo('description'); ?></p>
                    <div class="social-icons">
                        <a href="#"><i class="bi bi-facebook"></i></a>
                        <a href="#"><i class="bi bi-twitter"></i></a>
                        <a href="#"><i class="bi bi-instagram"></i></a>
                        <a href="#"><i class="bi bi-youtube"></i></a>
                        <a href="#"><i class="bi bi-linkedin"></i></a>
                    </div>
                <?php endif; ?>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <?php if (is_active_sidebar('footer-2')) : ?>
                    <?php dynamic_sidebar('footer-2'); ?>
                <?php else : ?>
                    <h5 class="footer-title">Kategori</h5>
                    <?php
                    $categories = get_categories(array(
                        'orderby' => 'count',
                        'order'   => 'DESC',
                        'number'  => 5
                    ));
                    if ($categories) :
                        ?>
                        <ul class="list-unstyled">
                            <?php foreach ($categories as $category) : ?>
                                <li><a href="<?php echo esc_url(get_category_link($category->term_id)); ?>"><?php echo esc_html($category->name); ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                <?php endif; ?>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <?php if (is_active_sidebar('footer-3')) : ?>
                    <?php dynamic_sidebar('footer-3'); ?>
                <?php else : ?>
                    <h5 class="footer-title">Halaman</h5>
                    <ul class="list-unstyled">
                        <li><a href="<?php echo esc_url(home_url('/')); ?>">Beranda</a></li>
                        <li><a href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>">Semua Artikel</a></li>
                        <li><a href="#">Penulis</a></li>
                        <li><a href="#">Tentang Kami</a></li>
                        <li><a href="#">Sitemap</a></li>
                    </ul>
                <?php endif; ?>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <?php if (is_active_sidebar('footer-4')) : ?>
                    <?php dynamic_sidebar('footer-4'); ?>
                <?php else : ?>
                    <h5 class="footer-title">Kontak</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="bi bi-envelope me-2"></i> info@<?php echo str_replace('www.', '', $_SERVER['HTTP_HOST']); ?></li>
                        <li class="mb-2"><i class="bi bi-phone me-2"></i> +62 123 456 789</li>
                        <li class="mb-2"><i class="bi bi-geo-alt me-2"></i> Jakarta, Indonesia</li>
                        <li><i class="bi bi-clock me-2"></i> Mon - Fri, 9AM - 6PM</li>
                    </ul>
                <?php endif; ?>
            </div>
        </div>

        <!-- Copyright -->
        <hr class="my-4">
        <div class="row">
            <div class="col-12 text-center">
                <p class="text-muted mb-0">
                    &copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. All rights reserved. |
                    <a href="#" class="text-muted">Privacy Policy</a> |
                    <a href="#" class="text-muted">Terms of Service</a>
                </p>
            </div>
        </div>
    </div>
</footer>

</div> <!-- End main-content -->

<?php wp_footer(); ?>

<script>
    // Dark Mode Toggle
    const darkModeToggle = document.getElementById('darkModeToggle');
    const darkModeToggleMobile = document.getElementById('darkModeToggleMobile');
    const html = document.documentElement;

    // Check for saved theme preference
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme) {
        html.setAttribute('data-bs-theme', savedTheme);
        updateToggleIcon(savedTheme);
    }

    function toggleDarkMode() {
        const currentTheme = html.getAttribute('data-bs-theme');
        const newTheme = currentTheme === 'dark' ? 'light' : 'dark';

        html.setAttribute('data-bs-theme', newTheme);
        localStorage.setItem('theme', newTheme);
        updateToggleIcon(newTheme);
    }

    // Add null checks for dark mode toggles
    if (darkModeToggle) {
        darkModeToggle.addEventListener('click', toggleDarkMode);
    }
    if (darkModeToggleMobile) {
        darkModeToggleMobile.addEventListener('click', toggleDarkMode);
    }

    function updateToggleIcon(theme) {
        if (darkModeToggle) {
            const iconDesktop = darkModeToggle.querySelector('i');
            if (iconDesktop) {
                iconDesktop.className = theme === 'dark' ? 'bi bi-sun-fill' : 'bi bi-moon-fill';
            }
        }

        if (darkModeToggleMobile) {
            const iconMobile = darkModeToggleMobile.querySelector('i');
            if (iconMobile) {
                iconMobile.className = theme === 'dark' ? 'bi bi-sun-fill' : 'bi bi-moon-fill';
            }
        }
    }

    // Dynamic Ads Height Adjustment
    function adjustAdsHeight() {
        const stickyAds = document.getElementById('stickyAds');
        const adsSpacer = document.getElementById('adsSpacer');

        if (stickyAds && adsSpacer) {
            // Get actual ads height
            const adsHeight = stickyAds.offsetHeight;

            // Update spacer height to match ads height
            adsSpacer.style.height = adsHeight + 'px';

            // Update responsive breakpoints
            if (window.innerWidth <= 768) {
                // Mobile: minimum 250px
                const mobileHeight = Math.max(adsHeight, 250);
                adsSpacer.style.height = mobileHeight + 'px';
            }
        }
    }

    // Sticky Ads - Pure Parallax Effect (No close functionality needed)

    // Featured Posts Mobile Carousel - Simple approach
    function initMobileCarousel() {
        const featuredPosts = document.getElementById('featuredPosts');
        if (!featuredPosts) return;

        if (window.innerWidth <= 768) {
            // Add carousel classes and controls for mobile
            featuredPosts.classList.add('carousel', 'slide', 'carousel-active');
            featuredPosts.setAttribute('data-bs-ride', 'carousel');
            featuredPosts.setAttribute('id', 'featuredCarousel');

            // Add carousel controls if not exist
            if (!featuredPosts.querySelector('.carousel-control-prev')) {
                featuredPosts.innerHTML += `
                <button class="carousel-control-prev" type="button" data-bs-target="#featuredCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#featuredCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </button>
            `;
            }
        } else {
            // Remove carousel classes for desktop/tablet
            featuredPosts.classList.remove('carousel', 'slide', 'carousel-active');
            featuredPosts.removeAttribute('data-bs-ride');

            // Remove carousel controls
            const controls = featuredPosts.querySelectorAll('.carousel-control-prev, .carousel-control-next');
            controls.forEach(control => control.remove());
        }
    }

    // Initialize on load and resize with delay to ensure DOM is loaded
    document.addEventListener('DOMContentLoaded', function() {
        adjustAdsHeight();
        initMobileCarousel();
    });

    window.addEventListener('resize', function() {
        adjustAdsHeight();
        initMobileCarousel();
    });

    // Also adjust height when ads content might change
    window.addEventListener('load', adjustAdsHeight);
</script>

</body>
</html>