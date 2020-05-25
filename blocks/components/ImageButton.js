import React from "react";
import PropTypes from "prop-types";
import { Button, ResponsiveWrapper, Spinner } from "@wordpress/components";

/**
 * A React component that lets the user choose an image in the Gutenberg Editor. This
 * component is meant to be used in the editor controls.
 *
 * @component
 * @example
 * let image = {...};
 * let imageID = 123;
 * return (<ImageButton image={image}
 *                      imageID={imageID}
 *                      onClick={...}>Select an Image</ImageButton>)
 */
export default function ImageButton({ image, imageID, onClick, children }) {
  if (image) {
    return (
      <Button
        className={"editor-post-featured-image__preview"}
        onClick={onClick}
      >
        <ResponsiveWrapper
          naturalWidth={image.media_details.width}
          naturalHeight={image.media_details.height}
        >
          <img src={image.source_url} alt={image.alt_text || image.title.raw} />
        </ResponsiveWrapper>
      </Button>
    );
  }
  if (imageID) {
    return (
      <Button className={"editor-post-featured-image__preview"}>
        <Spinner />
      </Button>
    );
  }
  return (
    <Button className={"editor-post-featured-image__toggle"} onClick={onClick}>
      {children}
    </Button>
  );
}

ImageButton.propTypes = {
  /**
   * The ID of the image currently being displayed. If an ID exists but no `image` a
   * loading spinner is displayed.
   */
  imageID: PropTypes.number,
  /**
   * The image that is currently being displayed (or a falsy value if no image is
   * selected).
   */
  image: PropTypes.shape({
    alt_text: PropTypes.string,
    title: PropTypes.shape({
      raw: PropTypes.string,
      rendered: PropTypes.string,
    }),
    media_details: PropTypes.shape({
      width: PropTypes.number,
      height: PropTypes.number,
    }),
    source_url: PropTypes.string,
  }),
  /**
   * A callback function that is invoked when the user clicks the button.
   */
  onClick: PropTypes.func,
  /**
   * The button's content when no image and no loading indicator is being displayed.
   * Usually this contains a single line of text.
   */
  children: PropTypes.node,
};

ImageButton.defaultProps = {
  onClick: () => {},
};
