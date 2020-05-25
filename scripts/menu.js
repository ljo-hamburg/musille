/**
 * This script manages the main menu. This boils down to two features:
 * - The sticky menu that gets enabled when scrolling.
 * - The mobile menu (hamburger menu) that can be shown by toggling a check box.
 */
(($) => {
  $(document).ready(() => {
    const $document = $(document);
    const $mainMenu = $(".main-menu");
    // Stick menu enabled when scrolling
    $document.scroll(() => {
      if ($document.scrollTop() >= 46) {
        $mainMenu.addClass("sticky");
      } else {
        $mainMenu.removeClass("sticky");
      }
    });
    // Hamburger Menu Toggle
    $mainMenu.find(".hamburger input[type=checkbox]").on("change", (event) => {
      if (event.target.checked) {
        $mainMenu.addClass("active");
      } else {
        $mainMenu.removeClass("active");
      }
    });
    // Submenu toggle in the hamburger menu
    $mainMenu.find("> .menu .menu-item-has-children").each((index, element) => {
      console.log(element);
      $(element).on("click", (event) => {
        if (element.classList.contains("expanded")) {
          element.classList.remove("expanded");
        } else {
          event.preventDefault();
          element.classList.add("expanded");
        }
      });
    });
  });
})(jQuery);
