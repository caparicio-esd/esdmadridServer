const { registerBlockType } = wp.blocks;
const { RichText } = wp.blockEditor;
import './translations.scss';

/**
 *
 * Editor React Component
 */
const TranslationEditor = ({ attributes, setAttributes }) => {

    const changeTextHandler = (value, field) => {
        setAttributes({field: value});
    };

    return [
        <div className="translation">
            <label>Bloque de traducción</label>
            <RichText
                placeholder="Escribe el texto en castellano"
                value={attributes.textOriginal}
                onChange={(value) => changeTextHandler(value, 'textOriginal')}
            />
            <RichText
                placeholder="Escribe el texto en inglés"
                value={attributes.textTranslation}
                onChange={(value) => changeTextHandler(value, 'textTranslation')}
            />
        </div>,
    ];
};

/**
 *
 * Saving React Component
 *
 * Sigo intentado...
 */
const TranslationSave = ({ attributes }) => {
    return (
    <div className="translation">
        <p className="translation_spanish">
            {attributes.textOriginal}
        </p>
        <p className="translation_english">
            {attributes.textTranslation}
        </p>
    </div>
    );
};

registerBlockType('esd/translations', {
    title: 'translations',
    description: 'Block to generate translations',
    icon: 'admin-site-alt',
    category: 'text',
    attributes: {
        textOriginal: {
            type: 'string',
            source: 'html'
        },
        textTranslation: {
            type: 'string',
            source: 'html'
        },
    },
    edit(props) {
        return <TranslationEditor {...props} />;
    },
    save(props) {
        return <TranslationSave {...props} />;
    },
});
