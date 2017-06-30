<?php
/**
 * CClientScript class file.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @link http://www.yiiframework.com/
 * @copyright 2008-2013 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

/**
 * CClientScript manages JavaScript and CSS stylesheets for views.
 *
 * @property string $coreScriptUrl The base URL of all core javascript files.
 *          
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @package system.web
 * @since 1.0
 */
class MyClientScript extends CClientScript
{
    const POS_END2 = 10;
    
    public $latePackages=array();

    /**
     * Renders the specified core javascript library.
     */
    public function renderCoreScripts()
    {
        if ($this->coreScripts === null)
            return;
        
        parent::renderCoreScripts ();        
        
        $cssFiles = array ();
        
        foreach ( $this->coreScripts as $name => $package )
        {
            $baseUrl = $this->getPackageBaseUrl ( $name );
            if (! empty ( $package ['css'] ))
            {
                $baseCssUrl = empty ( $package ['baseCssUrl'] ) ? $baseUrl : $package ['baseCssUrl'];
                foreach ( $package ['css'] as $css )
                {
                    $cssFiles [$baseCssUrl . '/' . $css] = '';
                    if(isset($this->cssFiles[$baseUrl . '/' . $css]))
                        unset($this->cssFiles[$baseUrl . '/' . $css]);
                }
            }
        }
        // merge in place
        if ($cssFiles !== array ())
        {
            foreach ( $this->cssFiles as $cssFile => $media )
                $cssFiles [$cssFile] = $media;
            $this->cssFiles = $cssFiles;
        }
    }

    /**
     * Inserts the scripts at the end of the body section.
     * 
     * @param string $output
     *            the output to be inserted with scripts.
     */
    public function renderBodyEnd(&$output)
    {
        if (! isset ( $this->scriptFiles [self::POS_END2] ) && ! isset ( $this->scriptFiles [self::POS_END] ) && ! isset ( $this->scripts [self::POS_END] ) &&
                 ! isset ( $this->scripts [self::POS_READY] ) && ! isset ( $this->scripts [self::POS_LOAD] ))
            return;
        
        $fullPage = 0;
        $output = preg_replace ( '/(<\\/body\s*>)/is', '<###end###>$1', $output, 1, $fullPage );
        $html = '';
        if (isset ( $this->scriptFiles [self::POS_END] ))
        {
            foreach ( $this->scriptFiles [self::POS_END] as $scriptFileUrl => $scriptFileValue )
            {
                if (is_array ( $scriptFileValue ))
                    $html .= CHtml::scriptFile ( $scriptFileUrl, $scriptFileValue ) . "\n";
                else
                    $html .= CHtml::scriptFile ( $scriptFileUrl ) . "\n";
            }
        }
        $scripts = isset ( $this->scripts [self::POS_END] ) ? $this->scripts [self::POS_END] : array ();
        if (isset ( $this->scripts [self::POS_READY] ))
        {
            if ($fullPage)
                $scripts [] = "jQuery(function($) {\n" . implode ( "\n", $this->scripts [self::POS_READY] ) . "\n});";
            else
                $scripts [] = implode ( "\n", $this->scripts [self::POS_READY] );
        }
        if (isset ( $this->scripts [self::POS_LOAD] ))
        {
            if ($fullPage)
                $scripts [] = "jQuery(window).on('load',function() {\n" . implode ( "\n", 
                        $this->scripts [self::POS_LOAD] ) . "\n});";
            else
                $scripts [] = implode ( "\n", $this->scripts [self::POS_LOAD] );
        }
        
        if (isset ( $this->scriptFiles [self::POS_END2] ))
        {
            foreach ( $this->scriptFiles [self::POS_END2] as $scriptFileUrl => $scriptFileValue )
            {
                if (is_array ( $scriptFileValue ))
                    $html .= CHtml::scriptFile ( $scriptFileUrl, $scriptFileValue ) . "\n";
                else
                    $html .= CHtml::scriptFile ( $scriptFileUrl ) . "\n";
            }
        }
        
        if (! empty ( $scripts ))
            $html .= $this->renderScriptBatch ( $scripts );
        
        if ($fullPage)
            $output = str_replace ( '<###end###>', $html, $output );
        else
            $output = $output . $html;
    }
}
