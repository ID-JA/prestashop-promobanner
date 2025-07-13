{assign var="isFloating" value=($floating_mode == 'floating')}
{assign var="positionClass" value=""}

{if $isFloating}
    {assign var="positionClass" value="promo-"|cat:$banner_position_floating}
{else}
    {assign var="positionClass" value="promo-banner promo-"|cat:$standard_position}
{/if}

{assign var="style" value=""}
{if $banner_bg_type == 'solid'}
    {assign var="style" value="background-color: `{$banner_bg_solid}`;"}
{elseif $banner_bg_type == 'gradient'}
    {assign var="style" value="background: linear-gradient(90deg, {$banner_bg_gradient_start}, {$banner_bg_gradient_end});"}
{/if}

{if !$isFloating}
    <div id="promo" style="{$style} color: {$banner_text_color};">
        <h1 class="banner-title">{$banner_title}</h1>
        <p class="banner-subtitle">{$banner_subtitle}</p>
        {if $banner_show_cta}
            <a href="{$banner_link|escape:'html':'UTF-8'}" class="banner-cta">Shop Now</a>
        {/if}
        <span class="promo-close" onclick="closePromoBanner()">×</span>
    </div>
{/if}


{if $isFloating}
    <div id="promo-floating-preview" class="{$positionClass} absolute" style="{$style} color: {$banner_text_color};">
        <div class="banner-content">
            <h1 class="banner-title">{$banner_title}</h1>
            <p class="banner-subtitle">{$banner_subtitle}</p>
            {if $banner_show_cta}
                <a href="{$banner_link|escape:'html':'UTF-8'}" class="banner-cta">Shop Now</a>
            {/if}
        </div>
    </div>
{/if}


