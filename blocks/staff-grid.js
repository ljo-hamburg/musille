import React from "react";
import { __ } from "@wordpress/i18n";
import { registerBlockType } from "@wordpress/blocks";
import {
  InnerBlocks,
  InspectorControls,
  RichText,
} from "@wordpress/block-editor";
import {
  BaseControl,
  PanelBody,
  Placeholder,
  Spinner,
  TextControl,
  ToggleControl,
} from "@wordpress/components";
import ImageSelector from "@ljo-hamburg/gutenberg-image-selector";
import { useSelect } from "@wordpress/data";

const GRID_BLOCK_NAME = "musille/staff-grid";
const ITEM_BLOCK_NAME = "musille/staff-grid-item";

/**
 * Register the staff grid block.
 */
registerBlockType(GRID_BLOCK_NAME, {
  title: __("Staff Grid", "musille"),
  description: __("A list of staff members.", "musille"),
  category: "common",
  icon: "businessman",
  edit({ className }) {
    return (
      <div className={className}>
        <InnerBlocks
          allowedBlocks={["wp-concerts/staff-grid-item"]}
          renderAppender={InnerBlocks.ButtonBlockAppender}
        />
      </div>
    );
  },
  save() {
    return (
      <div>
        <InnerBlocks.Content />
      </div>
    );
  },
});

/**
 * Create the staff grid item block.
 */
registerBlockType(ITEM_BLOCK_NAME, {
  title: __("Staff Member", "musille"),
  description: __("A staff grid item.", "musille"),
  category: "common",
  icon: "businessman",
  parent: ["musille/staff-grid"],
  attributes: {
    imageID: {
      type: "integer",
    },
    image: {
      type: "object",
    },
    name: {
      type: "string",
    },
    position: {
      type: "string",
    },
    meta: {
      type: "string",
    },
    showAttribution: {
      type: "boolean",
    },
  },
  edit({
    className,
    attributes: { imageID, name, position, meta, showAttribution },
    setAttributes,
  }) {
    const image = useSelect((select) => select("core").getMedia(imageID), [
      imageID,
    ]);
    setAttributes({ image });
    return (
      <>
        <InspectorControls>
          <PanelBody>
            <BaseControl label={__("Photo", "musille")}>
              <ImageSelector
                label={__("Photo", "musille")}
                authMessage={__(
                  "To edit the photo, you need permission to upload media.",
                  "musille"
                )}
                imageID={imageID}
                onChange={(imageID) => setAttributes({ imageID })}
              />
            </BaseControl>
            <TextControl
              label={__("Extra Info", "musille")}
              value={meta}
              onChange={(meta) => setAttributes({ meta })}
            />
            <ToggleControl
              label={__("Show Photo Attribution", "musille")}
              checked={showAttribution}
              onChange={(showAttribution) => setAttributes({ showAttribution })}
            />
          </PanelBody>
        </InspectorControls>
        {!imageID && (
          <Placeholder
            icon="format-image"
            label={__("Select a Photo", "musille")}
            instructions={__(
              "Select a photo for this staff member in the inspector.",
              "musille"
            )}
          />
        )}
        {imageID && !image && <Spinner />}
        {imageID && image && (
          <div className={className}>
            <div className="image">
              <img src={image.source_url} alt={image.alt_text} />
              <div className="content">
                <div className="name">{name}</div>
                <div className="meta">{meta}</div>
              </div>
              {showAttribution && (
                <span className="attribution">{image.caption.raw}</span>
              )}
            </div>
            <RichText
              tagName="h3"
              className="name"
              value={name}
              allowedFormats={[]}
              onChange={(name) => setAttributes({ name })}
              placeholder={__("Name", "musille")}
            />
            <RichText
              tagName="div"
              className="position"
              value={position}
              allowedFormats={[]}
              onChange={(position) => setAttributes({ position })}
              placeholder={__("Position", "musille")}
            />
          </div>
        )}
      </>
    );
  },
  save({ attributes: { image, name, position, meta, showAttribution } }) {
    if (!image) {
      return null;
    }
    return (
      <div>
        <div className="image">
          <img src={image.source_url} alt={image.alt_text} />
          <div className="content">
            <div className="name">{name}</div>
            <div className="meta">{meta}</div>
          </div>
          {showAttribution && (
            <span className="attribution">{image.caption.raw}</span>
          )}
        </div>
        <RichText.Content tagName="h3" className="name" value={name} />
        <RichText.Content tagName="div" className="position" value={position} />
      </div>
    );
  },
});
