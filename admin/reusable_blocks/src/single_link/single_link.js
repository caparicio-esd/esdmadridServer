const { registerBlockType } = wp.blocks;
const { RichText } = wp.blockEditor;
import './single_link.scss';


/**
 *
 * Editor React Component
 */
const SingleLinkEditor = ({ attributes, setAttributes }) => {
    const changeTitleHandler = (value) => {
        setAttributes({ title: value });
    };
    const changeLinkHandler = (value) => {
        setAttributes({ link: value });
    };

    return [
        <div className="single_link">
            <label>Link de descarga</label>
            <RichText
                placeholder="Escribe el title"
                value={attributes.title}
                onChange={changeTitleHandler}
            />
            <RichText
                placeholder="Escribe el link"
                value={attributes.link}
                onChange={changeLinkHandler}
            />
            <p>
                <small>
                    Este link se meterá en el set de links de descargas al final de cada sección.
                </small>
            </p>
        </div>,
    ];
};

/**
 *
 * Saving React Component
 *
 * Sigo intentado...
 */
const SingleLinkSave = ({ attributes }) => {
    return (
        <div className="single_link">
            <a href={attributes.link}>{ attributes.title }</a>
        </div>
    );
};

registerBlockType('esd/single-link', {
    title: 'Single Link',
    description: 'Block to generate a single link',
    icon: 'format-image',
    category: 'text',
    attributes: {
        title: {
            type: 'string',
        },
        link: {
            type: 'string',
        },
    },
    edit(props) {
        return <SingleLinkEditor {...props} />;
    },
    save(props) {
        return <SingleLinkSave {...props} />;
    },
});
