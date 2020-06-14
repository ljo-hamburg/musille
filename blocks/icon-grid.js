import React, { useState } from "react";
import { __ } from "@wordpress/i18n";
import { registerBlockType } from "@wordpress/blocks";
import {
  AlignmentToolbar,
  BlockControls,
  InnerBlocks,
  InspectorControls,
  RichText,
  __experimentalLinkControl as LinkControl,
} from "@wordpress/block-editor";
import FontIconPicker from "@fonticonpicker/react-fonticonpicker";
import icons from "./data/icons";
import {
  BaseControl,
  KeyboardShortcuts,
  PanelBody,
  Popover,
  ToolbarButton,
  ToolbarGroup,
} from "@wordpress/components";
import classnames from "classnames";
import { rawShortcut, displayShortcut } from "@wordpress/keycodes";
import { link } from "@wordpress/icons";

const GRID_BLOCK_NAME = "musille/icon-grid";
const ICON_BLOCK_NAME = "musille/icon-grid-icon";
const NEW_TAB_REL = "noreferrer noopener";

/**
 * Turns the block into a link by providing a link-editing interface.
 * @constructor
 */
function URLPicker({
  isSelected,
  url,
  setAttributes,
  opensInNewTab,
  onToggleOpenInNewTab,
}) {
  const [isURLPickerOpen, setIsURLPickerOpen] = useState(false);
  const openLinkControl = () => {
    setIsURLPickerOpen(true);
    return false;
  };
  const linkControl = isURLPickerOpen && (
    <Popover position="bottom center" onClose={() => setIsURLPickerOpen(false)}>
      <LinkControl
        className="wp-block-navigation-link__inline-link-input"
        value={{ url, opensInNewTab }}
        onChange={({ url: newURL = "", opensInNewTab: newOpensInNewTab }) => {
          setAttributes({ url: newURL });

          if (opensInNewTab !== newOpensInNewTab) {
            onToggleOpenInNewTab(newOpensInNewTab);
          }
        }}
      />
    </Popover>
  );
  return (
    <>
      <BlockControls>
        <ToolbarGroup>
          <ToolbarButton
            name="link"
            icon={link}
            title={__("Link")}
            shortcut={displayShortcut.primary("k")}
            onClick={openLinkControl}
          />
        </ToolbarGroup>
      </BlockControls>
      {isSelected && (
        <KeyboardShortcuts
          bindGlobal
          shortcuts={{
            [rawShortcut.primary("k")]: openLinkControl,
          }}
        />
      )}
      {linkControl}
    </>
  );
}

/**
 * Register the icon grid block. This serves mainly as a wrapper around the individual
 * icon grid icons.
 */
registerBlockType(GRID_BLOCK_NAME, {
  title: __("Icon Grid", "musille"),
  description: __("A list of action icons.", "musille"),
  category: "formatting",
  icon: "tagcloud",
  edit({ className }) {
    return (
      <div className={className}>
        <InnerBlocks
          allowedBlocks={["wp-concerts/icon-grid-icon"]}
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
 * A single icon in a grid of icons.
 */
registerBlockType(ICON_BLOCK_NAME, {
  title: __("Icon", "musille"),
  description: __("An Action Item", "musille"),
  category: "formatting",
  icon: "admin-links",
  parent: ["musille/icon-grid"],
  attributes: {
    icon: {
      type: "string",
      default: "fas fa-coffee",
    },
    title: {
      type: "string",
    },
    description: {
      type: "string",
    },
    align: {
      type: "string",
      default: "center",
    },
    url: {
      type: "string",
    },
    linkTarget: {
      type: "string",
    },
    rel: {
      type: "string",
    },
  },
  edit({
    className,
    attributes: { icon, title, description, align, url, linkTarget },
    setAttributes,
    isSelected,
  }) {
    console.log(align);
    return (
      <>
        <InspectorControls>
          <PanelBody>
            <BaseControl label={__("Icon", "musille")}>
              <FontIconPicker
                icons={icons}
                value={icon}
                onChange={(icon) => setAttributes({ icon })}
                isMulti={false}
                allCatPlaceholder={__("All Categories", "musille")}
                searchPlaceholder={__("Search", "musille")}
                noIconPlaceholder={__("No Icons Found", "musille")}
              />
            </BaseControl>
          </PanelBody>
        </InspectorControls>
        <URLPicker
          url={url}
          setAttributes={setAttributes}
          isSelected={isSelected}
          opensInNewTab={linkTarget === "_blank"}
          onToggleOpenInNewTab={(value) => {
            const linkTarget = value ? "_blank" : undefined;
            let rel = linkTarget ? NEW_TAB_REL : undefined;
            setAttributes({ linkTarget, rel });
          }}
        />
        <BlockControls>
          <AlignmentToolbar
            value={align}
            onChange={(align) => setAttributes({ align })}
          />
        </BlockControls>
        <div
          className={classnames(
            className,
            align && `text-align-${align}`,
            !url && "disabled"
          )}
        >
          <i className={icon} />
          <RichText
            tagName="h3"
            className="title"
            value={title}
            allowedFormats={[]}
            onChange={(title) => setAttributes({ title })}
            placeholder={__("Title", "musille")}
          />
          <RichText
            tagName="div"
            className="description"
            value={description}
            allowedFormats={["core/text-color", "core/bold", "core/italic"]}
            onChange={(description) => setAttributes({ description })}
            placeholder={__("Description", "musille")}
          />
        </div>
      </>
    );
  },
  save({
    attributes: { icon, title, description, align, url, linkTarget, rel },
  }) {
    const content = (
      <>
        <i className={icon} />
        <RichText.Content tagName="h3" className="title" value={title} />
      </>
    );

    return (
      <div
        className={classnames(
          align && `text-align-${align}`,
          !url && "disabled"
        )}
      >
        {url && (
          <a href={url} target={linkTarget} rel={rel}>
            {content}
          </a>
        )}
        {!url && content}
        {description && (
          <RichText.Content
            tagName="div"
            className="description"
            value={description}
          />
        )}
      </div>
    );
  },
});
