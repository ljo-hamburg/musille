import React from "react";
import { __ } from "@wordpress/i18n";
import { InspectorControls } from "@wordpress/block-editor";
import { PanelBody, ToggleControl } from "@wordpress/components";
import { addFilter } from "@wordpress/hooks";
import { createHigherOrderComponent } from "@wordpress/compose";
import { select } from "@wordpress/data";

const SKIP_BLOCKS = ["musille/header"];

/**
 * Adds a panel to the inspector controls for each root block that contains a toggle
 * allowing the user to move a block to the sidebar.
 */
addFilter(
  "editor.BlockEdit",
  "wp-concerts/with-sidebar-toggle",
  createHigherOrderComponent((BlockEdit) => {
    return (props) => {
      if (SKIP_BLOCKS.includes(props.name)) {
        return <BlockEdit {...props} />;
      }

      const { attributes, setAttributes } = props;
      const { sidebar } = attributes;

      const rootClientId = select(
        "core/block-editor"
      ).getBlockHierarchyRootClientId(props.clientId);
      if (rootClientId !== props.clientId) {
        return <BlockEdit {...props} />;
      }
      return (
        <>
          <BlockEdit {...props} />
          <InspectorControls>
            <PanelBody title={__("Appearance", "musille")}>
              <ToggleControl
                label={__("Show in sidebar", "musille")}
                help={__(
                  "Show this block in the sidebar if the screen is large enough",
                  "musille"
                )}
                checked={sidebar}
                onChange={(sidebar) => setAttributes({ sidebar })}
              />
            </PanelBody>
          </InspectorControls>
        </>
      );
    };
  }, "withSidebarToggle")
);

/**
 * Adds a filter to block registration that adds a `sidebar` attribute to each block
 * type.
 */
addFilter(
  "blocks.registerBlockType",
  "wp-concerts/with-sidebar-toggle",
  (props, name) => {
    if (SKIP_BLOCKS.includes(name)) {
      return props;
    }
    props.attributes.sidebar = {
      type: "boolean",
      default: false,
    };
    return props;
  }
);
