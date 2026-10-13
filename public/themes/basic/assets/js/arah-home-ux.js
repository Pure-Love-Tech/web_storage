/**
 * Homepage-only accessibility and interaction refinements.
 * The original app.js remains the owner of upload / R2 business logic.
 */
(() => {
  "use strict";

  const body = document.body;
  if (!body.classList.contains("arah-home")) return;

  const keyboardClick = (element, label) => {
    if (!element) return;
    if (element.tagName !== "BUTTON" && element.tagName !== "A") {
      element.setAttribute("role", "button");
      element.tabIndex = 0;
    } else if (element.tagName === "A" && !element.hasAttribute("href")) {
      element.setAttribute("role", "button");
      element.tabIndex = 0;
    }
    if (label) element.setAttribute("aria-label", label);
    element.addEventListener("keydown", (event) => {
      if (event.target !== element || !["Enter", " "].includes(event.key)) return;
      // Native links and buttons already implement keyboard activation.
      if (element.tagName === "BUTTON" ||
          (element.tagName === "A" && element.hasAttribute("href"))) return;
      event.preventDefault();
      element.click();
    });
  };

  const focusable = (root) => Array.from(root.querySelectorAll(
    'a[href],button:not([disabled]),input:not([disabled]):not([type="hidden"]),select:not([disabled]),textarea:not([disabled]),[tabindex]:not([tabindex="-1"])'
  )).filter(el => el.getClientRects().length > 0 &&
    getComputedStyle(el).visibility !== "hidden" &&
    !el.closest('[aria-hidden="true"]'));

  const keepFocusInside = (event, root) => {
    if (event.key !== "Tab") return;
    const items = focusable(root);
    if (!items.length) {
      event.preventDefault();
      root.focus({ preventScroll: true });
      return;
    }
    const first = items[0];
    const last = items[items.length - 1];
    if (event.shiftKey && (document.activeElement === first || !root.contains(document.activeElement))) {
      event.preventDefault();
      last.focus();
    } else if (!event.shiftKey && (document.activeElement === last || !root.contains(document.activeElement))) {
      event.preventDefault();
      first.focus();
    }
  };

  // Mobile menu: meaningful keyboard controls, focus management, and Escape.
  const menu = document.querySelector(".nav-bar-menu");
  const trigger = document.querySelector(".nav-bar-menu-btn");
  const closeMenu = menu?.querySelector(".nav-bar-menu-close");
  const panel = menu?.querySelector(".nav-bar-links");
  const mobile = window.matchMedia("(max-width: 1199.98px)");
  if (menu && trigger && panel) {
    menu.id ||= "arah-mobile-menu";
    panel.setAttribute("aria-label", "Navigation");
    trigger.setAttribute("aria-controls", menu.id);
    trigger.setAttribute("aria-expanded", "false");
    keyboardClick(trigger, "Open menu");
    keyboardClick(closeMenu, "Close menu");

    const syncMenu = () => {
      const open = menu.classList.contains("show") && mobile.matches;
      const prior = trigger.getAttribute("aria-expanded") === "true";
      trigger.setAttribute("aria-expanded", String(open));
      if (open && !prior) closeMenu?.focus({ preventScroll: true });
      if (!open && prior && menu.contains(document.activeElement)) {
        trigger.focus({ preventScroll: true });
      }
    };
    const observer = new MutationObserver(syncMenu);
    observer.observe(menu, { attributes: true, attributeFilter: ["class"] });
    const handleResize = () => {
      if (!mobile.matches && menu.classList.contains("show")) {
        closeMenu?.click(); // Delegate to the existing menu close handler.
      }
      syncMenu();
    };
    mobile.addEventListener?.("change", handleResize);
    syncMenu();

    menu.querySelectorAll(".drop-down").forEach(dropdown => {
      const toggle = dropdown.querySelector(".drop-down-btn");
      const target = dropdown.querySelector(".drop-down-menu");
      if (!toggle || !target) return;
      keyboardClick(toggle);
      toggle.setAttribute("aria-haspopup", "true");
      toggle.setAttribute("aria-expanded", String(dropdown.classList.contains("active")));
      const dropdownObserver = new MutationObserver(() => {
        toggle.setAttribute("aria-expanded", String(dropdown.classList.contains("active")));
      });
      dropdownObserver.observe(dropdown, { attributes: true, attributeFilter: ["class"] });
    });
  }

  const uploadBox = document.querySelector(".uploadbox");
  const dialog = uploadBox?.querySelector(".uploadbox-content");
  const closeUpload = uploadBox?.querySelector(".btn-close");
  const uploadActions = Array.from(document.querySelectorAll("[data-upload-btn]"));
  if (uploadBox && dialog && closeUpload) {
    dialog.id = "arah-upload-dialog";
    dialog.setAttribute("role", "dialog");
    dialog.setAttribute("aria-modal", "true");
    dialog.tabIndex = -1;
    const heading = dialog.querySelector(".uploadbox-header .h5");
    if (heading) {
      heading.id = "arah-upload-title";
      dialog.setAttribute("aria-labelledby", heading.id);
    }

    const announcer = document.createElement("span");
    announcer.className = "arah-ux-sr";
    announcer.setAttribute("role", "status");
    announcer.setAttribute("aria-live", "polite");
    announcer.setAttribute("aria-atomic", "true");
    dialog.appendChild(announcer);

    let lastOpener = null;
    let isOpen = false;
    let previousProgress = "";
    let previousBusy = false;
    uploadActions.forEach(action => action.setAttribute("aria-expanded", "false"));

    document.addEventListener("click", event => {
      const opener = event.target.closest?.("[data-upload-btn]");
      if (opener && !uploadBox.classList.contains("active")) lastOpener = opener;
    }, true);

    // Dropzone's existing click handling remains in app.js.
    uploadBox.querySelectorAll("[data-dz-click]").forEach(element => {
      const label = element.querySelector("h3")?.textContent.trim() ||
                    element.textContent.trim() || heading?.textContent.trim();
      keyboardClick(element, label);
    });
    keyboardClick(uploadBox.querySelector("[data-dz-reset]"));
    const submit = uploadBox.querySelector("#upload-files-btn");
    submit?.setAttribute("aria-controls", "dropzone");

    const syncDialog = () => {
      const open = uploadBox.classList.contains("active");
      uploadActions.forEach(action => action.setAttribute("aria-expanded", String(open)));
      if (open && !isOpen) closeUpload.focus({ preventScroll: true });
      if (!open && isOpen) {
        announcer.textContent = "";
        previousProgress = "";
        previousBusy = false;
        if (lastOpener?.isConnected && lastOpener.getClientRects().length) {
          lastOpener.focus({ preventScroll: true });
        } else {
          uploadActions.find(action => action.getClientRects().length)?.focus({ preventScroll: true });
        }
        lastOpener = null;
      }
      isOpen = open;
    };
    const dialogObserver = new MutationObserver(syncDialog);
    dialogObserver.observe(uploadBox, { attributes: true, attributeFilter: ["class"] });
    syncDialog();

    // Announce status transitions, not each byte-progress event.
    const contentObserver = new MutationObserver(() => {
      const busy = Boolean(submit?.disabled);
      dialog.setAttribute("aria-busy", String(busy));
      if (!isOpen) return;
      const statuses = Array.from(dialog.querySelectorAll(".direct-upload-status"))
        .map(item => item.textContent.trim()).filter(Boolean);
      const current = statuses.find(status => status !== previousProgress) || statuses[0] || "";
      if (current && current !== previousProgress) {
        previousProgress = current;
        announcer.textContent = current;
      }
      if (busy !== previousBusy) previousBusy = busy;
      dialog.querySelectorAll(".dz-error-message").forEach(element => {
        if (!element.hasAttribute("role")) element.setAttribute("role", "alert");
      });
    });
    contentObserver.observe(dialog, { subtree: true, childList: true, attributes: true, attributeFilter: ["disabled"] });

    document.addEventListener("keydown", event => {
      if (uploadBox.classList.contains("active")) {
        if (event.key === "Escape") {
          event.preventDefault();
          closeUpload.click(); // Existing handler retains its pending-upload confirmation.
        } else keepFocusInside(event, dialog);
        return;
      }
      if (!mobile.matches || !menu?.classList.contains("show")) return;
      if (event.key === "Escape") {
        event.preventDefault();
        closeMenu?.click();
      } else keepFocusInside(event, panel);
    });
  } else {
    // Homepages without upload permission still need accessible mobile navigation.
    document.addEventListener("keydown", event => {
      if (!mobile.matches || !menu?.classList.contains("show")) return;
      if (event.key === "Escape") { event.preventDefault(); closeMenu?.click(); }
      else keepFocusInside(event, panel);
    });
  }
})();
