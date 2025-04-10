<?php
/**
 * Plugin Name: OZN Text ColorFULL
 * Plugin URI: 
 * Description: Gutenberg editöründe seçili metinlere arkaplan rengi ekleme özelliği
 * Version: 1.0.0
 * Author: OZN
 * Author URI: 
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: ozn-text-colorfull
 */

if (!defined('ABSPATH')) {
    exit;
}

// Admin ayarlar sayfasını dahil et
require_once plugin_dir_path(__FILE__) . 'admin/settings.php';

// Plugin activation hook
register_activation_hook(__FILE__, 'ozn_text_colorfull_activate');
function ozn_text_colorfull_activate() {
    // Varsayılan ayarları ekle
    $default_options = array(
        'custom_colors' => "Açık Sarı|#fff9c4\nAçık Yeşil|#c8e6c9\nAçık Mavi|#bbdefb\nAçık Pembe|#f8bbd0\nAçık Mor|#e1bee7\nSarı|#ffd600\nYeşil|#00c853\nMavi|#2962ff\nKırmızı|#d50000\nMor|#aa00ff\nTuruncu|#ff6d00\nTurkuaz|#00bfa5\nLime|#aeea00\nPembe|#c51162\nİndigo|#304ffe\nKahverengi|#795548\nGri|#757575\nAçık Gri|#eeeeee\nKoyu Gri|#424242\nSiyah|#212121",
        'default_color' => '#fff9c4',
        'palette_columns' => 5,
        'padding' => '2px 4px',
        'border_radius' => '3px'
    );
    
    add_option('ozn_text_colorfull_options', $default_options);
}

// Plugin deactivation hook
register_deactivation_hook(__FILE__, 'ozn_text_colorfull_deactivate');
function ozn_text_colorfull_deactivate() {
    // Deactivation code here
}

function ozn_text_colorfull_enqueue_editor_assets() {
    wp_enqueue_script(
        'ozn-text-colorfull',
        plugins_url('js/highlight-text-background.js', __FILE__),
        array(
            'wp-rich-text',
            'wp-blocks',
            'wp-i18n',
            'wp-element',
            'wp-editor',
            'wp-components',
            'wp-block-editor'
        ),
        filemtime(plugin_dir_path(__FILE__) . 'js/highlight-text-background.js')
    );

    wp_enqueue_style(
        'ozn-text-colorfull',
        plugins_url('css/highlight-text-background.css', __FILE__),
        array(),
        filemtime(plugin_dir_path(__FILE__) . 'css/highlight-text-background.css')
    );
    
    // Ayarları JS'e aktar
    $options = get_option('ozn_text_colorfull_options', array());
    
    // Özel renkleri işle
    $colors = array();
    if (!empty($options['custom_colors'])) {
        $color_lines = explode("\n", $options['custom_colors']);
        foreach ($color_lines as $line) {
            $parts = explode('|', $line);
            if (count($parts) === 2) {
                $colors[] = array(
                    'name' => trim($parts[0]),
                    'color' => trim($parts[1])
                );
            }
        }
    }
    
    // Boşsa varsayılan renkleri kullan
    if (empty($colors)) {
        $colors = array(
            array('name' => 'Açık Sarı', 'color' => '#fff9c4'),
            array('name' => 'Açık Yeşil', 'color' => '#c8e6c9'),
            array('name' => 'Açık Mavi', 'color' => '#bbdefb'),
            array('name' => 'Açık Pembe', 'color' => '#f8bbd0'),
            array('name' => 'Açık Mor', 'color' => '#e1bee7'),
            array('name' => 'Sarı', 'color' => '#ffd600'),
            array('name' => 'Yeşil', 'color' => '#00c853'),
            array('name' => 'Mavi', 'color' => '#2962ff'),
            array('name' => 'Kırmızı', 'color' => '#d50000'),
            array('name' => 'Mor', 'color' => '#aa00ff')
        );
    }
    
    // Stil ayarları
    $style_options = array(
        'defaultColor' => !empty($options['default_color']) ? $options['default_color'] : '#fff9c4',
        'paletteColumns' => !empty($options['palette_columns']) ? intval($options['palette_columns']) : 5,
        'padding' => !empty($options['padding']) ? $options['padding'] : '2px 4px',
        'borderRadius' => !empty($options['border_radius']) ? $options['border_radius'] : '3px'
    );
    
    wp_localize_script('ozn-text-colorfull', 'oznTextColorfullOptions', array(
        'colors' => $colors,
        'styleOptions' => $style_options
    ));
}
add_action('enqueue_block_editor_assets', 'ozn_text_colorfull_enqueue_editor_assets'); 