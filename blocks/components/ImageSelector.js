import React from "react";
import PropTypes from "prop-types";
import { MediaUpload, MediaUploadCheck } from "@wordpress/block-editor";
import { Button } from "@wordpress/components";
import ImageButton from "./ImageButton";
import { useSelect } from "@wordpress/data";

/**
 * A React component that lets the user select an image.
 *
 * @component
 * @example
 * let imageID = 123;
 * return <ImageSelector action={"Select an image"}
 *                       removeAction={"Remove Image"}
 *                       authMessage={"Login to upload images"}
 *                       imageID={imageID}
 *                       onChange={media => {...}} />
 */
export default function ImageSelector({
  action,
  removeAction,
  prompt,
  authMessage,
  imageID,
  onChange,
}) {
  const image = useSelect(
    (select) => {
      return select("core").getMedia(imageID);
    },
    [imageID]
  );
  return (
    <>
      <MediaUploadCheck fallback={authMessage}>
        <MediaUpload
          title={prompt}
          onSelect={(media) => onChange(media)}
          allowedTypes={["image"]}
          value={imageID}
          render={({ open }) => (
            <ImageButton imageID={imageID} image={image} onClick={open}>
              {action}
            </ImageButton>
          )}
        />
      </MediaUploadCheck>
      {removeAction && !!imageID && (
        <MediaUploadCheck>
          <Button onClick={() => onChange(null)} isLink isDestructive>
            {removeAction}
          </Button>
        </MediaUploadCheck>
      )}
    </>
  );
}

ImageSelector.propTypes = {
  /**
   * The prompt displayed in the image selection dialog. The prompt is optional.
   */
  prompt: PropTypes.string,
  /**
   * The string on the button prompting the user to choose an image.
   */
  action: PropTypes.string,
  /**
   * An action text prompting the user to remove the selected image. If no
   * `removeAction` is specified the remove button will not be shown.
   */
  removeAction: PropTypes.string,
  /**
   * A message telling the user to authorize before uploading images.
   */
  authMessage: PropTypes.node,
  /**
   * The ID of the currently selected image.
   */
  imageID: PropTypes.number,
  /**
   * A callback function that is called when the user selects an image.
   *
   * @param {object} media The image selected by the user or `null` if the image was
   *                       removed.
   */
  onChange: PropTypes.func,
};

ImageSelector.defaultProps = {
  prompt: undefined,
  onChange: () => {},
};
