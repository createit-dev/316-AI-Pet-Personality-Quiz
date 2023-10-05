<?php
/*
Template Name: AI Personality Quizzes
*/

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php wp_head(); ?>
    </head>
<body <?php body_class(); ?>>
<?php

$link1 = home_url('/ai-personality-quiz-for-your-dog/');
$link2 = home_url('/ai-personality-quiz-for-your-cat/');
$link3 = home_url('/ai-personality-quiz-for-your-hamster/');
$link4 = home_url('/ai-personality-quiz-for-your-horse/');
$link5 = home_url('/ai-personality-quiz-for-your-rabbit/');

$content = <<<EOD
    <!-- wp:template-part {"slug":"header","tagName":"header"} /-->

    <!-- wp:group {"tagName":"main","style":{"spacing":{"margin":{"top":"var:preset|spacing|50"}}}} -->
    <main class="wp-block-group" style="margin-top:var(--wp--preset--spacing--50)">
        <!-- wp:group {"layout":{"type":"constrained"}} -->
        <div class="wp-block-group">
      
    <section class="container mt-5">
        <div class="text-center mb-5">
            <h1>AI Personality Quizzes</h1>
            <p>Discover your pet's unique personality with our AI-powered quizzes.</p>
        </div>

        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body text-center">
                        <span class="fs-4">🐶</span>
                        <h5 class="card-title mt-2">Dog Personality Quiz</h5>
                        <a href="$link1" class="btn btn-primary">Take the Quiz</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body text-center">
                        <span class="fs-4">🐱</span>
                        <h5 class="card-title mt-2">Cat Personality Quiz</h5>
                        <a href="$link2" class="btn btn-primary">Take the Quiz</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body text-center">
                        <span class="fs-4">🐹</span>
                        <h5 class="card-title mt-2">Hamster Personality Quiz</h5>
                        <a href="$link3" class="btn btn-primary">Take the Quiz</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body text-center">
                        <span class="fs-4">🐴</span>
                        <h5 class="card-title mt-2">Horse Personality Quiz</h5>
                        <a href="$link4" class="btn btn-primary">Take the Quiz</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body text-center">
                        <span class="fs-4">🐰</span>
                        <h5 class="card-title mt-2">Rabbit Personality Quiz</h5>
                        <a href="$link5" class="btn btn-primary">Take the Quiz</a>
                    </div>
                </div>
            </div>

        </div>
    </section>
 
            
        </div>
        <!-- /wp:group -->

        <!-- wp:post-content {"layout":{"type":"constrained"}} /-->
        <!-- wp:template-part {"slug":"comments","tagName":"section"} /-->
    </main>
    <!-- /wp:group -->

    <!-- wp:template-part {"slug":"footer","tagName":"footer"} /-->


EOD;

echo do_blocks($content);

wp_footer();

?>
</body>
</html>
