const { registerBlockType } = wp.blocks; 
const { RichText } = wp.editor;
const { TextControl, ExternalLink } = wp.components;
import './single_link.scss';


const SingleLinkEditor = ({ attributes, setAttributes }) => {

    const changeTitle = e => {

    };

    const changeLink = e => {

    };


    return ([
        <div className="cta-container">
            <label style={{fontWeight: 'bold'}}>Link de descarga</label>
            <RichText placeholder="Escribe el link" style={{padding: '.5rem 0', borderBottom: '1px solid #aaa'}} />
            <p><small>Este link se meterá en el set de links de descargas al final de cada sección.</small></p>
        </div>
    ]);
};



registerBlockType('esd/anchor', {
    // Built in attributes
    title: "Anchor",
    description: "Block to generate anchor",
    icon: "format-image",
    category: "text",

    // custom attributes
    attributes: {
        title: {
            type: 'string',
            source: 'html', 
            selector: 'h5'
        }, 
        link: {
            type: 'string',
            source: 'html', 
            selector: 'p'
        } 
    },

    // custom functions


    // built-in functions
    edit(props) {
        return <SingleLinkEditor {...props} />
    },

    save({ attributes }) {
        return <div>hola</div>
    }
})