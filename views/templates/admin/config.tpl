<style>
.input-group.col-lg-4{
    width:100%
}
.form-group-title-subtitle .form-group {
	display: inline-block;
	width: 48%;
	margin-right: 4%;
}

.form-group .col-lg-6{
    width: 100%;
}

#main{
    padding-bottom:0 !important;
}

.panel-heading{
	border-bottom: 1px solid #ddd !important;
	position: sticky;
	top: 0px;
	z-index: 99;
	background: white;
}

.panel-footer {
	position: sticky;
	bottom: 0px;
	background: white !important;
	z-index: 99;
}

.panel{
    margin:0 !important;
}
</style>
<div style="
    gap:20px;
    font-family: 'Inter', sans-serif;
    display: grid;
    grid-template-columns: 500px 1fr;
    height: calc(100vh - 191px);
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    overflow: hidden;
">
    <div style="
        overflow-y: auto;
        background-color: #f9f9f9;
        border-right: 1px solid #eaeaea;
        height: 100%;
    ">
        {$form_content}
    </div>
    <div style="
        height: 100%;
        display: grid;
        padding: 0;
        position:relative;
    ">
        <div id="banner-shadow-root"></div>
        <promo-banner id="promoBanner"></promo-banner>
    </div>
</div>
<script src="{$module_dir|escape:'htmlall':'UTF-8'}views/js/admin.js"></script>
