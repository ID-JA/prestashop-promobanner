<?php

if (!defined('_PS_VERSION_')) {
    exit;
}

class Promobanner extends Module
{
    public function __construct()
    {
        $this->name = 'promobanner';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'Doom Team ';
        $this->need_instance = 0;

        parent::__construct();

        $this->displayName = $this->l('Promo Banner');
        $this->description = $this->l('Displays a customizable banner at the top or bottom of your site.');
    }

    public function install()
    {
        return parent::install() &&
            $this->registerHook('displayHeader') &&
            $this->registerHook('displayTop') &&
            $this->registerHook('displayBeforeBodyClosingTag') &&
            Configuration::updateValue('PROMOBANNER_TITLE', 'Our Sites May Cause Sweet Cravings') &&
            Configuration::updateValue('PROMOBANNER_SUBTITLE', ' We serve full-stack web solutions. And yes, cookies too.') &&
            Configuration::updateValue('PROMOBANNER_LINK', '#') &&
            Configuration::updateValue('PROMOBANNER_BG', '#ffffff') &&
            Configuration::updateValue('PROMOBANNER_TEXT_COLOR', '#000000') &&
            Configuration::updateValue('PROMOBANNER_SUBTITLE_COLOR', '#333333') &&
            Configuration::updateValue('PROMOBANNER_POSITION', 'top') &&
            Configuration::updateValue('PROMOBANNER_BG_TYPE', 'solid') &&
            Configuration::updateValue('PROMOBANNER_FLOATING_POSITION', 'bottom-right') &&
            Configuration::updateValue('PROMOBANNER_BG_GRADIENT_START', '#ff0000') &&
            Configuration::updateValue('PROMOBANNER_BG_GRADIENT_END', '#ffa500') &&
            Configuration::updateValue('PROMOBANNER_BG_SOLID', '#ffffff') &&
            Configuration::updateValue('PROMOBANNER_FLOATING', 'nofloating') &&
            Configuration::updateValue('PROMOBANNER_STANDARD_POSITION', 'top') &&
            Configuration::updateValue('PROMOBANNER_SHOW_CTA', true) &&
            Configuration::updateValue('PROMOBANNER_CTA_BTN_PX', '16') &&
            Configuration::updateValue('PROMOBANNER_CTA_BTN_PY', '8') &&
            Configuration::updateValue('PROMOBANNER_CTA_BTN_RADIUS', '4') &&
            Configuration::updateValue('PROMOBANNER_CTA_BTN_POSITION', 'right') &&
            Configuration::updateValue('PROMOBANNER_COUNTDOWN_FULLWIDTH', false) &&
            Configuration::updateValue('PROMOBANNER_CTA_BTN_FULLWIDTH', false) &&
            Configuration::updateValue('PROMOBANNER_COUNTDOWN_ENABLED', false) &&
            Configuration::updateValue('PROMOBANNER_COUNTDOWN_END', '') &&
            Configuration::updateValue('PROMOBANNER_PADDING_TOP', '20') &&
            Configuration::updateValue('PROMOBANNER_PADDING_BOTTOM', '20') &&
            Configuration::updateValue('PROMOBANNER_PADDING_LEFT', '20') &&
            Configuration::updateValue('PROMOBANNER_PADDING_RIGHT', '20') &&
            Configuration::updateValue('PROMOBANNER_RADIUS', '0') &&
            Configuration::updateValue('PROMOBANNER_WIDTH', '561') &&
            Configuration::updateValue('PROMOBANNER_MAXWIDTH', '900') &&
            Configuration::updateValue('PROMOBANNER_IMAGE_WIDTH', '150') &&
            Configuration::updateValue('PROMOBANNER_HEIGHT', 'auto') &&
            Configuration::updateValue('PROMOBANNER_HEIGHT_AUTO', true) &&
            Configuration::updateValue('PROMOBANNER_WIDTH_AUTO', false) &&
            Configuration::updateValue('PROMOBANNER_CONTENT_ALIGNMENT', 'center') &&
            Configuration::updateValue('PROMOBANNER_IMAGE', 'https://cdn-icons-png.flaticon.com/512/15182/15182069.png') &&
            Configuration::updateValue('PROMOBANNER_IMAGE_POSITION', 'right') &&
            Configuration::updateValue('PROMOBANNER_FS_TITLE', '32') &&
            Configuration::updateValue('PROMOBANNER_FS_SUBTITLE', '18') &&
            Configuration::updateValue('PROMOBANNER_CTA_BG', '#000') &&
            Configuration::updateValue('PROMOBANNER_CTA_COLOR', '#fff') &&
            Configuration::updateValue('PROMOBANNER_CTA_TEXT', 'Feed Me Features') &&
            Configuration::updateValue('PROMOBANNER_STOCK_PRODUCT_ID', '');
    }

    public function uninstall()
    {

        $keys = [
            'PROMOBANNER_TITLE',
            'PROMOBANNER_SUBTITLE',
            'PROMOBANNER_LINK',
            'PROMOBANNER_BG',
            'PROMOBANNER_TEXT_COLOR',
            'PROMOBANNER_SUBTITLE_COLOR',
            'PROMOBANNER_POSITION',
            'PROMOBANNER_BG_TYPE',
            'PROMOBANNER_FLOATING_POSITION',
            'PROMOBANNER_BG_GRADIENT_START',
            'PROMOBANNER_BG_GRADIENT_END',
            'PROMOBANNER_BG_SOLID',
            'PROMOBANNER_FLOATING',
            'PROMOBANNER_STANDARD_POSITION',
            'PROMOBANNER_SHOW_CTA',
            'PROMOBANNER_CTA_BTN_PX',
            'PROMOBANNER_CTA_BTN_PY',
            'PROMOBANNER_CTA_BTN_RADIUS',
            'PROMOBANNER_CTA_BTN_POSITION',
            'PROMOBANNER_COUNTDOWN_FULLWIDTH',
            'PROMOBANNER_CTA_BTN_FULLWIDTH',
            'PROMOBANNER_COUNTDOWN_ENABLED',
            'PROMOBANNER_COUNTDOWN_END',
            'PROMOBANNER_PADDING_TOP',
            'PROMOBANNER_PADDING_BOTTOM',
            'PROMOBANNER_PADDING_LEFT',
            'PROMOBANNER_PADDING_RIGHT',
            'PROMOBANNER_RADIUS',
            'PROMOBANNER_WIDTH',
            'PROMOBANNER_MAXWIDTH',
            'PROMOBANNER_IMAGE_WIDTH',
            'PROMOBANNER_HEIGHT',
            'PROMOBANNER_HEIGHT_AUTO',
            'PROMOBANNER_WIDTH_AUTO',
            'PROMOBANNER_CONTENT_ALIGNMENT',
            'PROMOBANNER_IMAGE',
            'PROMOBANNER_IMAGE_POSITION',
            'PROMOBANNER_FS_TITLE',
            'PROMOBANNER_FS_SUBTITLE',
            'PROMOBANNER_CTA_BG',
            'PROMOBANNER_CTA_COLOR',
            'PROMOBANNER_CTA_TEXT',
            'PROMOBANNER_STOCK_PRODUCT_ID',
        ];


        foreach ($keys as $key) {
            Configuration::deleteByName($key);
        }

        return parent::uninstall();
    }

    public function hookDisplayHeader()
    {
        $this->context->controller->addCSS($this->_path . 'views/css/promobanner.css');
        $this->context->controller->addJS($this->_path . 'views/js/promobanner.js');
    }

    public function hookDisplayTop()
    {
        return $this->renderBanner('top');
    }

    public function hookDisplayBeforeBodyClosingTag()
    {
        return $this->renderBanner('bottom');
    }

    private function processPlaceholders($text) 
    {
        $productId = (int)Configuration::get('PROMOBANNER_STOCK_PRODUCT_ID');
        $productName = '';
        $productImages = [];
        
        if ($productId > 0) {
            $product = new Product($productId, false, $this->context->language->id);
            $productName = $product->name;
            
            // Get product images
            $images = $product->getImages($this->context->language->id);
            if ($images) {
                foreach ($images as $image) {
                    $productImages[] = $this->context->link->getImageLink(
                        $product->link_rewrite,
                        $image['id_image'],
                        ImageType::getFormattedName('home')
                    );
                }
            }
        }
    
        $placeholders = [
            'products' => $this->l('products'),
            'stock' => $this->getStockQuantity(),
            'product_name' => $productName
        ];
    
        // Add dynamic image placeholders
        foreach ($productImages as $index => $imageUrl) {
            $placeholders['product_image_' . ($index + 1)] = $imageUrl;
        }
    
        return preg_replace_callback(
            '/\{\{(\w+)\}\}/',
            function ($matches) use ($placeholders) {
                $key = $matches[1];
                return isset($placeholders[$key]) ? $placeholders[$key] : '';
            },
            $text
        );
    }

    private function getStockQuantity()
    {
        $productId = (int)Configuration::get('PROMOBANNER_STOCK_PRODUCT_ID');
        if ($productId <= 0) {
            return 0; 
        }

        
        $quantity = StockAvailable::getQuantityAvailableByProduct($productId, null, (int)$this->context->shop->id);
        return $quantity;
    }

    private function renderBanner($position)
    {

        
        $countdownEnabled = (bool)Configuration::get('PROMOBANNER_COUNTDOWN_ENABLED');
        if ($countdownEnabled) {
            $countdownEnd = Configuration::get('PROMOBANNER_COUNTDOWN_END');
            $endTime = strtotime($countdownEnd);
            if ($countdownEnd && $endTime !== false) {
                $endTime = strtotime(date('Y-m-d 23:59:59', $endTime));
                if ($endTime < time()) {
                    return;
                }
            }
        }
        if (isset($_COOKIE['promo_closed'])) {
            return;
        }

        if (!Configuration::get('PROMOBANNER_ENABLED')) {
            return;
        }

        if (Configuration::get('PROMOBANNER_POSITION') !== $position) {
            return;
        }

        $displayMode = Configuration::get('PROMOBANNER_DISPLAY_MODE');
        $isHomepage = $this->context->controller->php_self === 'index';

        if ($displayMode === 'homepage' && !$isHomepage) {
            return;
        }

        $title = Configuration::get('PROMOBANNER_TITLE');
        $processedTitle = $this->processPlaceholders($title);

        $this->context->smarty->assign([
            'banner_title' => $processedTitle,
            'banner_subtitle' => Configuration::get('PROMOBANNER_SUBTITLE'),
            'banner_link' => Configuration::get('PROMOBANNER_LINK'),
            'banner_bg' => Configuration::get('PROMOBANNER_BG'),
            'banner_text_color' => Configuration::get('PROMOBANNER_TEXT_COLOR'),
            'banner_subtitle_color' => Configuration::get('PROMOBANNER_SUBTITLE_COLOR'),
            'banner_position' => Configuration::get('PROMOBANNER_POSITION'),
            'banner_bg_type' => Configuration::get('PROMOBANNER_BG_TYPE'),
            'banner_position_floating' => Configuration::get('PROMOBANNER_FLOATING_POSITION'),
            'banner_bg_gradient_start' => Configuration::get('PROMOBANNER_BG_GRADIENT_START'),
            'banner_bg_gradient_end' => Configuration::get('PROMOBANNER_BG_GRADIENT_END'),
            'banner_bg_solid' => Configuration::get('PROMOBANNER_BG_SOLID'),
            'floating_mode' => Configuration::get('PROMOBANNER_FLOATING'),
            'standard_position' => Configuration::get('PROMOBANNER_STANDARD_POSITION'),
            'banner_show_cta' => Configuration::get('PROMOBANNER_SHOW_CTA'),
            'banner_cta_btn_px' => Configuration::get('PROMOBANNER_CTA_BTN_PX'),
            'banner_cta_btn_py' => Configuration::get('PROMOBANNER_CTA_BTN_PY'),
            'banner_cta_btn_radius' => Configuration::get('PROMOBANNER_CTA_BTN_RADIUS'),
            'banner_cta_btn_position' => Configuration::get('PROMOBANNER_CTA_BTN_POSITION'),
            'banner_countdown_fullwidth' => Configuration::get('PROMOBANNER_COUNTDOWN_FULLWIDTH'),
            'banner_cta_btn_fullwidth' => Configuration::get('PROMOBANNER_CTA_BTN_FULLWIDTH'),
            'banner_countdown_enabled' => Configuration::get('PROMOBANNER_COUNTDOWN_ENABLED'),
            'banner_countdown_end' => Configuration::get('PROMOBANNER_COUNTDOWN_END'),
            'banner_padding_top' => Configuration::get('PROMOBANNER_PADDING_TOP'),
            'banner_padding_bottom' => Configuration::get('PROMOBANNER_PADDING_BOTTOM'),
            'banner_padding_left' => Configuration::get('PROMOBANNER_PADDING_LEFT'),
            'banner_padding_right' => Configuration::get('PROMOBANNER_PADDING_RIGHT'),
            'banner_radius' => Configuration::get('PROMOBANNER_RADIUS'),
            'banner_width' => Configuration::get('PROMOBANNER_WIDTH'),
            'banner_maxwidth' => Configuration::get('PROMOBANNER_MAXWIDTH'),
            'banner_image_width' => Configuration::get('PROMOBANNER_IMAGE_WIDTH'),
            'banner_height' => Configuration::get('PROMOBANNER_HEIGHT'),
            'banner_auto_height' => Configuration::get('PROMOBANNER_HEIGHT_AUTO'),
            'banner_auto_width' => Configuration::get('PROMOBANNER_WIDTH_AUTO'),
            'banner_content_alignment' => Configuration::get('PROMOBANNER_CONTENT_ALIGNMENT'),
            'banner_image' => Configuration::get('PROMOBANNER_IMAGE'),
            'banner_image_position' => Configuration::get('PROMOBANNER_IMAGE_POSITION'),
            'banner_fs_title' => Configuration::get('PROMOBANNER_FS_TITLE'),
            'banner_fs_subtitle' => Configuration::get('PROMOBANNER_FS_SUBTITLE'),
            'banner_cta_bg' => Configuration::get('PROMOBANNER_CTA_BG'),
            'banner_cta_color' => Configuration::get('PROMOBANNER_CTA_COLOR'),
            'banner_cta_text' => Configuration::get('PROMOBANNER_CTA_TEXT'),
        ]);

        return $this->display(__FILE__, 'promobanner.tpl');
    }

    public function getContent()
    {
        $output = '';

        if (Tools::isSubmit('submit_promobanner')) {
            Configuration::updateValue('PROMOBANNER_ENABLED', Tools::getValue('PROMOBANNER_ENABLED'));
            Configuration::updateValue('PROMOBANNER_DISPLAY_MODE', Tools::getValue('PROMOBANNER_DISPLAY_MODE'));
            Configuration::updateValue('PROMOBANNER_TITLE', Tools::getValue('PROMOBANNER_TITLE'));
            Configuration::updateValue('PROMOBANNER_SUBTITLE', Tools::getValue('PROMOBANNER_SUBTITLE'));
            Configuration::updateValue('PROMOBANNER_LINK', Tools::getValue('PROMOBANNER_LINK'));
            Configuration::updateValue('PROMOBANNER_BG_TYPE', Tools::getValue('PROMOBANNER_BG_TYPE'));
            Configuration::updateValue('PROMOBANNER_BG_SOLID', Tools::getValue('PROMOBANNER_BG_SOLID'));
            Configuration::updateValue('PROMOBANNER_BG_GRADIENT_START', Tools::getValue('PROMOBANNER_BG_GRADIENT_START'));
            Configuration::updateValue('PROMOBANNER_BG_GRADIENT_END', Tools::getValue('PROMOBANNER_BG_GRADIENT_END'));
            Configuration::updateValue('PROMOBANNER_TEXT_COLOR', Tools::getValue('PROMOBANNER_TEXT_COLOR'));
            Configuration::updateValue('PROMOBANNER_SUBTITLE_COLOR', Tools::getValue('PROMOBANNER_SUBTITLE_COLOR'));
            Configuration::updateValue('PROMOBANNER_FLOATING', Tools::getValue('PROMOBANNER_FLOATING'));
            Configuration::updateValue('PROMOBANNER_FLOATING_POSITION', Tools::getValue('PROMOBANNER_FLOATING_POSITION'));
            Configuration::updateValue('PROMOBANNER_STANDARD_POSITION', Tools::getValue('PROMOBANNER_STANDARD_POSITION'));
            Configuration::updateValue('PROMOBANNER_CTA_TEXT', Tools::getValue('PROMOBANNER_CTA_TEXT'));
            Configuration::updateValue('PROMOBANNER_CTA_COLOR', Tools::getValue('PROMOBANNER_CTA_COLOR'));
            Configuration::updateValue('PROMOBANNER_CTA_BG', Tools::getValue('PROMOBANNER_CTA_BG'));
            Configuration::updateValue('PROMOBANNER_SHOW_CTA', Tools::getValue('PROMOBANNER_SHOW_CTA'));
            Configuration::updateValue('PROMOBANNER_CTA_BTN_PX', Tools::getValue('PROMOBANNER_CTA_BTN_PX'));
            Configuration::updateValue('PROMOBANNER_CTA_BTN_PY', Tools::getValue('PROMOBANNER_CTA_BTN_PY'));
            Configuration::updateValue('PROMOBANNER_CTA_BTN_RADIUS', Tools::getValue('PROMOBANNER_CTA_BTN_RADIUS'));
            Configuration::updateValue('PROMOBANNER_CTA_BTN_POSITION', Tools::getValue('PROMOBANNER_CTA_BTN_POSITION'));
            Configuration::updateValue('PROMOBANNER_COUNTDOWN_FULLWIDTH', Tools::getValue('PROMOBANNER_COUNTDOWN_FULLWIDTH'));
            Configuration::updateValue('PROMOBANNER_CTA_BTN_FULLWIDTH', Tools::getValue('PROMOBANNER_CTA_BTN_FULLWIDTH'));
            Configuration::updateValue('PROMOBANNER_COUNTDOWN_ENABLED', Tools::getValue('PROMOBANNER_COUNTDOWN_ENABLED'));
            Configuration::updateValue('PROMOBANNER_COUNTDOWN_END', Tools::getValue('PROMOBANNER_COUNTDOWN_END'));
            Configuration::updateValue('PROMOBANNER_PADDING_TOP', (int) Tools::getValue('PROMOBANNER_PADDING_TOP'));
            Configuration::updateValue('PROMOBANNER_PADDING_BOTTOM', (int) Tools::getValue('PROMOBANNER_PADDING_BOTTOM'));
            Configuration::updateValue('PROMOBANNER_PADDING_LEFT', (int) Tools::getValue('PROMOBANNER_PADDING_LEFT'));
            Configuration::updateValue('PROMOBANNER_PADDING_RIGHT', (int) Tools::getValue('PROMOBANNER_PADDING_RIGHT'));
            Configuration::updateValue('PROMOBANNER_RADIUS', (int) Tools::getValue('PROMOBANNER_RADIUS'));
            Configuration::updateValue('PROMOBANNER_WIDTH', (int) Tools::getValue('PROMOBANNER_WIDTH'));
            Configuration::updateValue('PROMOBANNER_MAXWIDTH', (int) Tools::getValue('PROMOBANNER_MAXWIDTH'));
            Configuration::updateValue('PROMOBANNER_IMAGE_WIDTH', (int) Tools::getValue('PROMOBANNER_IMAGE_WIDTH'));
            Configuration::updateValue('PROMOBANNER_HEIGHT', (int) Tools::getValue('PROMOBANNER_HEIGHT'));
            Configuration::updateValue('PROMOBANNER_HEIGHT_AUTO', Tools::getValue('PROMOBANNER_HEIGHT_AUTO'));
            Configuration::updateValue('PROMOBANNER_WIDTH_AUTO', Tools::getValue('PROMOBANNER_WIDTH_AUTO'));
            Configuration::updateValue('PROMOBANNER_CONTENT_ALIGNMENT', Tools::getValue('PROMOBANNER_CONTENT_ALIGNMENT'));
            Configuration::updateValue('PROMOBANNER_IMAGE', Tools::getValue('PROMOBANNER_IMAGE'));
            Configuration::updateValue('PROMOBANNER_IMAGE_POSITION', Tools::getValue('PROMOBANNER_IMAGE_POSITION'));
            Configuration::updateValue('PROMOBANNER_FS_SUBTITLE', (int) Tools::getValue('PROMOBANNER_FS_SUBTITLE'));
            Configuration::updateValue('PROMOBANNER_FS_TITLE', (int) Tools::getValue('PROMOBANNER_FS_TITLE'));
            Configuration::updateValue('PROMOBANNER_STOCK_PRODUCT_ID', (int) Tools::getValue('PROMOBANNER_STOCK_PRODUCT_ID'));

            
            $countdownEnd = Tools::getValue('PROMOBANNER_COUNTDOWN_END');
            if ($countdownEnd && !strtotime($countdownEnd)) {
                $this->context->controller->errors[] = $this->l('Invalid countdown end date format. Use YYYY-MM-DD HH:MM:SS.');
            }

            
            $productId = (int)Tools::getValue('PROMOBANNER_STOCK_PRODUCT_ID');
            if ($productId < 0) {
                $this->context->controller->errors[] = $this->l('Invalid product ID for stock tracking.');
            }

            if (empty($this->context->controller->errors)) {
                $this->context->controller->confirmations[] = $this->l('Settings updated successfully.');
            }
        }


        return $output . $this->renderForm();
    }

    private function getProductsList()
    {
        $products = Product::getSimpleProducts($this->context->language->id, $this->context);
        $productList = [['id_product' => '', 'name' => $this->l('Select a product')]];

        foreach ($products as $product) {
            $productList[] = [
                'id_product' => $product['id_product'],
                'name' => $product['name'],
            ];
        }

        return $productList;
    }

    public function renderForm()
    {
        $default_lang = (int)Configuration::get('PS_LANG_DEFAULT');

        $fields_form = [
            'form' => [
                'legend' => [
                    'title' => $this->l('Promotional Banner Settings'),
                ],
                'input' => [
                    [
                        'type' => 'switch',
                        'label' => $this->l('Enable Banner'),
                        'name' => 'PROMOBANNER_ENABLED',
                        'is_bool' => true,
                        'values' => [
                            ['id' => 'active_on', 'value' => 1, 'label' => $this->l('Enabled')],
                            ['id' => 'active_off', 'value' => 0, 'label' => $this->l('Disabled')],
                        ],
                    ],
                    [
                        'type' => 'select',
                        'label' => $this->l('Display Mode'),
                        'name' => 'PROMOBANNER_DISPLAY_MODE',
                        'is_bool' => true,
                        'options' => [
                            'query' => [
                                ['id' => 'homepage', 'name' => $this->l('Only Home Page')],
                                ['id' => 'all', 'name' => $this->l('All Pages')],
                            ],
                            'id' => 'id',
                            'name' => 'name',
                        ],
                    ],
                    [
                        'type' => 'html',
                        'name' => 'section1_separator',
                        'html_content' => '<h3>Banner Content</h3>',
                    ],
                    [
                        'type' => 'textarea',
                        'label' => $this->l('Banner Title'),
                        'name' => 'PROMOBANNER_TITLE',
                    ],
                    [
                        'type' => 'select',
                        'label' => $this->l('Stock Product'),
                        'name' => 'PROMOBANNER_STOCK_PRODUCT_ID',
                        'options' => [
                            'query' => $this->getProductsList(),
                            'id' => 'id_product',
                            'name' => 'name',
                        ],
                        'desc' => $this->l('Use {{stock}} for stock, {{product_name}} for the name, and {{product_image_1}}... for images.'),
                    ],
                    [
                        'type' => 'textarea',
                        'label' => $this->l('Banner Subtitle'),
                        'name' => 'PROMOBANNER_SUBTITLE',
                    ],
                    [
                        'type' => 'text',
                        'label' => $this->l('Banner Image'),
                        'name' => 'PROMOBANNER_IMAGE',
                        'form_group_class' => 'section-appearance',
                        'desc' => $this->l('Insert image URL or use {{product_image_1]}}'),
                    ],
                    [
                        'type' => 'html',
                        'label' => $this->l('font size (title) (px)'),
                        'name' => 'PROMOBANNER_FS_TITLE',
                        'class' => 'fixed-width-sm',
                        'html_content' => '<input type="number" name="PROMOBANNER_FS_TITLE" min="0" value="' . (int) Configuration::get('PROMOBANNER_FS_TITLE') . '">'
                    ],
                    [
                        'type' => 'html',
                        'label' => $this->l('font size (subtitle) (px)'),
                        'name' => 'PROMOBANNER_FS_SUBTITLE',
                        'class' => 'fixed-width-sm',
                        'html_content' => '<input type="number" name="PROMOBANNER_FS_SUBTITLE" min="0" value="' . (int) Configuration::get('PROMOBANNER_FS_SUBTITLE') . '">'
                    ],
                    [
                        'type' => 'select',
                        'label' => $this->l('Text Alignment'),
                        'name' => 'PROMOBANNER_CONTENT_ALIGNMENT',
                        'is_bool' => true,
                        'options' => [
                            'query' => [
                                ['id' => 'left', 'name' => $this->l('Left')],
                                ['id' => 'right', 'name' => $this->l('Right')],
                                ['id' => 'center', 'name' => $this->l('Center')],
                            ],
                            'id' => 'id',
                            'name' => 'name',
                        ],
                    ],
                    [
                        'type' => 'color',
                        'label' => $this->l('Title Color'),
                        'name' => 'PROMOBANNER_TEXT_COLOR',
                    ],
                    [
                        'type' => 'color',
                        'label' => $this->l('Subtitle Color'),
                        'name' => 'PROMOBANNER_SUBTITLE_COLOR',
                    ],
                    [
                        'type' => 'select',
                        'label' => $this->l('Image Position'),
                        'name' => 'PROMOBANNER_IMAGE_POSITION',
                        'form_group_class' => 'section-appearance',
                        'options' => [
                            'query' => [
                                ['id' => 'left', 'name' => $this->l('Left')],
                                ['id' => 'right', 'name' => $this->l('Right')],
                            ],
                            'id' => 'id',
                            'name' => 'name',
                        ],
                    ],
                    [
                        'type' => 'html',
                        'label' => $this->l('Image Width (px)'),
                        'name' => 'PROMOBANNER_IMAGE_WIDTH',
                        'class' => 'fixed-width-sm',
                        'html_content' => '<input type="number" name="PROMOBANNER_IMAGE_WIDTH" min="0" value="' . (int) Configuration::get('PROMOBANNER_IMAGE_WIDTH') . '">'
                    ],
                    [
                        'type' => 'html',
                        'name' => 'section2_separator',
                        'html_content' => '<h3>Banner Appearance</h3>',
                    ],
                    [
                        'type' => 'select',
                        'label' => $this->l('Background Type'),
                        'name' => 'PROMOBANNER_BG_TYPE',
                        'options' => [
                            'query' => [
                                ['id' => 'solid', 'name' => $this->l('Solid')],
                                ['id' => 'gradient', 'name' => $this->l('Gradient')],
                            ],
                            'id' => 'id',
                            'name' => 'name',
                        ],
                    ],
                    [
                        'type' => 'color',
                        'label' => $this->l('Background Color'),
                        'name' => 'PROMOBANNER_BG_SOLID',
                        'form_group_class' => 'bg-solid-group',
                    ],
                    [
                        'type' => 'color',
                        'label' => $this->l('Gradient Start Color'),
                        'name' => 'PROMOBANNER_BG_GRADIENT_START',
                        'form_group_class' => 'bg-gradient-group',
                    ],
                    [
                        'type' => 'color',
                        'label' => $this->l('Gradient End Color'),
                        'name' => 'PROMOBANNER_BG_GRADIENT_END',
                        'form_group_class' => 'bg-gradient-group',
                    ],
                    [
                        'type' => 'switch',
                        'label' => $this->l('Auto Width'),
                        'name' => 'PROMOBANNER_WIDTH_AUTO',
                        'is_bool' => true,
                        'values' => [
                            ['id' => 'active_on', 'value' => 1, 'label' => $this->l('Yes')],
                            ['id' => 'active_off', 'value' => 0, 'label' => $this->l('No')],
                        ],
                    ],
                    [
                        'type' => 'html',
                        'label' => $this->l('Width (px)'),
                        'name' => 'PROMOBANNER_WIDTH',
                        'class' => 'fixed-width-sm',
                        'html_content' => '<input type="number" name="PROMOBANNER_WIDTH" min="0" value="' . (int) Configuration::get('PROMOBANNER_WIDTH') . '">'
                    ],
                    [
                        'type' => 'html',
                        'label' => $this->l('Max Width (px)'),
                        'name' => 'PROMOBANNER_MAXWIDTH',
                        'class' => 'fixed-width-sm',
                        'html_content' => '<input type="number" name="PROMOBANNER_MAXWIDTH" min="0" value="' . (int) Configuration::get('PROMOBANNER_MAXWIDTH') . '">'
                    ],
                    [
                        'type' => 'switch',
                        'label' => $this->l('Auto Height'),
                        'name' => 'PROMOBANNER_HEIGHT_AUTO',
                        'is_bool' => true,
                        'values' => [
                            ['id' => 'active_on', 'value' => 1, 'label' => $this->l('Yes')],
                            ['id' => 'active_off', 'value' => 0, 'label' => $this->l('No')],
                        ],
                    ],
                    [
                        'type' => 'html',
                        'label' => $this->l('Height (px)'),
                        'name' => 'PROMOBANNER_HEIGHT',
                        'class' => 'fixed-width-sm',
                        'html_content' => '<input type="number" name="PROMOBANNER_HEIGHT" min="0" value="' . (int) Configuration::get('PROMOBANNER_HEIGHT') . '">'
                    ],

                    [
                        'type' => 'html',
                        'name' => 'section3_separator',
                        'html_content' => '<h3>Banner Positioning</h3>',
                    ],
                    [
                        'type' => 'select',
                        'label' => $this->l('Behavior'),
                        'name' => 'PROMOBANNER_FLOATING',
                        'options' => [
                            'query' => [
                                ['id' => 'floating', 'name' => $this->l('Floating')],
                                ['id' => 'nofloating', 'name' => $this->l('No Floating')],
                            ],
                            'id' => 'id',
                            'name' => 'name',
                        ],
                    ],
                    [
                        'type' => 'select',
                        'label' => $this->l('Position'),
                        'name' => 'PROMOBANNER_FLOATING_POSITION',
                        'form_group_class' => 'floating-position-group',
                        'options' => [
                            'query' => [
                                ['id' => 'top-left', 'name' => $this->l('Top Left')],
                                ['id' => 'top-right', 'name' => $this->l('Top Right')],
                                ['id' => 'bottom-left', 'name' => $this->l('Bottom Left')],
                                ['id' => 'bottom-right', 'name' => $this->l('Bottom Right')],
                            ],
                            'id' => 'id',
                            'name' => 'name',
                        ],
                    ],
                    [
                        'type' => 'select',
                        'label' => $this->l('Position'),
                        'name' => 'PROMOBANNER_STANDARD_POSITION',
                        'form_group_class' => 'standard-position-group',
                        'options' => [
                            'query' => [
                                ['id' => 'top', 'name' => $this->l('Top')],
                                ['id' => 'bottom', 'name' => $this->l('Bottom')],
                            ],
                            'id' => 'id',
                            'name' => 'name',
                        ],
                    ],
                    [
                        'type' => 'html',
                        'label' => $this->l('Padding Top (px)'),
                        'name' => 'PROMOBANNER_PADDING_TOP',
                        'html_content' => '<input type="number" name="PROMOBANNER_PADDING_TOP" min="0" value="' . (int) Configuration::get('PROMOBANNER_PADDING_TOP') . '">'
                    ],
                    [
                        'type' => 'html',
                        'label' => $this->l('Padding Bottom (px)'),
                        'name' => 'PROMOBANNER_PADDING_BOTTOM',
                        'class' => 'fixed-width-sm',
                        'html_content' => '<input type="number" name="PROMOBANNER_PADDING_BOTTOM" min="0" value="' . (int) Configuration::get('PROMOBANNER_PADDING_BOTTOM') . '">'
                    ],
                    [
                        'type' => 'html',
                        'label' => $this->l('Padding Left (px)'),
                        'name' => 'PROMOBANNER_PADDING_LEFT',
                        'class' => 'fixed-width-sm',
                        'html_content' => '<input type="number" name="PROMOBANNER_PADDING_LEFT" min="0" value="' . (int) Configuration::get('PROMOBANNER_PADDING_LEFT') . '">'
                    ],
                    [
                        'type' => 'html',
                        'label' => $this->l('Padding Right (px)'),
                        'name' => 'PROMOBANNER_PADDING_RIGHT',
                        'class' => 'fixed-width-sm',
                        'html_content' => '<input type="number" name="PROMOBANNER_PADDING_RIGHT" min="0" value="' . (int) Configuration::get('PROMOBANNER_PADDING_RIGHT') . '">'
                    ],
                    [
                        'type' => 'html',
                        'label' => $this->l('Radius (px)'),
                        'name' => 'PROMOBANNER_RADIUS',
                        'class' => 'fixed-width-sm',
                        'html_content' => '<input type="number" name="PROMOBANNER_RADIUS" min="0" value="' . (int) Configuration::get('PROMOBANNER_RADIUS') . '">'
                    ],
                    [
                        'type' => 'html',
                        'name' => 'section4_separator',
                        'html_content' => '<h3>CTA Appearance</h3>',
                    ],
                    [
                        'type' => 'switch',
                        'label' => $this->l('Show CTA'),
                        'name' => 'PROMOBANNER_SHOW_CTA',
                        'is_bool' => true,
                        'values' => [
                            ['id' => 'button_on', 'value' => 1, 'label' => $this->l('Show')],
                            ['id' => 'button_off', 'value' => 0, 'label' => $this->l('Hide')],
                        ],
                    ],
                    [
                        'type' => 'text',
                        'label' => $this->l('CTA Text'),
                        'name' => 'PROMOBANNER_CTA_TEXT',
                    ],
                    [
                        'type' => 'color',
                        'label' => $this->l('CTA Text Color'),
                        'name' => 'PROMOBANNER_CTA_COLOR',
                    ],
                    [
                        'type' => 'color',
                        'label' => $this->l('CTA Background Color'),
                        'name' => 'PROMOBANNER_CTA_BG',
                    ],
                    [
                        'type' => 'text',
                        'label' => $this->l('Link URL'),
                        'name' => 'PROMOBANNER_LINK',
                    ],
                    [
                        'type' => 'html',
                        'label' => $this->l('Padding Y'),
                        'name' => 'PROMOBANNER_CTA_BTN_PY',
                        'class' => 'fixed-width-sm',
                        'html_content' => '<input type="number" name="PROMOBANNER_CTA_BTN_PY" min="0" value="' . (int) Configuration::get('PROMOBANNER_CTA_BTN_PY') . '">'
                    ],
                    [
                        'type' => 'html',
                        'label' => $this->l('Padding X'),
                        'name' => 'PROMOBANNER_CTA_BTN_PX',
                        'class' => 'fixed-width-sm',
                        'html_content' => '<input type="number" name="PROMOBANNER_CTA_BTN_PX" min="0" value="' . (int) Configuration::get('PROMOBANNER_CTA_BTN_PX') . '">'
                    ],
                    [
                        'type' => 'html',
                        'label' => $this->l('Radius (px)'),
                        'name' => 'PROMOBANNER_CTA_BTN_RADIUS',
                        'class' => 'fixed-width-sm',
                        'html_content' => '<input type="number" name="PROMOBANNER_CTA_BTN_RADIUS" min="0" value="' . (int) Configuration::get('PROMOBANNER_CTA_BTN_RADIUS') . '">'
                    ],
                    [
                        'type' => 'switch',
                        'label' => $this->l('Full Width'),
                        'name' => 'PROMOBANNER_CTA_BTN_FULLWIDTH',
                        'is_bool' => true,
                        'values' => [
                            ['id' => 'button_on', 'value' => 1, 'label' => $this->l('Yes')],
                            ['id' => 'button_off', 'value' => 0, 'label' => $this->l('No')],
                        ],
                    ],
                    [
                        'type' => 'select',
                        'label' => $this->l('Button Position'),
                        'name' => 'PROMOBANNER_CTA_BTN_POSITION',
                        'class' => 'fixed-width-sm',
                        'options' => [
                            'query' => [
                                ['id' => 'top', 'name' => $this->l('Top')],
                                ['id' => 'bottom', 'name' => $this->l('Bottom')],
                                ['id' => 'left', 'name' => $this->l('Left')],
                                ['id' => 'right', 'name' => $this->l('Right')],
                            ],
                            'id' => 'id',
                            'name' => 'name',
                        ],
                    ],
                    [
                        'type' => 'html',
                        'name' => 'section5_separator',
                        'html_content' => '<h3>Countdown Component</h3>',
                    ],
                    [
                        'type' => 'switch',
                        'label' => $this->l('Enable Countdown'),
                        'name' => 'PROMOBANNER_COUNTDOWN_ENABLED',
                        'is_bool' => true,
                        'values' => [
                            ['id' => 'button_on', 'value' => 1, 'label' => $this->l('Show')],
                            ['id' => 'button_off', 'value' => 0, 'label' => $this->l('Hide')],
                        ],
                    ],
                    [
                        'type' => 'switch',
                        'label' => $this->l('Full Width'),
                        'name' => 'PROMOBANNER_COUNTDOWN_FULLWIDTH',
                        'is_bool' => true,
                        'values' => [
                            ['id' => 'button_on', 'value' => 1, 'label' => $this->l('Yes')],
                            ['id' => 'button_off', 'value' => 0, 'label' => $this->l('No')],
                        ],
                    ],
                    [
                        'type' => 'date',
                        'label' => $this->l('Countdown End At'),
                        'name' => 'PROMOBANNER_COUNTDOWN_END',
                    ],
                ],
                'submit' => [
                    'title' => $this->l('Save'),
                    'name' => 'submit_promobanner'
                ],
            ],
        ];



        $helper = new HelperForm();
        $helper->module = $this;
        $helper->name_controller = $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->currentIndex = AdminController::$currentIndex . '&configure=' . $this->name;
        $helper->default_form_language = $default_lang;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG');
        $helper->fields_value = $this->getConfigFieldsValues();

        $form = $helper->generateForm([$fields_form]);

        $this->context->smarty->assign([
            'banner_title' => Configuration::get('PROMOBANNER_TITLE'),
            'banner_subtitle' => Configuration::get('PROMOBANNER_SUBTITLE'),
            'banner_link' => Configuration::get('PROMOBANNER_LINK'),
            'banner_bg' => Configuration::get('PROMOBANNER_BG'),
            'banner_text_color' => Configuration::get('PROMOBANNER_TEXT_COLOR'),
            'banner_subtitle_color' => Configuration::get('PROMOBANNER_SUBTITLE_COLOR'),
            'banner_position' => Configuration::get('PROMOBANNER_POSITION'),
            'banner_bg_type' => Configuration::get('PROMOBANNER_BG_TYPE'),
            'banner_position_floating' => Configuration::get('PROMOBANNER_FLOATING_POSITION'),
            'banner_bg_gradient_start' => Configuration::get('PROMOBANNER_BG_GRADIENT_START'),
            'banner_bg_gradient_end' => Configuration::get('PROMOBANNER_BG_GRADIENT_END'),
            'banner_bg_solid' => Configuration::get('PROMOBANNER_BG_SOLID'),
            'floating_mode' => Configuration::get('PROMOBANNER_FLOATING'),
            'standard_position' => Configuration::get('PROMOBANNER_STANDARD_POSITION'),
            'banner_show_cta' => Configuration::get('PROMOBANNER_SHOW_CTA'),
            'banner_cta_btn_px' => Configuration::get('PROMOBANNER_CTA_BTN_PX'),
            'banner_cta_btn_py' => Configuration::get('PROMOBANNER_CTA_BTN_PY'),
            'banner_cta_btn_radius' => Configuration::get('PROMOBANNER_CTA_BTN_RADIUS'),
            'banner_cta_btn_position' => Configuration::get('PROMOBANNER_CTA_BTN_POSITION'),
            'banner_countdown_fullwidth' => Configuration::get('PROMOBANNER_COUNTDOWN_FULLWIDTH'),
            'banner_cta_btn_fullwidth' => Configuration::get('PROMOBANNER_CTA_BTN_FULLWIDTH'),
            'banner_countdown_enabled' => Configuration::get('PROMOBANNER_COUNTDOWN_ENABLED'),
            'banner_countdown_end' => Configuration::get('PROMOBANNER_COUNTDOWN_END'),
            'banner_padding_top' => Configuration::get('PROMOBANNER_PADDING_TOP'),
            'banner_padding_bottom' => Configuration::get('PROMOBANNER_PADDING_BOTTOM'),
            'banner_padding_left' => Configuration::get('PROMOBANNER_PADDING_LEFT'),
            'banner_padding_right' => Configuration::get('PROMOBANNER_PADDING_RIGHT'),
            'banner_width' => Configuration::get('PROMOBANNER_WIDTH'),
            'banner_maxwidth' => Configuration::get('PROMOBANNER_MAXWIDTH'),
            'banner_image_width' => Configuration::get('PROMOBANNER_IMAGE_WIDTH'),
            'banner_height' => Configuration::get('PROMOBANNER_HEIGHT'),
            'banner_auto_height' => Configuration::get('PROMOBANNER_HEIGHT_AUTO'),
            'banner_auto_width' => Configuration::get('PROMOBANNER_WIDTH_AUTO'),
            'banner_content_alignment' => Configuration::get('PROMOBANNER_CONTENT_ALIGNMENT'),
            'banner_image' => Configuration::get('PROMOBANNER_IMAGE'),
            'banner_image_position' => Configuration::get('PROMOBANNER_IMAGE_POSITION'),
            'banner_fs_title' => Configuration::get('PROMOBANNER_FS_TITLE'),
            'banner_fs_subtitle' => Configuration::get('PROMOBANNER_FS_SUBTITLE'),
            'banner_radius' => Configuration::get('PROMOBANNER_RADIUS'),
            'banner_cta_bg' => Configuration::get('PROMOBANNER_CTA_BG'),
            'banner_cta_color' => Configuration::get('PROMOBANNER_CTA_COLOR'),
            'banner_cta_text' => Configuration::get('PROMOBANNER_CTA_TEXT'),
            'form_content' => $form,
            'module_dir' => $this->_path,
        ]);

        return $this->display(__FILE__, 'views/templates/admin/config.tpl') . $this->renderPositionToggleJS() . $this->renderBackgroundToggleJS();
    }


    protected function getConfigFieldsValues()
    {
        return array(
            'PROMOBANNER_ENABLED' => Tools::getValue('PROMOBANNER_ENABLED', Configuration::get('PROMOBANNER_ENABLED')),
            'PROMOBANNER_DISPLAY_MODE' => Tools::getValue('PROMOBANNER_DISPLAY_MODE', Configuration::get('PROMOBANNER_DISPLAY_MODE')),
            'PROMOBANNER_TITLE' => Tools::getValue('PROMOBANNER_TITLE', Configuration::get('PROMOBANNER_TITLE')),
            'PROMOBANNER_SUBTITLE' => Tools::getValue('PROMOBANNER_SUBTITLE', Configuration::get('PROMOBANNER_SUBTITLE')),
            'PROMOBANNER_LINK' => Tools::getValue('PROMOBANNER_LINK', Configuration::get('PROMOBANNER_LINK')),
            'PROMOBANNER_TEXT_COLOR' => Tools::getValue('PROMOBANNER_TEXT_COLOR', Configuration::get('PROMOBANNER_TEXT_COLOR')),
            'PROMOBANNER_SUBTITLE_COLOR' => Tools::getValue('PROMOBANNER_SUBTITLE_COLOR', Configuration::get('PROMOBANNER_SUBTITLE_COLOR')),
            'PROMOBANNER_FLOATING' => Tools::getValue('PROMOBANNER_FLOATING', Configuration::get('PROMOBANNER_FLOATING')),
            'PROMOBANNER_FLOATING_POSITION' => Tools::getValue('PROMOBANNER_FLOATING_POSITION', Configuration::get('PROMOBANNER_FLOATING_POSITION')),
            'PROMOBANNER_STANDARD_POSITION' => Tools::getValue('PROMOBANNER_STANDARD_POSITION', Configuration::get('PROMOBANNER_STANDARD_POSITION')),
            'PROMOBANNER_BG_TYPE' => Tools::getValue('PROMOBANNER_BG_TYPE', Configuration::get('PROMOBANNER_BG_TYPE')),
            'PROMOBANNER_BG_SOLID' => Tools::getValue('PROMOBANNER_BG_SOLID', Configuration::get('PROMOBANNER_BG_SOLID')),
            'PROMOBANNER_BG_GRADIENT_START' => Tools::getValue('PROMOBANNER_BG_GRADIENT_START', Configuration::get('PROMOBANNER_BG_GRADIENT_START')),
            'PROMOBANNER_BG_GRADIENT_END' => Tools::getValue('PROMOBANNER_BG_GRADIENT_END', Configuration::get('PROMOBANNER_BG_GRADIENT_END')),
            'PROMOBANNER_SHOW_CTA' => Tools::getValue('PROMOBANNER_SHOW_CTA', Configuration::get('PROMOBANNER_SHOW_CTA')),
            'PROMOBANNER_CTA_BTN_PX' => Tools::getValue('PROMOBANNER_CTA_BTN_PX', Configuration::get('PROMOBANNER_CTA_BTN_PX')),
            'PROMOBANNER_CTA_BTN_PY' => Tools::getValue('PROMOBANNER_CTA_BTN_PY', Configuration::get('PROMOBANNER_CTA_BTN_PY')),
            'PROMOBANNER_CTA_BTN_RADIUS' => Tools::getValue('PROMOBANNER_CTA_BTN_RADIUS', Configuration::get('PROMOBANNER_CTA_BTN_RADIUS')),
            'PROMOBANNER_CTA_BTN_POSITION' => Tools::getValue('PROMOBANNER_CTA_BTN_POSITION', Configuration::get('PROMOBANNER_CTA_BTN_POSITION')),
            'PROMOBANNER_COUNTDOWN_FULLWIDTH' => Tools::getValue('PROMOBANNER_COUNTDOWN_FULLWIDTH', Configuration::get('PROMOBANNER_COUNTDOWN_FULLWIDTH')),
            'PROMOBANNER_CTA_BTN_FULLWIDTH' => Tools::getValue('PROMOBANNER_CTA_BTN_FULLWIDTH', Configuration::get('PROMOBANNER_CTA_BTN_FULLWIDTH')),
            'PROMOBANNER_COUNTDOWN_ENABLED' => Tools::getValue('PROMOBANNER_COUNTDOWN_ENABLED', Configuration::get('PROMOBANNER_COUNTDOWN_ENABLED')),
            'PROMOBANNER_COUNTDOWN_END' => Tools::getValue('PROMOBANNER_COUNTDOWN_END', Configuration::get('PROMOBANNER_COUNTDOWN_END')),
            'PROMOBANNER_PADDING_TOP' => Tools::getValue('PROMOBANNER_PADDING_TOP', Configuration::get('PROMOBANNER_PADDING_TOP')),
            'PROMOBANNER_PADDING_BOTTOM' => Tools::getValue('PROMOBANNER_PADDING_BOTTOM', Configuration::get('PROMOBANNER_PADDING_BOTTOM')),
            'PROMOBANNER_PADDING_LEFT' => Tools::getValue('PROMOBANNER_PADDING_LEFT', Configuration::get('PROMOBANNER_PADDING_LEFT')),
            'PROMOBANNER_PADDING_RIGHT' => Tools::getValue('PROMOBANNER_PADDING_RIGHT', Configuration::get('PROMOBANNER_PADDING_RIGHT')),
            'PROMOBANNER_PADDING_RIGHT' => Tools::getValue('PROMOBANNER_PADDING_RIGHT', Configuration::get('PROMOBANNER_PADDING_RIGHT')),
            'PROMOBANNER_WIDTH' => Tools::getValue('PROMOBANNER_WIDTH', Configuration::get('PROMOBANNER_WIDTH')),
            'PROMOBANNER_MAXWIDTH' => Tools::getValue('PROMOBANNER_MAXWIDTH', Configuration::get('PROMOBANNER_MAXWIDTH')),
            'PROMOBANNER_IMAGE_WIDTH' => Tools::getValue('PROMOBANNER_IMAGE_WIDTH', Configuration::get('PROMOBANNER_IMAGE_WIDTH')),
            'PROMOBANNER_HEIGHT' => Tools::getValue('PROMOBANNER_HEIGHT', Configuration::get('PROMOBANNER_HEIGHT')),
            'PROMOBANNER_HEIGHT_AUTO' => Tools::getValue('PROMOBANNER_HEIGHT_AUTO', Configuration::get('PROMOBANNER_HEIGHT_AUTO')),
            'PROMOBANNER_WIDTH_AUTO' => Tools::getValue('PROMOBANNER_WIDTH_AUTO', Configuration::get('PROMOBANNER_WIDTH_AUTO')),
            'PROMOBANNER_CONTENT_ALIGNMENT' => Tools::getValue('PROMOBANNER_CONTENT_ALIGNMENT', Configuration::get('PROMOBANNER_CONTENT_ALIGNMENT')),
            'PROMOBANNER_IMAGE' => Tools::getValue('PROMOBANNER_IMAGE', Configuration::get('PROMOBANNER_IMAGE')),
            'PROMOBANNER_IMAGE_POSITION' => Tools::getValue('PROMOBANNER_IMAGE_POSITION', Configuration::get('PROMOBANNER_IMAGE_POSITION')),
            'PROMOBANNER_FS_SUBTITLE' => Tools::getValue('PROMOBANNER_FS_SUBTITLE', Configuration::get('PROMOBANNER_FS_SUBTITLE')),
            'PROMOBANNER_FS_TITLE' => Tools::getValue('PROMOBANNER_FS_TITLE', Configuration::get('PROMOBANNER_TITLE')),
            'PROMOBANNER_RADIUS' => Tools::getValue('PROMOBANNER_RADIUS', Configuration::get('PROMOBANNER_RADIUS')),
            'PROMOBANNER_CTA_BG' => Tools::getValue('PROMOBANNER_CTA_BG', Configuration::get('PROMOBANNER_CTA_BG')),
            'PROMOBANNER_CTA_COLOR' => Tools::getValue('PROMOBANNER_CTA_COLOR', Configuration::get('PROMOBANNER_CTA_COLOR')),
            'PROMOBANNER_CTA_TEXT' => Tools::getValue('PROMOBANNER_CTA_TEXT', Configuration::get('PROMOBANNER_CTA_TEXT')),
            'PROMOBANNER_STOCK_PRODUCT_ID' => Tools::getValue('PROMOBANNER_STOCK_PRODUCT_ID', Configuration::get('PROMOBANNER_STOCK_PRODUCT_ID')),
        );
    }

    protected function renderPositionToggleJS()
    {
        return '<script>
        document.addEventListener("DOMContentLoaded", function () {
            const modeSelect = document.querySelector("select[name=PROMOBANNER_FLOATING]");
            const floatingGroup = document.querySelector(".floating-position-group");
            const standardGroup = document.querySelector(".standard-position-group");
    
            function togglePositionFields() {
                const mode = modeSelect.value;
                if (mode === "floating") {
                    floatingGroup.style.display = "block";
                    standardGroup.style.display = "none";
                } else {
                    floatingGroup.style.display = "none";
                    standardGroup.style.display = "block";
                }
            }
    
            modeSelect.addEventListener("change", togglePositionFields);
            togglePositionFields(); // call on load
        });
        </script>';
    }

    protected function renderBackgroundToggleJS()
    {
        return '<script>
        document.addEventListener("DOMContentLoaded", function () {
            const bgTypeSelect = document.querySelector("select[name=PROMOBANNER_BG_TYPE]");
            const solidGroup = document.querySelector(".bg-solid-group");
            const gradientGroup = document.querySelectorAll(".bg-gradient-group");
    
            function toggleBgFields() {
                const type = bgTypeSelect.value;
                if (type === "solid") {
                    solidGroup.style.display = "block";
                    gradientGroup.forEach(el => el.style.display = "none");
                } else {
                    solidGroup.style.display = "none";
                    gradientGroup.forEach(el => el.style.display = "block");
                }
            }
    
            bgTypeSelect.addEventListener("change", toggleBgFields);
            toggleBgFields();
        });
        </script>';
    }
}
