<?php
/**
 * The template for displaying comments
 */

if (!defined('ABSPATH')) {
    exit;
}

if (post_password_required()) {
    return;
}
?>

<div id="comments" class="comments-area">
    <?php if (have_comments()) : ?>
        <h3 class="comments-title">
            <i class="bi bi-chat-left-text me-2"></i>
            <?php
            $comment_count = get_comments_number();
            if ($comment_count == 1) {
                echo '1 Komentar';
            } else {
                echo $comment_count . ' Komentar';
            }
            ?>
        </h3>

        <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : ?>
            <nav class="comment-navigation" role="navigation">
                <div class="nav-previous">
                    <?php previous_comments_link('<i class="bi bi-chevron-left"></i> Komentar Sebelumnya'); ?>
                </div>
                <div class="nav-next">
                    <?php next_comments_link('Komentar Berikutnya <i class="bi bi-chevron-right"></i>'); ?>
                </div>
            </nav>
        <?php endif; ?>

        <ol class="comment-list">
            <?php
            wp_list_comments(array(
                'style'      => 'ol',
                'short_ping' => true,
                'callback'   => 'blogsemantic_comment_callback',
            ));
            ?>
        </ol>

        <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : ?>
            <nav class="comment-navigation" role="navigation">
                <div class="nav-previous">
                    <?php previous_comments_link('<i class="bi bi-chevron-left"></i> Komentar Sebelumnya'); ?>
                </div>
                <div class="nav-next">
                    <?php next_comments_link('Komentar Berikutnya <i class="bi bi-chevron-right"></i>'); ?>
                </div>
            </nav>
        <?php endif; ?>

    <?php endif; ?>

    <?php if (!comments_open() && get_comments_number() && post_type_supports(get_post_type(), 'comments')) : ?>
        <div class="no-comments alert alert-info">
            <i class="bi bi-lock me-2"></i>
            <?php _e('Comments are closed.', 'blogsemantic'); ?>
        </div>
    <?php endif; ?>

    <?php
    // Custom comment form
    blogsemantic_comment_form();
    ?>
</div>