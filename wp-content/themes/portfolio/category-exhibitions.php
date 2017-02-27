<?php get_header(); ?>
    <div class="content-main">


        <div class="content-main-blocks">
            <?php $i = 1; ?>
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

                <div>
                    <a href="<?php the_permalink() ?>"><?php the_post_thumbnail() ?></a>
                    <h1><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h1>

                    <?php $custom_fields = get_post_custom(get_the_ID()); ?>
                    <!-- place, date, ticket -->
                    <?php if ($custom_fields['place'][0]): ?>
                        <p class="ex-place"><?php echo $custom_fields['place'][0] ?></p>
                    <?php endif; ?>
                    <?php if ($custom_fields['date'][0]): ?>
                        <p class="ex-date"><?php echo $custom_fields['date'][0] ?></p>
                    <?php endif; ?>
                    <?php if ($custom_fields['ticket'][0]): ?>
                        <p class="ex-ticket"><?php echo $custom_fields['ticket'][0] ?></p>
                    <?php endif; ?>
                    <!-- place, date, ticket -->

                    <?php the_excerpt() ?>
                    <p><a href="<?php the_permalink() ?>" class="read-more"> Read more</a></p>
                </div>

                <?php
                if ($i == 3) {
                    echo "<div class='clear'></div>";
                    $i = 0;
                }
                $i++;
                ?>

            <?php endwhile; ?>
                <!-- post navigation -->
            <?php else: ?>
                <!-- no posts found -->
            <?php endif; ?>


        </div>


    </div>
<?php get_footer(); ?>