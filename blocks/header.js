/**
 * The custom header block enables users to customize the musille header in pages and
 * posts. It can only be added once to a page or post and saves its data in the post's
 * meta fields. The block itself does not have a rendered representation. Instead the
 * post's meta fields are used in a page's header.
 *
 * The following meta fields are supported:
 * - `musille_header_image_id`: A custom header image that overrides the post's image.
 * - `musille_subtitle`: The subtitle for a post or page.
 */

import React, { Fragment, useEffect } from "react";
import { __ } from "@wordpress/i18n";
import { registerBlockType, registerBlockStyle } from "@wordpress/blocks";
import { useSelect } from "@wordpress/data";
import { InspectorControls, useBlockProps } from "@wordpress/block-editor";
import { PanelBody, TextControl, ToggleControl } from "@wordpress/components";
import ImageSelector from "@ljo-hamburg/gutenberg-image-selector";

const BLOCK_NAME = "musille/header";

registerBlockType(BLOCK_NAME, {
  apiVersion: 2,
  title: __("Musille Header", "musille"),
  description: __("Customize the Musille Page Header.", "musille"),
  category: "formatting",
  icon: "format-image",
  attributes: {
    /**
     * The ID of the custom background image. If unset the post's featured image will be
     * used.
     */
    imageID: {
      type: "integer",
      source: "meta",
      meta: "musille_header_image_id",
    },
    /**
     * An optional subtitle for the post or page.
     */
    subtitle: {
      type: "string",
      source: "meta",
      meta: "musille_subtitle",
    },
    style: {
      type: "string",
      source: "meta",
      meta: "musille_header_style",
    },
    showAttribution: {
      type: "boolean",
      source: "meta",
      meta: "musille_show_attribution",
    },
  },
  supports: {
    html: false,
    multiple: false, // Only one header is allowed per page/post.
  },
  edit({
    clientId,
    attributes: { imageID, subtitle, style, showAttribution },
    isSelected,
    setAttributes,
  }) {
    const blockStyle = useSelect(
      (select) => {
        const { getBlockAttributes } = select("core/block-editor");
        return (
          (getBlockAttributes(clientId).className ?? "")
            .split(" ")
            .find((className) => className.startsWith("is-style-")) ??
          "is-style-basic"
        ).substring("is-style-".length);
      },
      [true]
    );
    useEffect(() => {
      if (blockStyle !== style && isSelected) {
        console.log(`Setting current style from ${style} to ${blockStyle}`);
        setAttributes({ style: blockStyle });
      }
    });
    const { title: postTitle, imageID: postImageID } = useSelect(
      (select) => {
        const editor = select("core/editor");
        let title;
        if (typeof editor.getPostEdits().title !== "undefined") {
          title = editor.getPostEdits().title;
        } else {
          title = editor.getCurrentPost().title;
        }
        return {
          title,
          imageID: editor.getEditedPostAttribute("featured_media"),
        };
      },
      [true]
    );
    const image = useSelect(
      (select) => select("core").getMedia(imageID || postImageID),
      [imageID, postImageID]
    );
    const imageStyle = {};
    if (["subtitle", "fancy"].includes(style) && image && image.source_url) {
      imageStyle.backgroundImage = `url(${image.source_url})`;
    }
    const blockProps = useBlockProps({
      style: imageStyle,
    });
    return (
      <Fragment>
        <InspectorControls>
          <PanelBody
            title={__("Background Image", "musille")}
            initialOpen={false}
          >
            <ToggleControl
              label={__("Image Attribution", "musille")}
              help={__(
                "Display the image's caption as an attribution notice.",
                "musille"
              )}
              checked={showAttribution}
              onChange={(showAttribution) => setAttributes({ showAttribution })}
            />
            <ImageSelector
              label={__("Select Background Image", "musille")}
              removeLabel={__("Remove Image", "musille")}
              authMessage={__(
                "To edit the background image, you need permission to upload media.",
                "musille"
              )}
              imageID={imageID}
              onChange={(imageID) => setAttributes({ imageID })}
            />
          </PanelBody>
        </InspectorControls>
        <div {...blockProps}>
          <div className={"overlay"} />
          <div className={"content"}>
            <h1 className={"title"}>{postTitle}</h1>
            <TextControl
              className={"subtitle"}
              value={subtitle}
              placeholder={__("Subtitle", "musille")}
              onChange={(subtitle) => setAttributes({ subtitle })}
            />
          </div>
          {showAttribution && image && (
            <div className={"attribution"}>{image.caption.raw}</div>
          )}
        </div>
      </Fragment>
    );
  },
  save() {
    return null;
  },
});

registerBlockStyle(BLOCK_NAME, {
  name: "basic",
  label: __("Basic", "musille"),
  isDefault: true,
});

registerBlockStyle(BLOCK_NAME, {
  name: "colored",
  label: __("Colored", "musille"),
});

registerBlockStyle(BLOCK_NAME, {
  name: "subtitle",
  label: __("With Subtitle", "musille"),
});

registerBlockStyle(BLOCK_NAME, {
  name: "fancy",
  label: __("Fancy", "musille"),
});
