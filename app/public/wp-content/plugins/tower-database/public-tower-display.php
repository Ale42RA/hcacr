<?php
function tower_manager_display_towers() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'towers';

    // Fetch all towers from the database
    $towers = $wpdb->get_results("SELECT * FROM $table_name");

    // If no towers found, return a message
    if (empty($towers)) {
        return "<p>No towers found.</p>";
    }

    // Start output buffering to capture HTML output
    ob_start();

    // Inject the CSS directly
    ?>
    <style>
    .tower-cards-container {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        justify-content: flex-start;
    }
    .tower-card {
        background-color: #fa0092;
        border: 1px solid #ddd;
        border-radius: 8px;
        width: 100%;
        max-width: 23%; /* Ensure max 4 cards per row */
        padding: 15px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        box-sizing: border-box;
        text-align: center; /* Center content */
    }
    .tower-card-header h2 {
        margin: 0;
        font-size: 1.5em;
        color: #333;
        text-align: center;
    }
    .tower-card-body p {
        font-size: 1.2em;
        text-align: center;
        margin-top: 10px;
        color: #555;
    }
    .tower-card img {
        max-width: 100%;
        height: auto;
        display: block;
        margin: 0 auto; /* Center the image */
        border-radius: 8px;
    }

    /* Ensure responsiveness */
    @media (max-width: 1200px) {
        .tower-card {
            max-width: 31%; /* 3 cards per row on medium screens */
        }
    }
    @media (max-width: 900px) {
        .tower-card {
            max-width: 48%; /* 2 cards per row on smaller screens */
        }
    }
    @media (max-width: 600px) {
        .tower-card {
            max-width: 100%; /* 1 card per row on very small screens */
        }
    }
    </style>
    
    <div class="tower-cards-container">
        <?php foreach ($towers as $tower): ?>
            <div class="tower-card">
                <div class="tower-card-header">
                    <h2><?php echo esc_html($tower->Town  . " , " .$tower->Dedication); ?></h2>
                </div>
                <div class="tower-card-body">
                    <img src="<?php echo esc_url( wp_upload_dir()['baseurl'] . '/tower/' . $tower->Photograph ); ?>" alt="<?php echo esc_attr($tower->Photograph); ?>">
                    <p>Bells: <?php echo esc_html($tower->Number_of_bells); ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <?php

    // Get the contents from the output buffer and return it
    return ob_get_clean();
}


// Hook function to display towers to the appropriate shortcode
add_shortcode('tower_manager_display_towers', 'tower_manager_display_towers');

add_shortcode('display_towers', 'tower_manager_display_towers');