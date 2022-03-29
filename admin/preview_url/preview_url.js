window.addEventListener("load", () => {
  changePreviewButtonBehavior();
});

/**
 *
 * Changes preview behavior by:
 *
 * * Making sure, we are in edit pages
 * * Preventing react behaviour of opening dropdown for selecting device type
 * * Creating a front-end URL to catch preview data from db
 * * Opening the front-end URL with "is-current-preview" flag
 *
 */
let previewWindow = null;
const wpPreviewBase = window.location.origin + "/wp-json/esd/v1/preview/";
const frontEndBase = "http://localhost:3000/";
let isPageEditPage;
let currentPost;

/**
 *
 */
const changePreviewButtonBehavior = async () => {
  currentPost = wp.data.select("core/editor").getCurrentPost();
  const url = new URL(location);
  const urlParams = new URLSearchParams(url.search);
  const isPostNewPage = url.pathname.includes("post-new.php");
  const isPostActionEditPage = url.pathname.includes("post.php") && urlParams.get("action") == "edit";
  isPageEditPage = urlParams.get("post_type") == "page";

  // we're in the admin edit pages
  if (!(isPostNewPage || isPostActionEditPage)) return;
  const headerPostSettings = document.querySelector(".edit-post-header__settings");
  const buttonToggle = headerPostSettings.querySelector(".block-editor-post-preview__button-toggle");

  // there is no "vista previa" button
  if (!buttonToggle) return;
  removeDefaultReactBehavior(buttonToggle);

  // event
  buttonToggle.addEventListener("click", async (ev) => {
    ev.preventDefault();
    await wp.data.dispatch("core/editor").autosave();
    managePreviewWindow();
  });
};

/**
 *
 */
const createPreviewFrontEndUrl = async () => {
  const post = wp.data.select("core/editor").getCurrentPost();
  console.log(post == currentPost);
  const urlData = await fetch(wpPreviewBase + post.id)
    .then((d) => d.json())
    .then((d) => d);

  const isPost = urlData.type == "post" ? "posts/" : "";
  const isNewPostOrPage = !isPageEditPage ? "posts/" : "";
  const url = new URL(frontEndBase);
  url.pathname = urlData.slug ? `${isPost}${urlData.slug}` : `${isNewPostOrPage}${urlData.requested_id}`;
  url.searchParams.append("preview", true);
  url.searchParams.append("new_post", urlData.slug == null);
  return url;
};

/**
 *
 */
const managePreviewWindow = async () => {
  const url = await createPreviewFrontEndUrl();
  if (!previewWindow) {
    previewWindow = window.open(await createPreviewFrontEndUrl(), "_blank");
    previewWindow.focus();
    previewWindow.postMessage("reload", url.href);
  } else {
    if (!previewWindow.closed) {
      previewWindow.focus();
      previewWindow.postMessage("reload", url.href);
    } else {
      previewWindow = null;
      managePreviewWindow();
    }
  }
};

/**
 *
 */
const removeDefaultReactBehavior = (buttonToggle) => {
  const props = Object.entries(buttonToggle);
  const propIndex = props.findIndex((prop) => prop[0].includes("reactProps"));
  if (propIndex > -1) {
    delete props[propIndex][1].onClick;
    delete props[propIndex][1].onKeyDown;
  }
};
