<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- Sticky Ads Overflow -->
<div class="sticky-ads" id="stickyAds" style="background: #adb5bd; color: #343a40;">
    <div class="text-center">
        <div style="font-weight: 500;">Ads 1200 X 325 px</div>
    </div>
</div>

<!-- Dynamic Ads Spacer -->
<div class="ads-spacer" id="adsSpacer"></div>

<!-- Search Modal -->
<div class="modal fade" id="searchModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body p-0">
                <form class="p-4" role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
                    <div class="mb-0">
                        <input type="text" class="form-control form-control-lg border-0"
                               name="s" value="<?php echo get_search_query(); ?>"
                               placeholder="Ketik kata kunci pencarian..." autofocus>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Offcanvas Menu -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasMenu">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title">Menu</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
        <?php if (has_nav_menu('primary')) : ?>
            <?php wp_nav_menu(array(
                'theme_location' => 'primary',
                'menu_class'     => 'nav flex-column',
                'container'      => 'nav',
                'walker'         => new WP_Bootstrap_Navwalker_Mobile(),
                'fallback_cb'    => false,
            )); ?>
        <?php else : ?>
            <nav class="nav flex-column">
                <a class="nav-link" href="<?php echo esc_url(home_url('/')); ?>"><i class="bi bi-house"></i> Beranda</a>
                <a class="nav-link" href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>"><i class="bi bi-newspaper"></i> Artikel</a>
                <a class="nav-link" href="#"><i class="bi bi-tags"></i> Kategori</a>
                <a class="nav-link" href="#"><i class="bi bi-person"></i> Tentang</a>
                <a class="nav-link" href="#"><i class="bi bi-envelope"></i> Kontak</a>
            </nav>
        <?php endif; ?>
    </div>
</div>

<!-- Main Content Wrapper -->
<div class="main-content">

    <!-- Navbar (Inside main-content for sticky behavior after ads) -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <?php if (has_custom_logo()) : ?>
                <?php the_custom_logo(); ?>
            <?php else : ?>
                <a class="navbar-brand fw-bold" href="<?php echo esc_url(home_url('/')); ?>">
                    <i class="bi bi-journal-text"></i> <?php bloginfo('name'); ?>
                </a>
            <?php endif; ?>

            <!-- Desktop & Tablet Menu -->
            <div class="d-none d-lg-flex align-items-center">
                <?php if (has_nav_menu('primary')) : ?>
                    <?php wp_nav_menu(array(
                        'theme_location' => 'primary',
                        'menu_class'     => 'navbar-nav me-4',
                        'container'      => 'nav',
                        'walker'         => new WP_Bootstrap_Navwalker(),
                        'fallback_cb'    => false,
                    )); ?>
                <?php else : ?>
                    <nav class="navbar-nav me-4">
                        <a class="nav-link" href="<?php echo esc_url(home_url('/')); ?>">Beranda</a>
                        <a class="nav-link" href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>">Artikel</a>
                        <a class="nav-link" href="#">Kategori</a>
                        <a class="nav-link" href="#">Tentang</a>
                        <a class="nav-link" href="#">Kontak</a>
                    </nav>
                <?php endif; ?>

                <button class="btn-clean me-2" id="darkModeToggle">
                    <i class="bi bi-moon-fill"></i>
                </button>

                <button class="btn-clean" data-bs-toggle="modal" data-bs-target="#searchModal">
                    <i class="bi bi-search"></i>
                </button>
            </div>

            <!-- Mobile Menu -->
            <div class="d-flex d-lg-none align-items-center">
                <button class="btn-clean me-2" id="darkModeToggleMobile">
                    <i class="bi bi-moon-fill"></i>
                </button>

                <button class="btn-clean me-2" data-bs-toggle="modal" data-bs-target="#searchModal">
                    <i class="bi bi-search"></i>
                </button>

                <button class="btn-clean" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasMenu">
                    <i class="bi bi-list"></i>
                </button>
            </div>
        </div>
    </nav>