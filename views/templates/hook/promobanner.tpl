{assign var="isFloating" value=($floating_mode == 'floating')}

{assign var="banner_background_style" value=""}

{if $banner_bg_type == 'solid'}
    {assign var="banner_background_style" value="background-color: {$banner_bg_solid};"}
{elseif $banner_bg_type == 'gradient'}
    {assign var="banner_background_style" value="background: linear-gradient(145deg, {$banner_bg_gradient_start}, {$banner_bg_gradient_end});"}
{/if}

{assign var="banner_width_style" value=""}

{if $isFloating}
    {if $banner_auto_width}
        {assign var="banner_width_style" value="width: auto;"}
    {else}
        {assign var="banner_width_style" value="width: {$banner_width}px;"}
    {/if}
{else}
    {if $banner_auto_width}
        {assign var="banner_width_style" value="width: auto;"}
    {else}
        {assign var="banner_width_style" value="width: {$banner_width}%;"}
    {/if}
{/if}

{assign var="banner_height_style" value=""}
{if !$banner_auto_height}
    {assign var="banner_height_style" value="height: `$height`px;"}
{else}
    {assign var="banner_height_style" value="height: auto;"}
{/if}

{assign var="banner_flex_direction" value=""}
{if $banner_image_position == 'right'}
    {assign var="banner_flex_direction" value="row"}
{else}
    {assign var="banner_flex_direction" value="row-reverse"}
{/if}



{assign var="banner_btn_flex_direction" value=""}
{if $banner_cta_btn_position == 'left'}
    {assign var="banner_btn_flex_direction" value="row"}
{elseif $banner_cta_btn_position == 'right'}
    {assign var="banner_btn_flex_direction" value="row-reverse"}
{elseif $banner_cta_btn_position == 'bottom'}
    {assign var="banner_btn_flex_direction" value="column"}
{else}
    {assign var="banner_btn_flex_direction" value="column-reverse"}
{/if}


{if $isFloating}
    {assign var="positionClass" value="promo-floating promo-{$banner_position_floating}"}
{else}
    {assign var="positionClass" value="promo-{$standard_position} fixed-banner"}
{/if}


<style>
:root {
	--banner-bg-solid: {$banner_bg_solid};
	--gradient-start: {$banner_bg_gradient_start};
	--gradient-end: {$banner_bg_gradient_end};
	--banner-width-desktop: {$banner_width}px;
	--banner-height: {$height}px;

	--banner-title-size: {$banner_fs_title}px;
	--banner-subtitle-size: {$banner_fs_subtitle}px;

	--btn-py: {$banner_cta_btn_py}px;
	--btn-px: {$banner_cta_btn_px}px;
	--btn-radius: {$banner_cta_btn_radius}px;
	--btn-bg: {$banner_cta_bg};
	--btn-color: {$banner_cta_color};
}
</style>

<div class="promo-banner {$positionClass}" style="
          {$banner_background_style}
          {$banner_width_style}
          {$banner_height_style}
          display: flex;
          justify-content: space-between;
          border-radius: {$banner_radius}px;
        ">
        <span class="promo-close" style="color:{$banner_text_color}" onclick="closePromoBanner()">×</span>

        <div 
            id="banner-inner-wrapper"
            style="
                max-width: {$banner_maxwidth}px;
                width: 100%;
                margin: auto;
                display: flex;
                gap: 20px;
                justify-content: space-between;
                align-items: center;
                {if $banner_image}
                    flex-direction: {$banner_flex_direction};
                {/if}
                padding-top: {$banner_padding_top}px;
                padding-bottom: {$banner_padding_bottom}px;
                padding-right: {$banner_padding_right}px;
                padding-left: {$banner_padding_left}px;
                border-radius: {$banner_radius}px;
          ">
          <div id="content-wrapper" style="
              text-align: {$banner_content_alignment};
              {(!$banner_image) ? 'flex:1' : ''}
            ">
            <h1 style="
                margin-top: 0;
                color: {$banner_text_color};
                font-size: {$banner_fs_title}px;
              ">
              {$banner_title}
            </h1>

            <p style="
                color: {$banner_subtitle_color};
                font-size: {$banner_fs_subtitle}px;
              ">
              {$banner_subtitle}
            </p>

            <div 
            class="cta-wrapper"
            style="
                display: flex;
                gap: 20px;
                justify-content: {$banner_content_alignment};
                flex-direction:{$banner_btn_flex_direction};
                {($banner_content_alignment == 'center') and ($banner_btn_flex_direction == 'column' or $banner_btn_flex_direction == 'column-reverse') ? 'align-items: center;' : ''}
              ">
              
                {if $banner_countdown_enabled && $banner_countdown_end}
                    <div 
                        class="banner-countdown" 
                        style="width: {($banner_countdown_fullwidth) ? '100%' : 'auto'}; padding: 6px {($banner_countdown_fullwidth) ? '0px' : '12px'};" 
                        data-end="{$banner_countdown_end|escape:'html':'UTF-8'}"
                    ></div>
                {/if}

                {if $banner_show_cta}
                    <a 
                        href="{$banner_link|escape:'html':'UTF-8'}" 
                        class="cta-button" 
                        style="
                            width: {($banner_cta_btn_fullwidth) ? '100%' : 'auto'};
                            padding: {$banner_cta_btn_py|intval}px {$banner_cta_btn_px|intval}px;
                            border-radius: {$banner_cta_btn_radius|intval}px;
                            font-weight: 600;
                            background-color: {$banner_cta_bg|escape:'html':'UTF-8'};
                            color: {$banner_cta_color|escape:'html':'UTF-8'};
                        "
                    >
                        {$banner_cta_text|escape:'html':'UTF-8'}
                    </a>
                {/if}
              
            </div>
          </div>

          {if $banner_image}
            <img style="width: {$banner_image_width}px; max-width: 300px;" src="{$banner_image}">
          {/if}

        </div>
      </div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const banner = document.querySelector('.promo-banner');
    const mainContainer = document.querySelector("body > main");
    
    function handleMobileFloating() {
      const isMobile = window.innerWidth <= 768;
      const isFloating = banner.classList.contains('promo-floating');
      
      if (isMobile && isFloating) {
        // Store original classes for desktop
        banner.dataset.originalClasses = banner.className;
        // Force bottom position on mobile
        banner.className = 'promo-banner promo-bottom fixed-banner';
        banner.style.width = "100%"
        updateBodyPadding();
      } else if (!isMobile && banner.dataset.originalClasses) {
        // Restore original classes on desktop
        banner.className = banner.dataset.originalClasses;
        banner.style.width = "auto";
        updateBodyPadding();
      }
    }
     const updateBodyPadding = () => {
            const bannerHeight = banner.offsetHeight;
            const isTopBanner = banner.classList.contains('promo-top');
            const isForcedFixed = window.innerWidth <= 768 && banner.classList.contains('promo-floating');
            
            // Reset existing padding
            mainContainer.style.paddingTop = '0px';
            mainContainer.style.paddingBottom = '0px';
            
            // Add padding if banner is not floating or if forced fixed on mobile
            if (!banner.classList.contains('promo-floating') || isForcedFixed) {
            if (isTopBanner) {
                mainContainer.style.paddingTop = bannerHeight + 'px';
            } else {
                mainContainer.style.paddingBottom = bannerHeight + 'px';
            }
            }
        };

    if (banner) {
      // Initial check for mobile floating
      handleMobileFloating();
      
      // Update padding initially
      updateBodyPadding();

      // Handle resize events
      window.addEventListener('resize', () => {
        handleMobileFloating();
        updateBodyPadding();
      });

      // Create ResizeObserver to watch banner height changes
      const resizeObserver = new ResizeObserver(updateBodyPadding);
      resizeObserver.observe(banner);

      // Remove padding when banner is closed
      document.querySelector('.promo-close').addEventListener('click', function() {
        mainContainer.style.paddingTop = '0px';
        mainContainer.style.paddingBottom = '0px';
        banner.remove();
      });
    }
  });
</script>

