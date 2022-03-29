const { registerBlockType } = wp.blocks;
const { RichText } = wp.blockEditor;
import "./translations.scss";

/**
 *
 * Editor React Component
 */
const TranslationEditor = ({ attributes, setAttributes }) => {
  return [<div className="translation">translation</div>];
};

/**
 *
 * Saving React Component
 *
 * Sigo intentado...
 */
const TranslationSave = ({ attributes }) => {
  return <div className="translation">translation</div>;
};

registerBlockType("esd/translations", {
  title: "translations",
  description: "Block to generate translations",
  icon: "admin-site-alt",
  category: "text",
  attributes: {
    textOriginal: {
      type: "string",
    },
    textTranslation: {
      type: "string",
    },
  },
  edit(props) {
    return <TranslationEditor {...props} />;
  },
  save(props) {
    return <TranslationSave {...props} />;
  },
});
