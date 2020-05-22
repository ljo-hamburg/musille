(($) => {
  $(document).ready(() => {
    const $document = $(document);
    const $mainMenu = $(".main-menu");
    $document.scroll(() => {
      if ($document.scrollTop() >= 46) {
        $mainMenu.addClass("sticky");
      } else {
        $mainMenu.removeClass("sticky");
      }
    });
    $mainMenu.find(".hamburger input[type=checkbox]").on("change", (event) => {
      if (event.target.checked) {
        $mainMenu.addClass("active");
      } else {
        $mainMenu.removeClass("active");
      }
    });
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
