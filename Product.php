<?php
/**
 * Override Class ProductCore
 */
class Product extends ProductCore {
	/*
    * module: kj_productfields
    * date: 2021-04-15 11:32:43
    * version: 1.1.2
    */
    public $custom_field_lang_wysiwyg;
    public $nutriscore;
    public $product_carrousel;
	 
	/*
    * module: kj_productfields
    * date: 2021-04-15 11:32:43
    * version: 1.1.2
    */
    public function __construct($id_product = null, $full = false, $id_lang = null, $id_shop = null, Context $context = null){
        self::$definition['fields']['product_carrousel']   = [
            'type' => self::TYPE_STRING,
            'lang' => false,
            'required' => false,
            'validate' => 'isCleanHtml'
        ];
        self::$definition['fields']['custom_field_lang_wysiwyg'] = [
            'type' => self::TYPE_HTML,
            'lang' => true,
            'required' => false,
            'validate' => 'isCleanHtml'
        ];

        self::$definition['fields']['nutriscore']     = [
            'type' => self::TYPE_STRING,
            'required' => false, 'size' => 10
        ];

        parent::__construct($id_product, $full, $id_lang, $id_shop, $context);
	}
}