<div class="sidebar">
    <!-- Ads Widget -->
    <div class="text-center mb-4" style="background: #adb5bd; color: #343a40; padding: 4rem 0; font-weight: 500;">
        Ads 300 X 250 px
    </div>

    <?php if (is_active_sidebar('sidebar-1')) : ?>
        <?php dynamic_sidebar('sidebar-1'); ?>
    <?php else : ?>
        <!-- Popular Posts -->
        <div class="sidebar-widget">
            <h4 class="widget-title">Popular Posts</h4>
            <?php
            $popular_posts = blogsemantic_get_popular_posts(5);
            if ($popular_posts) :
                $counter = 1;
                foreach ($popular_posts as $post) :
                    setup_postdata($post);
                    $views = blogsemantic_get_post_views(get_the_ID());
                    ?>
                    <div class="popular-post-item">
                        <div class="popular-post-number"><?php echo $counter; ?></div>
                        <div class="popular-post-meta">
                            <h6 class="popular-post-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h6>
                            <div class="popular-post-stats">
                                <span><i class="bi bi-eye"></i> <?php echo number_format($views); ?></span>
                                <span><i class="bi bi-calendar3"></i> <?php echo blogsemantic_time_ago(); ?></span>
                            </div>
                        </div>
                    </div>
                    <?php
                    $counter++;
                endforeach;
                wp_reset_postdata();
            else :
                ?>
                <div class="popular-post-item">
                    <div class="popular-post-number">1</div>
                    <div class="popular-post-meta">
                        <h6 class="popular-post-title">JavaScript Modern</h6>
                        <div class="popular-post-stats">
                            <span><i class="bi bi-eye"></i> 1,234</span>
                            <span><i class="bi bi-calendar3"></i> 2 hari lalu</span>
                        </div>
                    </div>
                </div>
                <div class="popular-post-item">
                    <div class="popular-post-number">2</div>
                    <div class="popular-post-meta">
                        <h6 class="popular-post-title">React Hooks Guide</h6>
                        <div class="popular-post-stats">
                            <span><i class="bi bi-eye"></i> 987</span>
                            <span><i class="bi bi-calendar3"></i> 3 hari lalu</span>
                        </div>
                    </div>
                </div>
                <div class="popular-post-item">
                    <div class="popular-post-number">3</div>
                    <div class="popular-post-meta">
                        <h6 class="popular-post-title">CSS Flexbox</h6>
                        <div class="popular-post-stats">
                            <span><i class="bi bi-eye"></i> 756</span>
                            <span><i class="bi bi-calendar3"></i> 4 hari lalu</span>
                        </div>
                    </div>
                </div>
                <div class="popular-post-item">
                    <div class="popular-post-number">4</div>
                    <div class="popular-post-meta">
                        <h6 class="popular-post-title">Node.js Performance</h6>
                        <div class="popular-post-stats">
                            <span><i class="bi bi-eye"></i> 642</span>
                            <span><i class="bi bi-calendar3"></i> 5 hari lalu</span>
                        </div>
                    </div>
                </div>
                <div class="popular-post-item">
                    <div class="popular-post-number">5</div>
                    <div class="popular-post-meta">
                        <h6 class="popular-post-title">Vue.js Components</h6>
                        <div class="popular-post-stats">
                            <span><i class="bi bi-eye"></i> 521</span>
                            <span><i class="bi bi-calendar3"></i> 6 hari lalu</span>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Categories -->
        <div class="sidebar-widget">
            <h4 class="widget-title">Kategori</h4>
            <?php
            $categories = get_categories(array(
                'orderby' => 'count',
                'order'   => 'DESC',
                'number'  => 10,
                'hide_empty' => true
            ));

            if ($categories) :
                ?>
                <div class="category-list">
                    <?php foreach ($categories as $category) : ?>
                        <div class="category-item">
                            <div class="category-name">
                                <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>">
                                    <i class="bi bi-folder me-2"></i><?php echo esc_html($category->name); ?>
                                </a>
                            </div>
                            <span class="category-count"><?php echo $category->count; ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else : ?>
                <div class="category-list">
                    <div class="category-item">
                        <div class="category-name">
                            <a href="#"><i class="bi bi-folder me-2"></i>Web Development</a>
                        </div>
                        <span class="category-count">15</span>
                    </div>
                    <div class="category-item">
                        <div class="category-name">
                            <a href="#"><i class="bi bi-folder me-2"></i>Design</a>
                        </div>
                        <span class="category-count">8</span>
                    </div>
                    <div class="category-item">
                        <div class="category-name">
                            <a href="#"><i class="bi bi-folder me-2"></i>SEO</a>
                        </div>
                        <span class="category-count">12</span>
                    </div>
                    <div class="category-item">
                        <div class="category-name">
                            <a href="#"><i class="bi bi-folder me-2"></i>Security</a>
                        </div>
                        <span class="category-count">6</span>
                    </div>
                    <div class="category-item">
                        <div class="category-name">
                            <a href="#"><i class="bi bi-folder me-2"></i>Tools</a>
                        </div>
                        <span class="category-count">4</span>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Recent Posts Widget -->
        <div class="sidebar-widget">
            <h4 class="widget-title">Recent Posts</h4>
            <?php
            $recent_posts = get_posts(array(
                'numberposts' => 5,
                'post_status' => 'publish'
            ));

            if ($recent_posts) :
                ?>
                <div class="recent-posts-list">
                    <?php foreach ($recent_posts as $post) : ?>
                        <div class="recent-post-item">
                            <div class="recent-post-thumbnail">
                                <?php if (has_post_thumbnail($post->ID)) : ?>
                                    <img src="<?php echo get_the_post_thumbnail_url($post->ID, 'thumbnail'); ?>"
                                         alt="<?php echo get_the_title($post->ID); ?>">
                                <?php else : ?>
                                    <i class="bi bi-file-text" style="color: #6c757d;"></i>
                                <?php endif; ?>
                            </div>
                            <div class="recent-post-meta">
                                <h6 class="recent-post-title">
                                    <a href="<?php echo get_permalink($post->ID); ?>">
                                        <?php echo get_the_title($post->ID); ?>
                                    </a>
                                </h6>
                                <div class="recent-post-date">
                                    <i class="bi bi-calendar3 me-1"></i><?php echo blogsemantic_time_ago($post->ID); ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Tags Widget -->
        <div class="sidebar-widget">
            <h4 class="widget-title">Tags</h4>
            <?php
            $tags = get_tags(array(
                'orderby' => 'count',
                'order'   => 'DESC',
                'number'  => 15
            ));

            if ($tags) :
                ?>
                <div class="d-flex flex-wrap gap-2">
                    <?php foreach ($tags as $tag) : ?>
                        <a href="<?php echo get_tag_link($tag->term_id); ?>"
                           class="badge bg-secondary text-decoration-none">
                            <?php echo esc_html($tag->name); ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php else : ?>
                <div class="d-flex flex-wrap gap-2">
                    <span class="badge bg-secondary">HTML</span>
                    <span class="badge bg-secondary">CSS</span>
                    <span class="badge bg-secondary">JavaScript</span>
                    <span class="badge bg-secondary">PHP</span>
                    <span class="badge bg-secondary">WordPress</span>
                    <span class="badge bg-secondary">Bootstrap</span>
                    <span class="badge bg-secondary">React</span>
                    <span class="badge bg-secondary">SEO</span>
                </div>
            <?php endif; ?>
        </div>

        <!-- Archives Widget -->
        <div class="sidebar-widget">
            <h4 class="widget-title">Archives</h4>
            <div class="archive-list">
                <?php
                $archives = wp_get_archives(array(
                    'type'   => 'monthly',
                    'limit'  => 6,
                    'format' => 'option',
                    'echo'   => false
                ));

                if ($archives) :
                    // Parse the archives output to create custom format
                    $archive_list = explode('</option>', $archives);
                    foreach ($archive_list as $archive_item) :
                        if (trim($archive_item)) :
                            // Extract URL and text from option
                            preg_match('/value="([^"]*)"[^>]*>([^<]*)/', $archive_item, $matches);
                            if (isset($matches[1]) && isset($matches[2])) :
                                $url = $matches[1];
                                $text_parts = explode('(', $matches[2]);
                                $month_year = trim($text_parts[0]);
                                $count = isset($text_parts[1]) ? '(' . $text_parts[1] : '';
                                ?>
                                <div class="archive-item">
                                    <a href="<?php echo esc_url($url); ?>">
                                        <i class="bi bi-calendar3 me-2"></i><?php echo esc_html($month_year); ?>
                                    </a>
                                    <?php if ($count) : ?>
                                        <span class="archive-count"><?php echo str_replace(')', '', $count); ?></span>
                                    <?php endif; ?>
                                </div>
                            <?php
                            endif;
                        endif;
                    endforeach;
                else :
                    ?>
                    <div class="archive-item">
                        <a href="#"><i class="bi bi-calendar3 me-2"></i>December 2024</a>
                        <span class="archive-count">12</span>
                    </div>
                    <div class="archive-item">
                        <a href="#"><i class="bi bi-calendar3 me-2"></i>November 2024</a>
                        <span class="archive-count">8</span>
                    </div>
                    <div class="archive-item">
                        <a href="#"><i class="bi bi-calendar3 me-2"></i>October 2024</a>
                        <span class="archive-count">15</span>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
</div>