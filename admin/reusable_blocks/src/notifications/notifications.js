const { registerBlockType } = wp.blocks;
const { RichText, InspectorControls, InnerBlocks } = wp.blockEditor;
const { PanelBody, SelectControl } = wp.components;
import { useState, useEffect } from 'react';
import './notifications.scss';

const ALLOWED_BLOCKS = ['core/heading', 'core/paragraph'];

/**
 *
 * Editor React Component
 */
const NotificationEditor = ({ attributes, setAttributes }) => {
  const [formattedType, setFormattedType] = useState("");
  const [notificationType, setNotificationType] = useState("");

  const contentChangeHandler = (value) => {
    setAttributes({ content: value });
  };
  const notificationTypeChangeHandler = (value) => {
    setAttributes({ type: value });
  };

  useEffect(() => {
    const fType = attributes.type[0].toUpperCase() + attributes.type.slice(1);
    const nType = `notification_${attributes.type}`;

    setFormattedType(fType);
    setNotificationType(nType);
  }, [attributes.type]);

  return [
    <InspectorControls style={{ marginBottom: "2rem" }} key="inpector">
      <PanelBody title={"Font Color Settings"}>
        <p>
          <strong>Select a title</strong>:
        </p>
        <SelectControl
          label={"Selecciona un nivel de notificación:"}
          value={attributes.type} // e.g: value = [ 'a', 'c' ]
          onChange={notificationTypeChangeHandler}
          options={[
            {
              value: null,
              label: "Selecciona un nivel de notificación",
              disabled: true,
            },
            { value: "normal", label: "Nivel Normal" },
            { value: "esd", label: "Nivel ESD" },
            { value: "info", label: "Nivel Info" },
            { value: "danger", label: "Nivel Danger" },
            { value: "warning", label: "Nivel Warning" },
            { value: "success", label: "Nivel Success" },
          ]}
        />
      </PanelBody>
    </InspectorControls>,

    <div className={["notification", notificationType].join(" ")} key="edition">
      <h5>Notificación nivel {formattedType}</h5>
      {/* <RichText key="editable" value={attributes.content} onChange={contentChangeHandler} /> */}
      <InnerBlocks allowedBlocks={ALLOWED_BLOCKS} />
    </div>,
  ];
};

/**
 *
 * Saving React Component
 */
const NotificationSave = ({ attributes }) => {
  return (
    <div className={["notification", `notification_${attributes.type}`].join(" ")}>
      <InnerBlocks.Content />
    </div>
  );
};

registerBlockType("esd/notification", {
  title: "Notification",
  description: "Block to generate a Notification in ESD",
  icon: "admin-comments",
  category: "text",
  attributes: {
    content: {
      type: "string",
      source: "html",
    },
    type: {
      type: "string",
      default: "normal",
    },
  },
  edit(props) {
    return <NotificationEditor {...props} />;
  },
  save(props) {
    return <NotificationSave {...props} />;
  },
});
