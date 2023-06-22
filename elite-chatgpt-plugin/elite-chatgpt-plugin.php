<?php
/*
Plugin Name: EliteAco ChatGPT Plugin
Plugin URI: https://www.eliteaco.com
Description: Este é um plugin que conecta o ChatGPT com o meu site WordPress.
Version: 1.0
Author: Seu Nome
Author URI: https://www.eliteaco.com
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class EliteAco_ChatGPT_Plugin {

    public function __construct() {
        add_action('init', array($this, 'init'));
    }

    public function init() {
        add_shortcode('chatgpt_form', array($this, 'chat_form_shortcode'));
    }

    public function get_chatgpt_response($prompt) {
        $api_url = 'https://api.openai.com/v1/engines/davinci-codex/completions'; // URL da API
        $api_key = 'sua_api_key_aqui'; // Substitua por sua chave de API

        $headers = array(
            'Authorization' => 'Bearer ' . $api_key,
            'Content-Type' => 'application/json'
        );

        $body = array(
            'prompt' => $prompt,
            'max_tokens' => 60,
        );

        $args = array(
            'headers' => $headers,
            'body' => json_encode($body),
            'method' => 'POST',
            'data_format' => 'body',
        );

        $http = new WP_Http();
        $response = $http->request($api_url, $args);

        if (is_wp_error($response)) {
            // Trate o erro aqui
        } else {
            return json_decode($response['body']);
        }
    }

    public function chat_form_shortcode() {
        ob_start();
        ?>
        <form id="chatgpt-form">
            <label for="chatgpt-input">Faça uma pergunta:</label><br>
            <input type="text" id="chatgpt-input" name="question" required><br>
            <input type="submit" value="Enviar">
        </form>
        <div id="chatgpt-response"></div>
        <?php
        return ob_get_clean();
    }

}


new EliteAco_ChatGPT_Plugin();

