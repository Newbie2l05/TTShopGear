document.addEventListener("DOMContentLoaded", function () {
  const searchOverlay = document.querySelector("[data-search-overlay]");
  const searchOpenButton = document.querySelector("[data-search-open]");
  const searchCloseButtons = Array.from(document.querySelectorAll("[data-search-close]"));

  if (searchOverlay && searchOpenButton) {
    const searchInput = searchOverlay.querySelector('input[type="search"]');
    const liveSearchForm = searchOverlay.querySelector("[data-live-search-form]");
    const liveSearchResults = searchOverlay.querySelector("[data-live-search-results]");
    let liveSearchTimerId = null;
    let liveSearchController = null;

    const escapeHtml = function (value) {
      const node = document.createElement("div");
      node.textContent = value || "";
      return node.innerHTML;
    };

    const clearLiveSearch = function () {
      if (!liveSearchResults) {
        return;
      }

      liveSearchResults.hidden = true;
      liveSearchResults.innerHTML = "";
    };

    const renderLiveSearchMessage = function (message) {
      if (!liveSearchResults) {
        return;
      }

      liveSearchResults.hidden = false;
      liveSearchResults.innerHTML = '<div class="tt-live-search-message">' + escapeHtml(message) + "</div>";
    };

    const renderLiveSearchProducts = function (products) {
      if (!liveSearchResults) {
        return;
      }

      if (!products.length) {
        renderLiveSearchMessage(ttshopgearTheme.labels.searchEmpty);
        return;
      }

      liveSearchResults.hidden = false;
      liveSearchResults.innerHTML = products
        .map(function (product) {
          const image = product.imageUrl
            ? '<img src="' + escapeHtml(product.imageUrl) + '" alt="">'
            : '<span class="tt-live-search-fallback">' + escapeHtml(product.name.slice(0, 1)) + "</span>";

          return (
            '<a href="' +
            escapeHtml(product.url) +
            '" class="tt-live-search-item">' +
            '<span class="tt-live-search-thumb">' +
            image +
            "</span>" +
            '<span class="tt-live-search-copy">' +
            "<strong>" +
            escapeHtml(product.name) +
            "</strong>" +
            "<small>" +
            escapeHtml(product.category) +
            "</small>" +
            "</span>" +
            '<span class="tt-live-search-price">' +
            escapeHtml(product.price) +
            "</span>" +
            "</a>"
          );
        })
        .join("");
    };

    const requestLiveSearch = function (query) {
      if (!liveSearchResults || !window.ttshopgearTheme) {
        return;
      }

      if (liveSearchController) {
        liveSearchController.abort();
      }

      liveSearchController = new AbortController();
      renderLiveSearchMessage(ttshopgearTheme.labels.searchLoading);

      const body = new URLSearchParams({
        action: "ttshopgear_live_search",
        nonce: ttshopgearTheme.nonce,
        query: query,
      });

      fetch(ttshopgearTheme.ajaxUrl, {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8",
        },
        body: body.toString(),
        signal: liveSearchController.signal,
      })
        .then(function (response) {
          return response.json();
        })
        .then(function (payload) {
          if (!payload.success) {
            renderLiveSearchMessage(ttshopgearTheme.labels.searchEmpty);
            return;
          }

          renderLiveSearchProducts(payload.data.products || []);
        })
        .catch(function (error) {
          if (error.name !== "AbortError") {
            renderLiveSearchMessage(ttshopgearTheme.labels.searchEmpty);
          }
        });
    };

    const closeSearch = function () {
      searchOverlay.hidden = true;
      document.body.classList.remove("tt-overlay-open");
      clearLiveSearch();

      if (searchInput) {
        searchInput.value = "";
      }
    };

    const openSearch = function () {
      searchOverlay.hidden = false;
      document.body.classList.add("tt-overlay-open");

      if (searchInput) {
        window.setTimeout(function () {
          searchInput.focus();
        }, 40);
      }
    };

    searchOpenButton.addEventListener("click", openSearch);

    searchCloseButtons.forEach(function (button) {
      button.addEventListener("click", closeSearch);
    });

    if (searchInput) {
      searchInput.addEventListener("input", function () {
        const query = searchInput.value.trim();

        window.clearTimeout(liveSearchTimerId);

        if (query.length < 2) {
          clearLiveSearch();
          return;
        }

        liveSearchTimerId = window.setTimeout(function () {
          requestLiveSearch(query);
        }, 220);
      });
    }

    if (liveSearchForm) {
      liveSearchForm.addEventListener("submit", function () {
        clearLiveSearch();
      });
    }

    document.addEventListener("keydown", function (event) {
      if (event.key === "Escape" && !searchOverlay.hidden) {
        closeSearch();
      }
    });
  }

  const toast = document.querySelector("[data-toast]");
  let toastTimerId = null;

  const showToast = function (message, variant) {
    if (!toast) {
      return;
    }

    window.clearTimeout(toastTimerId);
    toast.textContent = message;
    toast.classList.toggle("is-error", variant === "error");
    toast.hidden = false;

    requestAnimationFrame(function () {
      toast.classList.add("is-visible");
    });

    toastTimerId = window.setTimeout(function () {
      toast.classList.remove("is-visible");

      window.setTimeout(function () {
        toast.hidden = true;
      }, 220);
    }, 2400);
  };

  document.addEventListener("click", function (event) {
    const logoutLink = event.target.closest("[data-logout-confirm]");

    if (logoutLink && window.ttshopgearTheme) {
      if (!window.confirm(ttshopgearTheme.labels.logoutConfirm)) {
        event.preventDefault();
      }

      return;
    }

    const button = event.target.closest("[data-add-to-cart]");

    if (!button || !window.ttshopgearTheme) {
      return;
    }

    event.preventDefault();

    if (button.disabled) {
      return;
    }

    const originalLabel = button.getAttribute("aria-label") || ttshopgearTheme.labels.addToCart;

    button.disabled = true;
    button.classList.add("is-loading");
    button.setAttribute("aria-label", ttshopgearTheme.labels.addingToCart);

    const body = new URLSearchParams({
      action: "ttshopgear_add_to_cart",
      nonce: ttshopgearTheme.nonce,
      productId: button.getAttribute("data-product-id") || "",
    });

    fetch(ttshopgearTheme.ajaxUrl, {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8",
      },
      body: body.toString(),
    })
      .then(function (response) {
        return response.json();
      })
      .then(function (payload) {
        if (!payload.success) {
          throw new Error("add_to_cart_failed");
        }

        document.querySelectorAll(".tt-cart-count").forEach(function (node) {
          node.textContent = String(payload.data.cartCount || 0);
        });

        showToast(ttshopgearTheme.labels.addedToCart);
      })
      .catch(function () {
        showToast(ttshopgearTheme.labels.addToCartError, "error");
      })
      .finally(function () {
        button.disabled = false;
        button.classList.remove("is-loading");
        button.setAttribute("aria-label", originalLabel);
      });
  });

  const mobileToggle = document.querySelector("[data-mobile-toggle]");
  const mobileMenu = document.querySelector("[data-mobile-menu]");

  if (mobileToggle && mobileMenu) {
    mobileToggle.addEventListener("click", function () {
      const isOpen = mobileMenu.classList.toggle("is-open");
      mobileToggle.classList.toggle("is-open", isOpen);
      mobileToggle.setAttribute("aria-expanded", isOpen ? "true" : "false");
    });
  }

  const slideNodes = Array.from(document.querySelectorAll("[data-slide]"));
  const productNodes = Array.from(document.querySelectorAll("[data-product-slide]"));
  const dotNodes = Array.from(document.querySelectorAll("[data-hero-dot]"));
  const heroBackground = document.querySelector("[data-hero-bg]");
  const heroGlow = document.querySelector("[data-hero-glow]");
  const prevButton = document.querySelector("[data-hero-prev]");
  const nextButton = document.querySelector("[data-hero-next]");

  if (slideNodes.length) {
    let currentIndex = 0;
    let timerId = null;

    const applySlideState = function (index) {
      currentIndex = (index + slideNodes.length) % slideNodes.length;

      slideNodes.forEach(function (node, nodeIndex) {
        node.classList.toggle("is-active", nodeIndex === currentIndex);
      });

      productNodes.forEach(function (node, nodeIndex) {
        node.classList.toggle("is-active", nodeIndex === currentIndex);
      });

      dotNodes.forEach(function (node, nodeIndex) {
        node.classList.toggle("is-active", nodeIndex === currentIndex);
      });

      const activeSlide = slideNodes[currentIndex];
      const gradient = activeSlide.getAttribute("data-gradient") || "primary";
      const accent = activeSlide.getAttribute("data-accent") || "primary";

      if (heroBackground) {
        heroBackground.setAttribute("data-gradient", gradient);
      }

      if (heroGlow) {
        heroGlow.setAttribute("data-accent", accent);
      }
    };

    const startTimer = function () {
      window.clearInterval(timerId);
      timerId = window.setInterval(function () {
        applySlideState(currentIndex + 1);
      }, 6000);
    };

    dotNodes.forEach(function (dot, index) {
      dot.addEventListener("click", function () {
        applySlideState(index);
        startTimer();
      });
    });

    if (prevButton) {
      prevButton.addEventListener("click", function () {
        applySlideState(currentIndex - 1);
        startTimer();
      });
    }

    if (nextButton) {
      nextButton.addEventListener("click", function () {
        applySlideState(currentIndex + 1);
        startTimer();
      });
    }

    applySlideState(0);
    startTimer();
  }

  const newsletterForm = document.querySelector("[data-newsletter-form]");
  const newsletterSuccess = document.querySelector("[data-newsletter-success]");

  if (newsletterForm && newsletterSuccess) {
    newsletterForm.addEventListener("submit", function (event) {
      event.preventDefault();

      const emailInput = newsletterForm.querySelector('input[type="email"]');

      if (!emailInput || !emailInput.value.trim()) {
        return;
      }

      newsletterForm.hidden = true;
      newsletterSuccess.hidden = false;
      newsletterForm.reset();
    });
  }

  /* ============================
     AUTH TABS: Login / Register
     ============================ */
  const switchAuthPanel = function (target) {
    var panels = document.querySelectorAll("[data-auth-panel]");
    var tabs = document.querySelectorAll("[data-auth-tab]");

    panels.forEach(function (panel) {
      panel.classList.toggle("is-active", panel.getAttribute("data-auth-panel") === target);
    });

    tabs.forEach(function (tab) {
      tab.classList.toggle("is-active", tab.getAttribute("data-auth-tab") === target);
    });
  };

  document.querySelectorAll("[data-auth-tab]").forEach(function (tab) {
    tab.addEventListener("click", function () {
      switchAuthPanel(tab.getAttribute("data-auth-tab"));
    });
  });

  document.querySelectorAll("[data-auth-switch]").forEach(function (link) {
    link.addEventListener("click", function (e) {
      e.preventDefault();
      switchAuthPanel(link.getAttribute("data-auth-switch"));
    });
  });

  /* ============================
     PASSWORD TOGGLE
     ============================ */
  document.querySelectorAll("[data-pw-toggle]").forEach(function (btn) {
    btn.addEventListener("click", function () {
      var inputId = btn.getAttribute("data-pw-toggle");
      var input = document.getElementById(inputId);

      if (!input) {
        return;
      }

      var isPassword = input.type === "password";
      input.type = isPassword ? "text" : "password";
      btn.classList.toggle("is-visible", isPassword);
      btn.setAttribute("aria-label", isPassword ? "Ẩn mật khẩu" : "Hiện mật khẩu");
      btn.setAttribute("aria-pressed", isPassword ? "true" : "false");
    });
  });
  /* ============================
     CHECKOUT: VN ADMIN UNITS
     ============================ */
  const checkoutForm = document.querySelector("form.checkout.woocommerce-checkout.tt-checkout-layout");

  if (checkoutForm && window.ttshopgearTheme && window.ttshopgearTheme.vnUnitsUrl) {
    let vnUnitsPromise = null;

    const setSubmittingState = function (isSubmitting) {
      checkoutForm.classList.toggle("is-submitting", isSubmitting);

      const placeOrderButton = document.getElementById("place_order");

      if (placeOrderButton) {
        placeOrderButton.classList.toggle("is-loading", isSubmitting);
        placeOrderButton.setAttribute("aria-busy", isSubmitting ? "true" : "false");
      }
    };

    const fetchVnUnits = function () {
      if (!vnUnitsPromise) {
        vnUnitsPromise = fetch(window.ttshopgearTheme.vnUnitsUrl)
          .then(function (response) {
            if (!response.ok) {
              throw new Error("vn_units_fetch_failed");
            }

            return response.json();
          })
          .catch(function () {
            return [];
          });
      }

      return vnUnitsPromise;
    };

    const renderSelectOptions = function (select, items, placeholder, selectedValue) {
      if (!select) {
        return;
      }

      const fragment = document.createDocumentFragment();
      const placeholderOption = document.createElement("option");
      placeholderOption.value = "";
      placeholderOption.textContent = placeholder;
      fragment.appendChild(placeholderOption);

      items.forEach(function (item) {
        const option = document.createElement("option");
        option.value = item.value;
        option.textContent = item.label;
        option.selected = item.value === selectedValue;
        fragment.appendChild(option);
      });

      select.innerHTML = "";
      select.appendChild(fragment);
      select.value = selectedValue || "";
    };

    const updateWardOptions = function (units, provinceField, wardField, selectedWard) {
      const provinceCode = provinceField.value || "";
      const selectedProvince = units.find(function (province) {
        return province.Code === provinceCode;
      });

      if (!selectedProvince) {
        renderSelectOptions(wardField, [], window.ttshopgearTheme.labels.chooseWardFirst, "");
        wardField.disabled = true;
        return;
      }

      renderSelectOptions(
        wardField,
        (selectedProvince.Wards || []).map(function (ward) {
          return {
            value: ward.FullName,
            label: ward.FullName,
          };
        }),
        window.ttshopgearTheme.labels.chooseWard,
        selectedWard || ""
      );

      wardField.disabled = false;
    };

    const initCheckoutLocationFields = function () {
      const provinceField = document.getElementById("billing_city");
      const wardField = document.getElementById("billing_state");

      if (!provinceField || !wardField) {
        return;
      }

      fetchVnUnits().then(function (units) {
        if (!Array.isArray(units) || !units.length) {
          return;
        }

        const currentProvinceValue = provinceField.getAttribute("data-selected-value") || provinceField.value || "";
        const currentWardValue = wardField.getAttribute("data-selected-value") || wardField.value || "";
        const matchedProvince = units.find(function (province) {
          return province.Code === currentProvinceValue || province.FullName === currentProvinceValue;
        });
        const resolvedProvinceValue = matchedProvince ? matchedProvince.Code : "";

        renderSelectOptions(
          provinceField,
          units.map(function (province) {
            return {
              value: province.Code,
              label: province.FullName,
            };
          }),
          window.ttshopgearTheme.labels.chooseProvince,
          resolvedProvinceValue
        );

        updateWardOptions(units, provinceField, wardField, currentWardValue);

        if (provinceField.dataset.ttBound !== "true") {
          provinceField.dataset.ttBound = "true";
          provinceField.addEventListener("change", function () {
            updateWardOptions(units, provinceField, wardField, "");
            wardField.dispatchEvent(new Event("change", { bubbles: true }));
          });
        }

        provinceField.setAttribute("data-selected-value", provinceField.value || "");
        wardField.setAttribute("data-selected-value", wardField.value || "");
      });
    };

    checkoutForm.addEventListener("submit", function () {
      setSubmittingState(true);
    });

    document.addEventListener("change", function (event) {
      if (event.target && (event.target.id === "billing_city" || event.target.id === "billing_state")) {
        event.target.setAttribute("data-selected-value", event.target.value || "");
      }
    });

    if (window.jQuery) {
      window.jQuery(document.body).on("updated_checkout", function () {
        initCheckoutLocationFields();
        setSubmittingState(false);
      });

      window.jQuery(document.body).on("checkout_error", function () {
        setSubmittingState(false);
      });
    }

    initCheckoutLocationFields();
  }
});
