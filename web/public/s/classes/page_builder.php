<?php

/**
* @Auther: bhief
* @Version: 1.0
*
* Builds pages
*
**/
class page_builder {
    public $__root;

	public function __construct($templates){
        $this->__root = $templates;
	}

    function return_template_replace(string $template, array $inputs) {
        $__template_file = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/" . $this->__root . "/" . $template);

        foreach($inputs as $key => $input) {
            $__template_file = str_replace("{{" . $key . "}}", $input, $__template_file);
        }

        return $__template_file;
    }

    /* Thanks https://stackoverflow.com/questions/1309800/php-eval-that-evaluates-html-php */
    function render($script, array $vars = array()) {
        extract($vars);

        ob_start();
        require $script;
        return ob_get_clean();
    }
}

?>