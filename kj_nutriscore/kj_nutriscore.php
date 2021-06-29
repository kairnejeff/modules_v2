<?php


class Kj_NutriScore extends Module
{
    private $url;
    public function __construct() {
        $this->name = 'kj_nutriscore';
        $this->author = 'Jing LEI';
        $this->version = '1.1.0';
        $this->need_instance = 0;
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Product Nutriscore');
        $this->description = $this->l('Ajouter un champ nutriscore aux produits');
        $this->ps_versions_compliancy = array('min' => '1.7.1', 'max' => _PS_VERSION_);
        $this->url="https://world.openfoodfacts.org/api/v0/product/";
    }

    public function install() {
        if (!parent::install() || !$this->_installSql()
            //Pour les hooks suivants regarder le fichier src\PrestaShopBundle\Resources\views\Admin\Product\form.html.twig
            || ! $this->registerHook('displayAdminProductsMainStepLeftColumnMiddle')
        ) {
            return false;
        }

        return true;
    }

    public function uninstall() {
        return parent::uninstall() && $this->_unInstallSql();
    }

    public function _displayForm(){
        $defaultLang = (int)Configuration::get('PS_LANG_DEFAULT');
        $fields_form = array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('Settings'),
                    'icon' => 'icon-cogs'
                ),
                'submit' => array(
                    'title' => $this->l('Mettre à jour nutriscore')
                )
            ),
        );
        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $helper->default_form_language =$defaultLang;
        $helper->module = $this;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitUpdate';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false).'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->tpl_vars = array(
            'uri' => $this->getPathUri()
        );

        return $helper->generateForm(array($fields_form));
    }

    public function getContent()
    {
        $html= '';
        if(Tools::isSubmit('submitUpdate')){
           $sql= 'SELECT id_product,ean13,reference
                FROM `' . _DB_PREFIX_ . 'product` where ean13 !=\' \'';
           $rq = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);

           foreach ($rq as $item) {
                if($item['ean13']!==""){
                   $nutriscore= $this->callAPI($item['ean13']);
                   $this->updateNutriscore($nutriscore,$item['id_product']);
                   $html.=$item['reference']." ";
                }
           }
            $html.=$html.'Mettre à jour réussi';
        }
        return  $html.$this->_displayForm();
    }

    private function updateNutriscore($nutriscore,$idProduct){
        $sqlUpdate='update `' . _DB_PREFIX_ . 'product` set `nutriscore` =\''.$nutriscore. '\' where `id_product` ='.$idProduct;
        Db::getInstance()->execute($sqlUpdate);
    }

    private function callAPI($ean)
    {
        $final=$this->url.$ean.".json";
        $result = json_decode(file_get_contents($final));
        if(isset($result->product->nutrition_grade_fr)){
            return $result->product->nutrition_grade_fr;
        }
        return ' ';
    }

    /**
     * Modifications sql du module
     * @return boolean
     */
    protected function _installSql() {
        $sqlInstallLang = "ALTER TABLE " . _DB_PREFIX_ . "product "
            . "ADD nutriscore TEXT NULL";
        $returnSqlLang = Db::getInstance()->execute($sqlInstallLang);

        return  $returnSqlLang;
    }

    /**
     * Suppression des modification sql du module
     * @return boolean
     */
    protected function _unInstallSql() {
        $sqlInstallLang = "ALTER TABLE " . _DB_PREFIX_ . "product "
            . "DROP nutriscore";

        $returnSqlLang = Db::getInstance()->execute($sqlInstallLang);

        return  $returnSqlLang;
    }

    /**
     * Affichage des informations supplémentaires sur la fiche produit
     * @param type $params
     * @return type
     */
    public function hookDisplayAdminProductsMainStepLeftColumnMiddle($params) {
        $product = new Product($params['id_product']);
        $languages = Language::getLanguages($active);
        $this->context->smarty->assign(array(
                'nutriscore' => $product->nutriscore,
            )
        );
        return $this->display(__FILE__, 'views/templates/hook/amproductfields.tpl');
    }


}