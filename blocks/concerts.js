import React from "react";
import { __ } from "@wordpress/i18n";
import { InspectorControls } from "@wordpress/block-editor";
import { PanelBody, ToggleControl } from "@wordpress/components";
import { addFilter } from "@wordpress/hooks";
import { createHigherOrderComponent } from "@wordpress/compose";
import { select } from "@wordpress/data";

const SKIP_BLOCKS = ["musille/header"];
const CLASS_NAME = "in-sidebar";

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

/**
 * Adds a filter that makes sure that the `in-sidebar` attribute is persisted in form of
 * a class that is added to the block's root element.
 */
addFilter(
  "blocks.getSaveContent.extraProps",
  "wp-concerts/with-sidebar-toggle",
  (props, name, { sidebar }) => {
    if (SKIP_BLOCKS.includes(name)) {
      return props;
    }
    let classes = props.className ? props.className.split(" ") : [];
    if (sidebar) {
      if (!classes.includes(CLASS_NAME)) {
        classes.push(CLASS_NAME);
      }
    } else {
      classes = classes.filter((x) => x !== CLASS_NAME);
    }
    props.className = classes.join(" ");
    return props;
  }
);
