<?php
/*
Plugin Name: AI Pet Personality Quiz
Description: Discovering your pet's personality using ChatGPT
Version: 1.0
Author: createIT
Author URI: https://www.createit.com
*/

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

require_once __DIR__ . '/vendor/autoload.php';
require_once( plugin_dir_path( __FILE__ ) . '/vendor/woocommerce/action-scheduler/action-scheduler.php' );


define('AIPETPERSONALITY_ANIMAL','dog');

$ai_pet_config = [
    'header_img_base64' => 'data:image/jpeg;base64,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',
    'header' => 'AI Personality Quiz for Your Pet',
    'subheader' => "Powered by advanced AI, our plugin offers insights into your pet's character traits based on a series of intuitive questions",
    'introduction' => "Answer the following questions to get insights into your pet's personality!",
    'submit_text' => 'Get Personality Profile',
    'share_cta' => "Loved finding out about your pet's unique personality? Share the fun and challenge your friends to take the quiz too!",
    'share_text' => "Ever wondered what your pet's personality might be? 🐶🐱 Try out this fun AI-powered quiz and let me know your results! #AIPetPersonalityQuiz",
    'animals' => [
        'dog' => [
            'questions' => [
                [
                    "text" => "How does your pet react when guests arrive at your home?",
                    "answers" => [
                        "a" => "Jumps and wags tail excitedly.",
                        "b" => "Barks or growls defensively.",
                        "c" => "Stays calm and sniffs them.",
                        "d" => "Hides or avoids interaction."
                    ],
                    "points" => ["a" => 2, "b" => 1, "c" => 0, "d" => -1]
                ],
                [
                    "text" => "What's your dog's behavior during playtime?",
                    "answers" => [
                        "a" => "Energetic and always fetching the toy.",
                        "b" => "Prefers tug-of-war or rougher play.",
                        "c" => "Plays for a bit, then relaxes.",
                        "d" => "Mostly avoids play, watches from a distance."
                    ],
                    "points" => ["a" => 2, "b" => 1, "c" => 0, "d" => -1]
                ],
                [
                    "text" => "How does your dog react to a loud noise (e.g., fireworks, thunder)?",
                    "answers" => [
                        "a" => "Curious and unaffected.",
                        "b" => "Barks or tries to find the source.",
                        "c" => "A little startled but calms down quickly.",
                        "d" => "Panics and tries to hide."
                    ],
                    "points" => ["a" => 2, "b" => 1, "c" => 0, "d" => -1]
                ],
                [
                    "text" => "Your dog's reaction when encountering another dog on a walk is to...",
                    "answers" => [
                        "a" => "Approach and play.",
                        "b" => "Bark or show dominance.",
                        "c" => "Sniff and remain neutral.",
                        "d" => "Avoid or show submissive behavior."
                    ],
                    "points" => ["a" => 2, "b" => 1, "c" => 0, "d" => -1]
                ],
                [
                    "text" => "During meal times, your dog...",
                    "answers" => [
                        "a" => "Eats eagerly and finishes quickly.",
                        "b" => "Guards food or eats aggressively.",
                        "c" => "Eats leisurely, sometimes leaving food.",
                        "d" => "Needs encouragement or isn't interested in food."
                    ],
                    "points" => ["a" => 2, "b" => 1, "c" => 0, "d" => -1]
                ],
            ],
            'score_ranges' => [
                '-5 to -3' => 'Couch Potato Pooch',
                '-2 to 2' => 'Easy-Going Buddy',
                '3 to 5' => 'Energetic Explorer',
                '6 to 10' => 'Alpha Leader'
            ]
        ],
    ],

];




// Possible values: 'daily', 'weekly', 'monthly'
define('AIPETPERSONALITY_RECURRENCE', 'daily');

// Define the hour and minute for the scheduled event. Adjust as needed.
// Possible values: HOUR: 0-23, MINUTE: 0-59
define('AIPETPERSONALITY_SCHEDULED_HOUR', 1);
define('AIPETPERSONALITY_SCHEDULED_MINUTE', 30);


function aipetpersonality_generatePrompt($score, $animal) {
    $rangeDescriptions = [];

    global $ai_pet_config;
    foreach ($ai_pet_config['animals'][$animal]['score_ranges'] as $range => $desc) {
        $rangeDescriptions[] = "Score {$range}: {$desc} ,";
    }

    $rangeText = implode("\n", $rangeDescriptions);

    return <<<PROMPT
Based on the following personality range grouping:
{$rangeText} .

Describe {$animal} personality for {$score}, following the structure below:

|   **Personality Name Here**   |
| ------------- |
| **Trait**     | **Description** |
| Attitude      | [Description of the attitude trait] |
| Adaptability  | [Description of the adaptability trait] |
| Trainability | [Description of the trainability trait] |
| Socialization | [Description of the socialization trait] |
| Energy Level | [Description of the energy level trait] |
| Playfulness | [Description of the playfulness trait] |
| Fashion Sense | [Description of the fashion sense trait] |
| Sleeping Style | [Description of the sleeping style trait] |
| Favorite Toy | [Description of the favorite toy trait] |
| Secret Talent | [Description of the secret talent trait] |
| Mood Swings | [Description of the mood swings trait] |
| Ideal Owner | [Description of the ideal owner for this personality type] |

Replace the placeholder texts within the brackets with relevant information for the specified score range.

PROMPT;
}

function aipetpersonality_register_post_type() {
    $args = array(
        'public' => true,
        'label' => 'AI Pet personalities',
        'supports' => array('title', 'editor', 'custom-fields')
    );
    register_post_type('aipetpersonality', $args);
}
add_action('init', 'aipetpersonality_register_post_type');


function aipetpersonality_form_shortcode() {
    global $ai_pet_config;


    ob_start();
    ?>

    <div id="aipetpersonality-sharing-links" class="position-fixed bottom-0 start-0 p-3 bg-white border d-flex flex-column flex-md-row gap-2 d-none"></div>

    <div class="row justify-content-center">
        <div class="col-sm-10 col-12">
            <!-- Header Section -->
            <div class="header text-center my-1">
                <img class="header--img" src="<?php echo esc_html($ai_pet_config['header_img_base64']) ?>" alt="" />
                <h1 class="h3"><?php echo esc_html($ai_pet_config['header']) ?></h1>
                <p><?php echo esc_html($ai_pet_config['subheader']) ?></p>
            </div>

            <div class="result-section">
                <form action="#" method="post" id="aipetpersonality-form" class="text-left">
                    <div id="openai-badge" class="d-inline-block mx-3 badge bg-primary">OpenAI API inside</div>
                    <p><?php echo esc_html($ai_pet_config['introduction']) ?></p>
                    <?php
                    global $ai_pet_config;
                    $questions = $ai_pet_config['animals'][AIPETPERSONALITY_ANIMAL]['questions'];
                    ?>
                    <?php foreach ($questions as $index => $question): ?>
                        <div class="row align-items-center mb-3">
                            <div class="col-12"> <!-- Displaying the question -->
                                <label class="form-label mb-0"><?php echo esc_html($index +1 . '. ' . $question['text']); ?></label>
                            </div>
                            <div class="col"> <!-- Displaying the answer options using select dropdown -->
                                <select name="question_<?php echo esc_attr($index); ?>" class="form-control form-select" required>
                                    <option value="">Select an answer...</option>  <!-- Empty option -->
                                    <?php foreach ($question['answers'] as $key => $answer): ?>
                                        <option value="<?php echo esc_attr($key); ?>"><?php echo esc_html($key) .') ' ?><?php echo esc_html($answer); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    <?php endforeach; ?>

                    <div class="col-12 col-md-auto mt-2 mt-md-0"> <!-- Submit button -->
                        <input type="submit" value="<?php echo esc_html($ai_pet_config['submit_text']) ?>" class="btn btn-success w-100 w-md-auto">
                    </div>
                </form>

                <div id="aipetpersonality-result" class="table-formatted"></div>
            </div>
        </div>
    </div>
    <!-- / row -->


    <?php
    return ob_get_clean();
}
add_shortcode('aipetpersonality_form', 'aipetpersonality_form_shortcode');



function aipetpersonality_enqueue_scripts() {
    wp_enqueue_script('aipetpersonality-ajax', plugins_url('ajax.js', __FILE__), array('jquery'), '1.0.0', true);

    // Pass ajax_url to script.js
    wp_localize_script('aipetpersonality-ajax', 'frontendajax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));

    wp_enqueue_style('aipetpersonality-styles', plugins_url('styles.css', __FILE__));


    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css');

    wp_enqueue_style(
        'bootstrap-css', // A unique handle for the stylesheet
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css', // The source of the stylesheet
        array(), // An array of registered stylesheets this stylesheet depends on, if any
        '5.3.2', // Version number
        'all' // Media type. Can be 'all', 'print', 'screen', 'speech', etc.
    );



}
add_action('wp_enqueue_scripts', 'aipetpersonality_enqueue_scripts');

function add_bootstrap_sri( $html, $handle ) {
    if ( 'bootstrap-css' === $handle ) {
        $html = str_replace(
            "media='all'",
            "media='all' integrity='sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN' crossorigin='anonymous'",
            $html
        );
    }
    return $html;
}
add_filter( 'style_loader_tag', 'add_bootstrap_sri', 10, 2 );

function determineScoreRange($score) {
    global $ai_pet_config;
    foreach ($ai_pet_config['animals'][AIPETPERSONALITY_ANIMAL]['score_ranges'] as $range => $desc) {
        $bounds = explode(" to ", $range);
        if ($score >= (int)$bounds[0] && $score <= (int)$bounds[1]) {
            return $range;
        }
    }
    return null;
}

function fetch_pet_personality() {
    global $ai_pet_config;

    $response = array(
        'description' => '',
        'share_text' => '',
        'share_cta' => '',
    );

    // Assume you pass the animal type and score range via POST
    $animal = AIPETPERSONALITY_ANIMAL;
    $score_range = isset($_POST['score_range']) ? sanitize_text_field($_POST['score_range']) : null;
    $parsedown = new Parsedown();
    $description = '';

    $answers = isset($_POST['answers']) ? $_POST['answers'] : null;

    $totalScore = 0;

    if ($answers && is_array($answers)) {
        foreach ($answers as $index => $answer_key) {
            $totalScore += $ai_pet_config['animals'][AIPETPERSONALITY_ANIMAL]['questions'][$index]['points'][$answer_key];
        }
    }

    $score_range = determineScoreRange($totalScore);

    if ($animal && $score_range) {
        $post_title = "{$animal} {$score_range}";

        $existing_posts = get_posts(array(
            'post_type' => 'aipetpersonality',
            'title' => $post_title
        ));

        if (!empty($existing_posts)) {
            $markdown_content = $existing_posts[0]->post_content;
            $response['description'] = $parsedown->text($markdown_content);
            $response['share_text'] = $ai_pet_config['share_text'];
            $response['share_cta'] = $ai_pet_config['share_cta'];
        } else {
            $response['description'] = "No personality profile found for {$animal} with score range {$score_range}.";
        }
    }

    header('Content-Type: application/json');
    echo json_encode($response);
    wp_die(); // This is required to terminate immediately and return a proper response.
}
add_action('wp_ajax_fetch_pet_personality', 'fetch_pet_personality'); // If user is logged in
add_action('wp_ajax_nopriv_fetch_pet_personality', 'fetch_pet_personality'); // If user is not logged in




function aipetpersonality_get_description($animal, $score_range) {
    $yourApiKey = get_option('openai_api_key');

    if(empty($yourApiKey)){
        wp_die("Error: OpenAI API key is not set in the settings.");
    }

    // Assuming you've included the necessary library for OpenAI.
    $client = OpenAI::client($yourApiKey);

    // Generate the prompt using the animal and score range

    $final_prompt = aipetpersonality_generatePrompt($score_range, $animal);

    try {
        $response = $client->chat()->create([
            'model' => 'gpt-4', // or 'gpt-3.5-turbo'
            'messages' => [
                ['role' => 'user', 'content' => $final_prompt],
            ],
            'max_tokens' => 3000,
            'temperature' => 1
        ]);

        $description = '';

        foreach ($response->choices as $result) {
            if (isset($result->message->content)) {
                $description = $result->message->content;
            }
        }

        return $description;

    } catch (Exception $e) {
        ct_debug_log("Error fetching description from OpenAI: " . $e->getMessage());
    }

    return false;
}

function ct_debug_log($obj){
    $debug = var_export($obj, true);
    error_log($debug);
}




function aipetpersonality_schedule_events() {
    if (!as_has_scheduled_action('aipetpersonality_daily_generate')) {

        // Get all existing post titles to check for duplicates
        $existing_posts = get_posts(array(
            'post_type' => 'aipetpersonality',
            'numberposts' => -1,
            'fields' => 'post_title'
        ));
        global $ai_pet_config;

        foreach ($ai_pet_config['animals'] as $animal => $data) {
            foreach ($data['score_ranges'] as $range => $desc) {
                $title = "{$animal} {$range}";

                // If the title does not exist, schedule a job to generate it
                if (!in_array($title, $existing_posts)) {
                    $params = array(array('animal' => $animal, 'score_range' => $range));
                    as_schedule_single_action(time() + DAY_IN_SECONDS, 'aipetpersonality_daily_generate', $params);
                }
            }
        }
    }
}

add_action('wp', 'aipetpersonality_schedule_events');




/**
 * Get the timestamp for the next occurrence based on the specified recurrence interval.
 *
 * Possible values for AIPETPERSONALITY_RECURRENCE: 'daily', 'weekly', 'monthly'
 *
 * @return int Timestamp of the next occurrence.
 */
function get_next_occurrence_timestamp() {
    $current_time = current_time('timestamp');

    switch (AIPETPERSONALITY_RECURRENCE) {
        case 'daily':
            $time_string = 'tomorrow ' . AIPETPERSONALITY_SCHEDULED_HOUR . ':' . AIPETPERSONALITY_SCHEDULED_MINUTE . ' am';
            break;
        case 'weekly':
            // Get the next occurrence of the specified time, one week from now
            $time_string = '+1 week ' . AIPETPERSONALITY_SCHEDULED_HOUR . ':' . AIPETPERSONALITY_SCHEDULED_MINUTE . ' am';
            break;
        case 'monthly':
            // Get the next occurrence of the specified time, one month from now
            $time_string = '+1 month ' . AIPETPERSONALITY_SCHEDULED_HOUR . ':' . AIPETPERSONALITY_SCHEDULED_MINUTE . ' am';
            break;
        default:
            // Default to daily if the recurrence value is not recognized
            $time_string = '+1 year ' . AIPETPERSONALITY_SCHEDULED_HOUR . ':' . AIPETPERSONALITY_SCHEDULED_MINUTE . ' am';
            break;
    }

    $target_time = strtotime($time_string, $current_time);
    return $target_time;
}



function aipetpersonality_daily_generate_callback($item) {

    if (!isset($item['animal']) || !isset($item['score_range'])) {
        error_log("Error in aipetpersonality_daily_generate_callback: animal or score_range parameter is missing.");
        return;
    }

    $animal = sanitize_text_field($item['animal']);
    $score_range = sanitize_text_field($item['score_range']);
    $title = "{$animal} {$score_range}";

    // Check if a post for this animal and score range already exists
    $existing_posts = get_posts(array(
        'post_type' => 'aipetpersonality',
        'title' => $title,
        'numberposts' => 1
    ));

    // If there's no existing post for this animal and score range, generate a new description
    if (count($existing_posts) == 0) {
        // Generate a description for the animal and score range
        $description = aipetpersonality_get_description($animal, $score_range);

        if (!$description) {
            return;
        }

        // Save the description as a new post
        wp_insert_post(array(
            'post_title' => $title,
            'post_content' => $description,
            'post_type' => 'aipetpersonality',
            'post_status' => 'publish'
        ));
    }
}
add_action('aipetpersonality_daily_generate', 'aipetpersonality_daily_generate_callback');


/**
 * admin option page
 */


function aipetpersonality_admin_menu() {
    add_options_page(
        'AI Pet Personality Quiz Settings',
        'AI Pet Personality Quiz',
        'manage_options',
        'wp-aipetpersonality',
        'aipetpersonality_settings_page'
    );
}
add_action('admin_menu', 'aipetpersonality_admin_menu');


function aipetpersonality_settings_page() {
    ?>
    <div class="wrap">
        <h1>AI Pet Personality Quiz Settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('aipetpersonality_settings');
            do_settings_sections('wp-aipetpersonality');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

function aipetpersonality_register_settings() {
    register_setting('aipetpersonality_settings', 'openai_api_key');

    add_settings_section(
        'aipetpersonality_api_settings',
        'API Settings',
        'aipetpersonality_api_settings_callback',
        'wp-aipetpersonality'
    );

    add_settings_field(
        'openai_api_key',
        'OpenAI API Key',
        'aipetpersonality_api_key_callback',
        'wp-aipetpersonality',
        'aipetpersonality_api_settings'
    );
}
add_action('admin_init', 'aipetpersonality_register_settings');


function aipetpersonality_api_settings_callback() {
    echo '<p>Enter your OpenAI API key below:</p>';
}

function aipetpersonality_api_key_callback() {
    $openai_api_key = get_option('openai_api_key');
    echo "<input type='text' name='openai_api_key' value='{$openai_api_key}' size='50'>";
}


