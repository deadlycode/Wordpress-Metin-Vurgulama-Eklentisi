import { registerFormatType, toggleFormat } from '@wordpress/rich-text';
import { __ } from '@wordpress/i18n';
import { ColorPalette } from '@wordpress/components';
import { useState } from '@wordpress/element';

const name = 'highlight-text-background/format';
const title = __('Highlight Text Background', 'highlight-text-background');

const Edit = ({ value, onChange, isActive }) => {
    const [color, setColor] = useState('#ffff99');

    return (
        <div className="highlight-text-background-controls">
            <ColorPalette
                colors={[
                    { name: 'yellow', color: '#ffff99' },
                    { name: 'green', color: '#ccffcc' },
                    { name: 'blue', color: '#ccffff' },
                    { name: 'pink', color: '#ffcccc' },
                    { name: 'purple', color: '#ffccff' },
                ]}
                value={color}
                onChange={(newColor) => {
                    setColor(newColor);
                    onChange(toggleFormat(value, {
                        type: name,
                        attributes: {
                            style: `background-color: ${newColor}; padding: 2px 4px; border-radius: 3px; box-decoration-break: clone; -webkit-box-decoration-break: clone;`
                        }
                    }));
                }}
            />
        </div>
    );
};

registerFormatType(name, {
    title,
    tagName: 'span',
    className: 'highlight-text-background',
    attributes: {
        style: 'style',
    },
    edit: Edit,
}); 