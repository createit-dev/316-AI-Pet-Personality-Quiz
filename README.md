# AI Pet Personality Quiz Plugin

## Description

Discovering your pet's personality has never been this fun! The AI Pet Personality Quiz is a WordPress plugin that uses advanced AI to offer insights into your pet's character traits based on a series of intuitive questions. Simply answer the questions about your pet, and our AI will generate a unique personality profile just for them!

![AI Personality Quiz for Your Cat.gif](img%2FAI%20Personality%20Quiz%20for%20Your%20Cat.gif)

## Supported Pets 🐾

The AI Pet Personality Quiz currently supports the following pets:

- Dogs 🐶
- Cats 🐱
- Hamsters 🐹
- Horses 🐴
- Rabbits 🐰

You can easily customize the quiz for each of these pets using the `$ai_quiz_config` array in the plugin code. Additionally, you're free to expand the list of supported pets by adding new configurations to the array.

## Features

- Powered by OpenAI's GPT-4 model.
- Intuitive questions that cater to a variety of pets.
- Generates a detailed personality profile for your pet.
- Easy-to-use shortcode integration for WordPress.
- Includes stylish and responsive design out of the box.
- Personality descriptions are scheduled to generate in the background (action-scheduler)
- Custom post type for managing AI-generated pet personalities.

## Utilizing GPT-4's Advanced AI

Our plugin leverages the power and efficiency of OpenAI's GPT-4 model, one of the most advanced language models available. GPT-4's capabilities enable us to generate detailed and insightful pet personality profiles based on score ranges.

One of the standout features of our plugin is its cost efficiency. Once the pet personality profiles are generated using GPT-4, the plugin stores these profiles for future use. This means that after the initial generation, the plugin does not make any more connections to the OpenAI API. As a result, there are zero ongoing costs associated with API calls, providing a cost-effective solution for website owners without compromising on the quality of the profiles provided to the users.

## Installation

1. Download the plugin files
2. Upload the plugin files to : `/wp-content/plugins/AI-Pet-Personality-Quiz/` and run the terminal or command prompt.
3. Run `composer install` to install the required dependencies.
5. Go to your WordPress dashboard and navigate to **Plugins**.
6. Activate the plugin once the installation is complete.
7. Navigate to **Settings > AI Pet Personality Quiz** to configure the OpenAI API key.

## Configuration

The quiz is driven by a configuration object named `$ai_quiz_config`. Here's a brief structure:

```php
$ai_quiz_config = [
    'quizzes' => [
        'type_of_pet' => [
            'quiz_about' => 'type_of_pet',
            'header' => 'Quiz Header',
            'subheader' => 'Subheader',
            'introduction' => 'Introduction Text',
            'submit_text' => 'Submit Button Text',
            'questions' => [
                [
                    "text" => "Question?",
                    "answers" => [
                        "a" => "Option A",
                        // ... other options ...
                    ],
                    "points" => ["a" => 1, //... points for other options ...]
                ],
                // ... other questions ...
            ],
            'score_ranges' => [
                'score_range' => 'Personality Type'
            ]
        ],
        // ... other quizzes ...
    ],
];
```

## Usage

1. Add the shortcode `[aipetpersonality_form quiz_topic="cat"]` to any post or page where you want the quiz to appear.
2. Visit the post or page to take the quiz and discover your pet's personality!

## Social Media Sharing

After completing the quiz and getting insights into your pet's personality, users have the option to share quiz page url on social media. This feature encourages more users to participate and discover their pets' unique personalities. The sharing text and call-to-action can be customized in the `$ai_quiz_config` array for a personalized touch.

Read more on our site: https://www.createit.com/blog/ai-pet-personality-quiz-revealing-your-pets-unique-traits/
