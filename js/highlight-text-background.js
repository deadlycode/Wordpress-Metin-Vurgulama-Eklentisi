( function( wp ) {
    var registerFormatType = wp.richText.registerFormatType;
    var toggleFormat = wp.richText.toggleFormat;
    var __ = wp.i18n.__;
    var ColorPalette = wp.components.ColorPalette;
    var ColorPicker = wp.components.ColorPicker;
    var useState = wp.element.useState;
    var Popover = wp.components.Popover;
    var Button = wp.components.Button;
    var BlockControls = wp.blockEditor.BlockControls;
    var ToolbarGroup = wp.components.ToolbarGroup;
    var ToolbarButton = wp.components.ToolbarButton;
    var Panel = wp.components.Panel;
    var PanelBody = wp.components.PanelBody;

    var name = 'ozn-text-colorfull/text-color';
    var title = __('Metin Arkaplan Rengi');

    // Ayarlardan gelen renkleri ve stil seçeneklerini al
    var colors = [];
    var styleOptions = {
        defaultColor: '#fff9c4',
        paletteColumns: 5,
        padding: '2px 4px',
        borderRadius: '3px'
    };

    // Global değişkenden ayarları al
    if (typeof oznTextColorfullOptions !== 'undefined') {
        colors = oznTextColorfullOptions.colors || [];
        styleOptions = oznTextColorfullOptions.styleOptions || styleOptions;
    }

    // Renk paleti boşsa varsayılan renkleri kullan
    if (!colors || colors.length === 0) {
        colors = [
            { name: 'Açık Sarı', color: '#fff9c4' },
            { name: 'Açık Yeşil', color: '#c8e6c9' },
            { name: 'Açık Mavi', color: '#bbdefb' },
            { name: 'Açık Pembe', color: '#f8bbd0' },
            { name: 'Açık Mor', color: '#e1bee7' },
            { name: 'Sarı', color: '#ffd600' },
            { name: 'Yeşil', color: '#00c853' },
            { name: 'Mavi', color: '#2962ff' },
            { name: 'Kırmızı', color: '#d50000' },
            { name: 'Mor', color: '#aa00ff' },
            { name: 'Turuncu', color: '#ff6d00' },
            { name: 'Turkuaz', color: '#00bfa5' },
            { name: 'Lime', color: '#aeea00' },
            { name: 'Pembe', color: '#c51162' },
            { name: 'İndigo', color: '#304ffe' },
            { name: 'Kahverengi', color: '#795548' },
            { name: 'Gri', color: '#757575' },
            { name: 'Açık Gri', color: '#eeeeee' },
            { name: 'Koyu Gri', color: '#424242' },
            { name: 'Siyah', color: '#212121' }
        ];
    }

    registerFormatType(name, {
        title: title,
        tagName: 'span',
        className: 'ozn-text-colorfull',
        attributes: {
            style: 'style'
        },
        edit: function Edit({ isActive, value, onChange }) {
            var [isColorPickerOpen, setIsColorPickerOpen] = useState(false);
            var [color, setColor] = useState(styleOptions.defaultColor);
            var [showCustomPicker, setShowCustomPicker] = useState(false);

            function applyFormat(newColor) {
                if (!newColor) return;
                
                onChange(
                    toggleFormat(value, {
                        type: name,
                        attributes: {
                            style: 'background-color: ' + newColor + '; padding: ' + styleOptions.padding + '; border-radius: ' + styleOptions.borderRadius + '; box-decoration-break: clone; -webkit-box-decoration-break: clone;'
                        }
                    })
                );
            }

            function handleColorChange(newColor) {
                if (!newColor) return;
                setColor(newColor);
                applyFormat(newColor);
            }

            function handleCustomColorChange(newColor) {
                if (!newColor || !newColor.hex) return;
                setColor(newColor.hex);
                applyFormat(newColor.hex);
            }

            // Renk paleti sütun sayısını CSS olarak ayarla
            var colorPaletteStyle = {
                display: 'grid',
                gridTemplateColumns: 'repeat(' + styleOptions.paletteColumns + ', 1fr)',
                gap: '8px',
                padding: '0',
                marginTop: '8px'
            };

            return wp.element.createElement(
                BlockControls,
                null,
                wp.element.createElement(
                    ToolbarGroup,
                    null,
                    wp.element.createElement(
                        ToolbarButton,
                        {
                            icon: 'admin-customizer',
                            title: title,
                            onClick: function() {
                                setIsColorPickerOpen(!isColorPickerOpen);
                            },
                            isActive: isActive
                        }
                    ),
                    isColorPickerOpen && wp.element.createElement(
                        Popover,
                        {
                            position: "bottom center",
                            onClose: function() {
                                setIsColorPickerOpen(false);
                                setShowCustomPicker(false);
                            },
                            className: 'highlight-text-popover'
                        },
                        wp.element.createElement(
                            Panel,
                            {
                                className: 'highlight-text-panel'
                            },
                            wp.element.createElement(
                                PanelBody,
                                {
                                    title: __('Hazır Renkler'),
                                    initialOpen: true,
                                    className: 'highlight-text-panel-body'
                                },
                                wp.element.createElement(
                                    'div',
                                    {
                                        className: 'highlight-text-controls',
                                        style: { padding: '12px' }
                                    },
                                    !showCustomPicker && wp.element.createElement(
                                        'div',
                                        {
                                            style: colorPaletteStyle,
                                            className: 'ozn-color-palette-container'
                                        },
                                        wp.element.createElement(ColorPalette, {
                                            colors: colors,
                                            value: color,
                                            onChange: handleColorChange,
                                            clearable: false
                                        })
                                    ),
                                    wp.element.createElement(
                                        Button,
                                        {
                                            isSecondary: true,
                                            onClick: function() {
                                                setShowCustomPicker(!showCustomPicker);
                                            },
                                            style: { marginTop: '10px', width: '100%' }
                                        },
                                        showCustomPicker ? 'Hazır Renkleri Göster' : 'Özel Renk Seç'
                                    ),
                                    showCustomPicker && wp.element.createElement(
                                        'div',
                                        {
                                            style: { marginTop: '10px' }
                                        },
                                        wp.element.createElement(ColorPicker, {
                                            color: color,
                                            onChangeComplete: handleCustomColorChange
                                        })
                                    )
                                )
                            )
                        )
                    )
                )
            );
        }
    });
})( window.wp );
