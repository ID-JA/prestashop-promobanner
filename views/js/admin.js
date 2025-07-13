$(document).ready(function () {
  const inputs = {
    enabled: $('input[name="PROMOBANNER_ENABLED"]'),
    displayMode: $('select[name="PROMOBANNER_DISPLAY_MODE"]'),
    autoHeight: $('input[name="PROMOBANNER_HEIGHT_AUTO"]'),
    autoWidth: $('input[name="PROMOBANNER_WIDTH_AUTO"]'),
    contentAlignment: $('select[name="PROMOBANNER_CONTENT_ALIGNMENT"]'),
    title: $('textarea[name="PROMOBANNER_TITLE"]'),
    subtitle: $('textarea[name="PROMOBANNER_SUBTITLE"]'),
    showCta: $('input[name="PROMOBANNER_SHOW_CTA"]'),
    link: $('input[name="PROMOBANNER_LINK"]'),
    bgType: $('select[name="PROMOBANNER_BG_TYPE"]'),
    bgSolid: $('input[name="PROMOBANNER_BG_SOLID"]'),
    bgGradientStart: $('input[name="PROMOBANNER_BG_GRADIENT_START"]'),
    bgGradientEnd: $('input[name="PROMOBANNER_BG_GRADIENT_END"]'),
    titleColor: $('input[name="PROMOBANNER_TEXT_COLOR"]'),
    subtitleColor: $('input[name="PROMOBANNER_SUBTITLE_COLOR"]'),
    floating: $('select[name="PROMOBANNER_FLOATING"]'),
    floatingPosition: $('select[name="PROMOBANNER_FLOATING_POSITION"]'),
    standardPosition: $('select[name="PROMOBANNER_STANDARD_POSITION"]'),
    paddingTop: $('input[name="PROMOBANNER_PADDING_TOP"]'),
    paddingBottom: $('input[name="PROMOBANNER_PADDING_BOTTOM"]'),
    paddingLeft: $('input[name="PROMOBANNER_PADDING_LEFT"]'),
    paddingRight: $('input[name="PROMOBANNER_PADDING_RIGHT"]'),
    radius: $('input[name="PROMOBANNER_RADIUS"]'),
    width: $('input[name="PROMOBANNER_WIDTH"]'),
    height: $('input[name="PROMOBANNER_HEIGHT"]'),
    titleSize: $('input[name="PROMOBANNER_FS_TITLE"]'),
    subtitleSize: $('input[name="PROMOBANNER_FS_SUBTITLE"]'),
    ctaText: $('input[name="PROMOBANNER_CTA_TEXT"]'),
    ctaBg: $('input[name="PROMOBANNER_CTA_BG"]'),
    ctaColor: $('input[name="PROMOBANNER_CTA_COLOR"]'),
    imageUrl: $('input[name="PROMOBANNER_IMAGE"]'),
    imagePosition: $('select[name="PROMOBANNER_IMAGE_POSITION"]'),
    countdownEnabled: $('input[name="PROMOBANNER_COUNTDOWN_ENABLED"]'),
    countdownEndAt: $('input[name="PROMOBANNER_COUNTDOWN_END"]'),
    ctaBtnPX: $('input[name="PROMOBANNER_CTA_BTN_PX"]'),
    ctaBtnPY: $('input[name="PROMOBANNER_CTA_BTN_PY"]'),
    ctaBtnRadius: $('input[name="PROMOBANNER_CTA_BTN_RADIUS"]'),
    ctaBtnPosition: $('select[name="PROMOBANNER_CTA_BTN_POSITION"]'),
    ctaBtnFullWidth: $('input[name="PROMOBANNER_CTA_BTN_FULLWIDTH"]'),
    countdownFullWidth: $('input[name="PROMOBANNER_COUNTDOWN_FULLWIDTH"]'),
    bannerMaxwidth: $('input[name="PROMOBANNER_MAXWIDTH"]'),
    bannerImageWidth: $('input[name="PROMOBANNER_IMAGE_WIDTH"]'),
  };

  function toggleFieldsState(enabled) {
    $.each(inputs, function (key, input) {
      if (key !== "enabled") {
        // Don't disable the enable/disable toggle itself
        input.prop("disabled", !enabled);

        // Handle color picker buttons
        if (input.hasClass("mColorPicker")) {
          const colorPickerTrigger = input.next(".mColorPickerTrigger");
          if (colorPickerTrigger.length) {
            colorPickerTrigger.toggleClass("disabled", !enabled);
          }
        }
      }
    });
  }

  const previewRoot = $("#banner-shadow-root")[0];
  const shadow = previewRoot.attachShadow({ mode: "open" });

  const style = document.createElement("style");
  style.textContent = `
    .banner-countdown {
        font-size: 16px;
        font-weight: bold;
        color: #000;
        background: rgba(255, 255, 255, 0.8);
        padding: 6px 0px;
        border-radius: 4px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    img {
        display: block;
        max-width: 100%;
        height: auto;
    }
    .promo-banner {
        position: absolute;
        z-index: 9999;
    }

    .fixed-banner{
      left: 50% !important;
      transform: translateX(-50%);
    }

    p,h1{
      margin: 0 0 10px;
    }
    .promo-banner .banner-cta {
        display: inline-block;
        padding: 10px 20px;
        background-color: #000;
        color: #fff;
        text-decoration: none;
        border-radius: 5px;
    }

    .cta-button {
    /* Basic Styling */
    display: inline-block;
    padding: 10px 25px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; /* Clean font */
    font-size: 15px;
    font-weight: 500;
    text-align: center;
    text-decoration: none;

    background-color: transparent;
    color: #007bff; /* Blue text, matching border */

    transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease, transform 0.1s ease;
  }


  .cta-button:focus {
    outline: none;
    background-color: #007bff;
    color: #ffffff;
    box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.4);
  }

  .cta-button:active {
      background-color: #0056b3;
      border-color: #0056b3;
      color: #ffffff;
      transform: scale(0.97);
  }
    .promo-floating .banner-cta {
        display: inline-block;
        padding: 8px 16px;
        background-color: #000;
        color: #fff;
        text-decoration: none;
        border-radius: 5px;
    }
    .promo-top {
        top: 0;
        left: 0;
    }
    .promo-bottom {
        bottom: 0;
        left: 0;
    }
    .promo-top-left {
        top: 20px;
        left: 20px;
    }
    .promo-top-right {
        top: 20px;
        right: 20px;
    }
    .promo-bottom-left {
        bottom: 20px;
        left: 20px;
    }
    .promo-bottom-right {
        bottom: 20px;
        right: 20px;
    }
    .promo-close {
        position: absolute;
        right: 8px;
        top: 8px;
        cursor: pointer;
        font-size: 30px;
        line-height: 1;
    }

    @media screen and (max-width: 768px) {
      #banner-inner-wrapper {
        flex-wrap:wrap;
        padding: 10px !important;
      }

      #banner-inner-wrapper img {
        margin: 0 auto;
      }
    }
  `;

  shadow.appendChild(style);

  const bannerContainer = $("<div style='height:100%;'>");
  $(shadow).append(bannerContainer);

  function getValues() {
    const enableBanner =
      $('input[name="PROMOBANNER_ENABLED"]:checked').val() === "1"
        ? true
        : false;

    toggleFieldsState(enableBanner);
    const showCTA =
      $('input[name="PROMOBANNER_SHOW_CTA"]:checked').val() === "1"
        ? true
        : false;
    const autoHeight =
      $('input[name="PROMOBANNER_HEIGHT_AUTO"]:checked').val() === "1"
        ? true
        : false;
    const autoWidth =
      $('input[name="PROMOBANNER_WIDTH_AUTO"]:checked').val() === "1"
        ? true
        : false;
    const countdownEnabled =
      $('input[name="PROMOBANNER_COUNTDOWN_ENABLED"]:checked').val() === "1"
        ? true
        : false;
    const countdownFullWidth =
      $('input[name="PROMOBANNER_COUNTDOWN_FULLWIDTH"]:checked').val() === "1"
        ? true
        : false;
    const ctaBtnFullWidth =
      $('input[name="PROMOBANNER_CTA_BTN_FULLWIDTH"]:checked').val() === "1"
        ? true
        : false;

    const floating = inputs.floating.val();

    // Validate width value based on floating status
    let width = parseFloat(inputs.width.val()) || 0;
    if (floating !== "floating") {
      width = Math.min(Math.max(width, 0), 100);
      inputs.width.val(width);
      const parent = $('input[name="PROMOBANNER_WIDTH"]').parent().parent();
      const widthLabel = parent.find("label");
      const unit = "%";
      const currentText = widthLabel.text();
      widthLabel.text(currentText.replace(/\(.*\)/, `(${unit})`));
    } else {
      const parent = $('input[name="PROMOBANNER_WIDTH"]').parent().parent();
      const widthLabel = parent.find("label");
      const unit = "px";
      const currentText = widthLabel.text();
      widthLabel.text(currentText.replace(/\(.*\)/, `(${unit})`));
    }

    if (autoHeight) {
      inputs.height.prop("disabled", true);
    } else {
      inputs.height.prop("disabled", false);
    }

    if (autoWidth) {
      inputs.width.prop("disabled", true);
    } else {
      inputs.width.prop("disabled", false);
    }

    return {
      enableBanner,
      showCTA,
      autoHeight,
      autoWidth,
      countdownEnabled,
      bannerMaxwidth: inputs.bannerMaxwidth.val(),
      bannerImageWidth: inputs.bannerImageWidth.val(),
      ctaBtnFullWidth,
      countdownFullWidth,
      ctaBtnPosition: inputs.ctaBtnPosition.val(),
      ctaBtnPX: inputs.ctaBtnPX.val(),
      ctaBtnPY: inputs.ctaBtnPY.val(),
      ctaBtnRadius: inputs.ctaBtnRadius.val(),
      countdownEndAt: inputs.countdownEndAt.val(),
      contentAlignment: inputs.contentAlignment.val(),
      imagePosition: inputs.imagePosition.val(),
      title: $.trim(inputs.title.val()),
      subtitle:
        $.trim(inputs.subtitle.val()),
      titleColor: $('input[name="PROMOBANNER_TEXT_COLOR"').val(),
      subtitleColor: $('input[name="PROMOBANNER_SUBTITLE_COLOR"').val(),
      bgSolid: $('input[name="PROMOBANNER_BG_SOLID"').val() || "#FFD700",
      bgGradientStart:
        $('input[name="PROMOBANNER_BG_GRADIENT_START"').val() || "#FFD700",
      bgGradientEnd:
        $('input[name="PROMOBANNER_BG_GRADIENT_END"').val() || "#6b0050",
      paddingTop: inputs.paddingTop.val(),
      bgType: inputs.bgType.val(),
      paddingBottom: inputs.paddingBottom.val(),
      paddingRight: inputs.paddingRight.val(),
      paddingLeft: inputs.paddingLeft.val(),
      radius: inputs.radius.val(),
      width: width,
      height: inputs.height.val(),
      titleSize: inputs.titleSize.val(),
      subtitleSize: inputs.subtitleSize.val(),
      floating: inputs.floating.val(),
      floatingPosition: inputs.floatingPosition.val(),
      standardPosition: inputs.standardPosition.val(),
      ctaColor: $('input[name="PROMOBANNER_CTA_COLOR"').val() || "#FFD700",
      ctaBg: $('input[name="PROMOBANNER_CTA_BG"').val() || "#000",
      ctaText: inputs.ctaText.val(),
      imageUrl: inputs.imageUrl.val(),
    };
  }

  function updatePreview() {
    const values = getValues();
   
    if (!values.enableBanner) {
      bannerContainer.html(`
        <div style="
          display: flex;
          justify-content: center;
          align-items: center;
          height: calc(100vh - 200px);
          background-color: #f2f3f4;
          border: 2px dashed #7e8388;
          border-radius: 8px;
          color: #6c757d;
          font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
        ">
          <div style="text-align: center;">
            <svg style="width: 48px; height: 48px; margin-bottom: 16px; color: #adb5bd;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
            </svg>
            <div style="font-size: 18px; font-weight: 500; margin-bottom: 8px;">Banner is disabled</div>
            <div style="font-size: 14px;">Enable the banner to preview and configure settings</div>
          </div>
        </div>
      `);
      return;
    }
    const backgroundStyle =
      values.bgType === "solid"
        ? `background: ${values.bgSolid};`
        : `background: linear-gradient(135deg, ${values.bgGradientStart}, ${values.bgGradientEnd});`;

    const isFloating = values.floating === "floating";
    const positionClass = isFloating
      ? `promo-${values.floatingPosition}`
      : `promo-${values.standardPosition} fixed-banner`;
    const widthStyle = isFloating
      ? `width: ${values.autoWidth ? "auto" : `${values.width}px`};`
      : `width: ${values.autoWidth ? "auto" : `${values.width}%`};`;

    let countdownHtml = "";
    if (values.countdownEnabled && values.countdownEndAt) {
      countdownHtml = `<div class="banner-countdown" style="width:${
        values.countdownFullWidth ? "100%" : "auto"
      }; padding:6px ${
        values.countdownFullWidth && (values.ctaBtnPosition == 'top' || values.ctaBtnPosition == 'bottom') ? "0px" : "12px"
      };" data-end="${values.countdownEndAt}"></div>`;
    }

    bannerContainer.html(
      `
      <div 
        class="promo-banner ${positionClass}" 
        style="
          ${backgroundStyle}
          ${widthStyle}
          height: ${values.autoHeight ? "auto" : `${values.height}px`};
          display: flex;
          justify-content: space-between;
          border-radius: ${values.radius}px;
        "
      >
        <span class="promo-close" style="color:${values.titleColor}">×</span>

        <div
          id="banner-inner-wrapper"
          style="
            max-width: ${values.bannerMaxwidth}px;
            width: 100%;
            margin: auto;
            display: flex;
            gap: 20px;
            justify-content: space-between;
            align-items: center;
            ${
              values.imageUrl
                ? `flex-direction: ${
                    values.imagePosition === "left" ? "row-reverse" : "row"
                  };`
                : ""
            }
            padding-top: ${values.paddingTop}px;
            padding-bottom: ${values.paddingBottom}px;
            padding-right: ${values.paddingRight}px;
            padding-left: ${values.paddingLeft}px;
            border-radius: ${values.radius}px;
          "
        >
          <div
            style="
              text-align: ${values.contentAlignment};
              ${!values.imageUrl ? "flex: 1;" : ""}
            "
          >
            <h1
              style="
                margin-top: 0;
                color: ${values.titleColor};
                font-size: ${values.titleSize}px;
              "
            >
              ${values.title}
            </h1>

            <p
              style="
                color: ${values.subtitleColor};
                font-size: ${values.subtitleSize}px;
              "
            >
              ${values.subtitle}
            </p>

            <div
              style="
                display: flex;
                gap: 20px;
                justify-content: ${values.contentAlignment};
                flex-direction: ${
                  values.ctaBtnPosition === "left"
                    ? "row"
                    : values.ctaBtnPosition === "right"
                    ? "row-reverse"
                    : values.ctaBtnPosition === "bottom"
                    ? "column"
                    : "column-reverse"
                };
                ${
                  values.contentAlignment === "center"
                    ? "align-items: center;"
                    : ""
                }
              "
            >
              ${countdownHtml}

              ${
                values.showCTA
                  ? `
                    <button 
                      class="cta-button"
                      style="
                        width: ${values.ctaBtnFullWidth ? "100%" : "auto"};
                        padding: ${values.ctaBtnPY}px ${values.ctaBtnPX}px;
                        border-radius: ${values.ctaBtnRadius}px;
                        font-weight: 600;
                        background-color: ${values.ctaBg};
                        color: ${values.ctaColor};
                      "
                    >
                      ${values.ctaText || "Shop Now"}
                    </button>
                  `
                  : ""
              }
            </div>
          </div>

          ${
            values.imageUrl
              ? `<img style="width: ${values.bannerImageWidth}px; max-width: 300px;" src="${values.imageUrl}" />`
              : ""
          }
        </div>
      </div>
      `
    );

    // Initialize countdown in preview
    if (values.countdownEnabled && values.countdownEndAt) {
      const countdownElement = shadow.querySelector('.banner-countdown')
    
      if (countdownElement) {
        const updateCountdown = () => {
          const now = new Date()
    
          let endDate = new Date(values.countdownEndAt)
          const isSameDay =
            endDate.getFullYear() === now.getFullYear() &&
            endDate.getMonth() === now.getMonth() &&
            endDate.getDate() === now.getDate()
    
          if (isSameDay) {
            endDate.setHours(23, 59, 59, 999) // Set to end of day
          }
    
          const distance = endDate.getTime() - now.getTime()
    
          if (distance < 0) {
            countdownElement.innerHTML = `
              <div style="display: flex; gap: 10px; justify-content: center;">
                <div style="text-align: center"><div>00</div><small>days</small></div>
                <div style="text-align: center"><div>00</div><small>hours</small></div>
                <div style="text-align: center"><div>00</div><small>minutes</small></div>
                <div style="text-align: center"><div>00</div><small>seconds</small></div>
              </div>`
            return
          }
    
          const days = Math.floor(distance / (1000 * 60 * 60 * 24))
          const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60))
          const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60))
          const seconds = Math.floor((distance % (1000 * 60)) / 1000)
    
          countdownElement.innerHTML = `
            <div style="display: flex; gap: 10px; justify-content: center;">
              <div style="text-align: center"><div>${String(days).padStart(2, '0')}</div><small>days</small></div>
              <div style="text-align: center"><div>${String(hours).padStart(2, '0')}</div><small>hours</small></div>
              <div style="text-align: center"><div>${String(minutes).padStart(2, '0')}</div><small>minutes</small></div>
              <div style="text-align: center"><div>${String(seconds).padStart(2, '0')}</div><small>seconds</small></div>
            </div>`
        }
    
        updateCountdown()
        setInterval(updateCountdown, 1000)
      }
    }
    
  }
  toggleFieldsState($('input[name="PROMOBANNER_ENABLED"]:checked').val() === "1");
  updatePreview();
  inputs.enabled.on('change', function() {
    const isEnabled = $(this).val() === "1";
    toggleFieldsState(isEnabled);
    updatePreview();
  });
  $.each(inputs, function (key, input) {
    if (!input.length) return;

    if (key === "enabled" || key === "showCta" || key === "countdownEnabled") {
      input.on("change", updatePreview);
    } else {
      input.on("input change", updatePreview);
    }
  });
});
