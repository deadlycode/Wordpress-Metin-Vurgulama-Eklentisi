<?php
/**
 * OZN Text ColorFULL - Admin Settings Page
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Admin menu ve sayfa oluşturma
function ozn_text_colorfull_add_admin_menu() {
    add_menu_page(
        'OZN Text ColorFULL',
        'OZN Text ColorFULL',
        'manage_options',
        'ozn-text-colorfull',
        'ozn_text_colorfull_settings_page',
        'dashicons-admin-customizer',
        100
    );
}
add_action('admin_menu', 'ozn_text_colorfull_add_admin_menu');

// Ayarları kaydetme
function ozn_text_colorfull_settings_init() {
    // Ayarları kaydet
    register_setting('ozn_text_colorfull_settings', 'ozn_text_colorfull_options');

    // Renk ayarları bölümü
    add_settings_section(
        'ozn_text_colorfull_color_section',
        __('Renk Ayarları', 'ozn-text-colorfull'),
        'ozn_text_colorfull_color_section_callback',
        'ozn-text-colorfull'
    );

    // Özel renkler alanı
    add_settings_field(
        'ozn_text_colorfull_custom_colors',
        __('Özel Renkler', 'ozn-text-colorfull'),
        'ozn_text_colorfull_custom_colors_render',
        'ozn-text-colorfull',
        'ozn_text_colorfull_color_section'
    );

    // Varsayılan renk alanı
    add_settings_field(
        'ozn_text_colorfull_default_color',
        __('Varsayılan Renk', 'ozn-text-colorfull'),
        'ozn_text_colorfull_default_color_render',
        'ozn-text-colorfull',
        'ozn_text_colorfull_color_section'
    );

    // Renk paleti görünümü
    add_settings_field(
        'ozn_text_colorfull_palette_columns',
        __('Renk Paleti Sütun Sayısı', 'ozn-text-colorfull'),
        'ozn_text_colorfull_palette_columns_render',
        'ozn-text-colorfull',
        'ozn_text_colorfull_color_section'
    );

    // Stil ayarları bölümü
    add_settings_section(
        'ozn_text_colorfull_style_section',
        __('Stil Ayarları', 'ozn-text-colorfull'),
        'ozn_text_colorfull_style_section_callback',
        'ozn-text-colorfull'
    );

    // Padding ayarı
    add_settings_field(
        'ozn_text_colorfull_padding',
        __('Padding (İç Boşluk)', 'ozn-text-colorfull'),
        'ozn_text_colorfull_padding_render',
        'ozn-text-colorfull',
        'ozn_text_colorfull_style_section'
    );

    // Border radius ayarı
    add_settings_field(
        'ozn_text_colorfull_border_radius',
        __('Köşe Yuvarlaklığı', 'ozn-text-colorfull'),
        'ozn_text_colorfull_border_radius_render',
        'ozn-text-colorfull',
        'ozn_text_colorfull_style_section'
    );
}
add_action('admin_init', 'ozn_text_colorfull_settings_init');

// Renk bölümü açıklaması
function ozn_text_colorfull_color_section_callback() {
    echo '<p>' . __('Metin vurgulama için renk ayarlarını yapılandırın.', 'ozn-text-colorfull') . '</p>';
}

// Stil bölümü açıklaması
function ozn_text_colorfull_style_section_callback() {
    echo '<p>' . __('Vurgulanan metinlerin görünüm stillerini ayarlayın.', 'ozn-text-colorfull') . '</p>';
}

// Özel renkler alanı render
function ozn_text_colorfull_custom_colors_render() {
    $options = get_option('ozn_text_colorfull_options');
    $custom_colors = isset($options['custom_colors']) ? $options['custom_colors'] : '';
    ?>
    <textarea name="ozn_text_colorfull_options[custom_colors]" rows="8" cols="50" class="large-text code"><?php echo esc_textarea($custom_colors); ?></textarea>
    <p class="description">
        <?php _e('Her satıra bir renk ekleyin. Format: Renk Adı|#HexCode. Örnek: Açık Kırmızı|#ffcdd2', 'ozn-text-colorfull'); ?>
    </p>
    <?php
}

// Varsayılan renk alanı render
function ozn_text_colorfull_default_color_render() {
    $options = get_option('ozn_text_colorfull_options');
    $default_color = isset($options['default_color']) ? $options['default_color'] : '#fff9c4';
    ?>
    <input type="text" name="ozn_text_colorfull_options[default_color]" value="<?php echo esc_attr($default_color); ?>" class="ozn-color-picker" data-default-color="#fff9c4" />
    <?php
}

// Renk paleti sütun sayısı render
function ozn_text_colorfull_palette_columns_render() {
    $options = get_option('ozn_text_colorfull_options');
    $columns = isset($options['palette_columns']) ? $options['palette_columns'] : 5;
    ?>
    <select name="ozn_text_colorfull_options[palette_columns]">
        <option value="3" <?php selected($columns, 3); ?>>3</option>
        <option value="4" <?php selected($columns, 4); ?>>4</option>
        <option value="5" <?php selected($columns, 5); ?>>5</option>
        <option value="6" <?php selected($columns, 6); ?>>6</option>
    </select>
    <?php
}

// Padding ayarı render
function ozn_text_colorfull_padding_render() {
    $options = get_option('ozn_text_colorfull_options');
    $padding = isset($options['padding']) ? $options['padding'] : '2px 4px';
    ?>
    <input type="text" name="ozn_text_colorfull_options[padding]" value="<?php echo esc_attr($padding); ?>" />
    <p class="description">
        <?php _e('CSS padding formatında girin. Örnek: 2px 4px', 'ozn-text-colorfull'); ?>
    </p>
    <?php
}

// Border radius ayarı render
function ozn_text_colorfull_border_radius_render() {
    $options = get_option('ozn_text_colorfull_options');
    $border_radius = isset($options['border_radius']) ? $options['border_radius'] : '3px';
    ?>
    <input type="text" name="ozn_text_colorfull_options[border_radius]" value="<?php echo esc_attr($border_radius); ?>" />
    <p class="description">
        <?php _e('CSS border-radius formatında girin. Örnek: 3px', 'ozn-text-colorfull'); ?>
    </p>
    <?php
}

// Admin sayfası render
function ozn_text_colorfull_settings_page() {
    // Kullanıcı izinlerini kontrol et
    if (!current_user_can('manage_options')) {
        return;
    }

    // Kaydedildi mesajı
    if (isset($_GET['settings-updated'])) {
        add_settings_error('ozn_text_colorfull_messages', 'ozn_text_colorfull_message', __('Ayarlar kaydedildi.', 'ozn-text-colorfull'), 'updated');
    }

    // Hata mesajlarını göster
    settings_errors('ozn_text_colorfull_messages');
    ?>
    <div class="wrap">
        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
        <form action="options.php" method="post">
            <?php
            settings_fields('ozn_text_colorfull_settings');
            do_settings_sections('ozn-text-colorfull');
            submit_button(__('Ayarları Kaydet', 'ozn-text-colorfull'));
            ?>
        </form>
        <hr>
        <h2><?php _e('Mevcut Renk Paleti', 'ozn-text-colorfull'); ?></h2>
        <div id="ozn-color-palette-preview" style="display: grid; grid-template-columns: repeat(5, 1fr); gap: 10px; margin-top: 20px;">
            <!-- JavaScript ile doldurulacak -->
        </div>
    </div>

    <script>
    jQuery(document).ready(function($) {
        // Renk seçici başlat
        $('.ozn-color-picker').wpColorPicker();

        // Mevcut renk paletini göster
        function updateColorPalette() {
            var customColors = $('textarea[name="ozn_text_colorfull_options[custom_colors]"]').val();
            var paletteContainer = $('#ozn-color-palette-preview');
            
            paletteContainer.empty();
            
            if (customColors) {
                var colors = customColors.split('\n');
                
                colors.forEach(function(colorLine) {
                    if (colorLine.trim() !== '') {
                        var parts = colorLine.split('|');
                        if (parts.length === 2) {
                            var name = parts[0].trim();
                            var color = parts[1].trim();
                            
                            var colorBox = $('<div class="color-preview-item"></div>').css({
                                'background-color': color,
                                'height': '30px',
                                'border-radius': '3px',
                                'position': 'relative'
                            });
                            
                            var colorName = $('<div class="color-name"></div>').text(name).css({
                                'position': 'absolute',
                                'bottom': '0',
                                'left': '0',
                                'right': '0',
                                'background': 'rgba(0,0,0,0.7)',
                                'color': 'white',
                                'font-size': '12px',
                                'padding': '2px 5px',
                                'border-bottom-left-radius': '3px',
                                'border-bottom-right-radius': '3px',
                                'text-align': 'center',
                                'overflow': 'hidden',
                                'text-overflow': 'ellipsis',
                                'white-space': 'nowrap'
                            });
                            
                            colorBox.append(colorName);
                            paletteContainer.append(colorBox);
                        }
                    }
                });
            } else {
                paletteContainer.html('<p><?php _e('Henüz özel renk tanımlanmamış.', 'ozn-text-colorfull'); ?></p>');
            }
        }
        
        // Sayfa yüklendiğinde renk paletini göster
        updateColorPalette();
        
        // Renk paleti değiştiğinde güncelle
        $('textarea[name="ozn_text_colorfull_options[custom_colors]"]').on('input', function() {
            updateColorPalette();
        });
    });
    </script>
    <?php
}

// Admin stil ve script ekleme
function ozn_text_colorfull_admin_scripts() {
    $screen = get_current_screen();
    
    if ($screen && $screen->id === 'toplevel_page_ozn-text-colorfull') {
        wp_enqueue_style('wp-color-picker');
        wp_enqueue_script('wp-color-picker');
    }
}
add_action('admin_enqueue_scripts', 'ozn_text_colorfull_admin_scripts');
