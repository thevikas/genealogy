<?php
/**
 * CApcCache class file
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @link http://www.yiiframework.com/
 * @copyright 2008-2013 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

/**
 * CApcCache provides APC caching in terms of an application component.
 *
 * The caching is based on {@link http://www.php.net/apc APC}.
 * To use this application component, the APC PHP extension must be loaded.
 *
 * See {@link CCache} manual for common cache operations that are supported by CApcCache.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @package system.caching
 * @since 1.0
 */
class WPSuperCache extends CCache
{
	/**
	 * Initializes this application component.
	 * This method is required by the {@link IApplicationComponent} interface.
	 * It checks the availability of APC.
	 * @throws CException if APC cache extension is not loaded or is disabled.
	 */
	public function init()
	{
		parent::init();
	}

	/**
	 * Retrieves a value from cache with a specified key.
	 * This is the implementation of the method declared in the parent class.
	 * @param string $key a unique key identifying the cached value
	 * @return string|boolean the value stored in cache, false if the value is not in the cache or expired.
	 */
	protected function getValue($key)
	{
            if(function_exists('apc_fetch'))
                return apc_fetch($key);
            else if(function_exists ('apcu_fetch'))
                return apcu_fetch($key);
            return false;
	}

	/**
	 * Retrieves multiple values from cache with the specified keys.
	 * @param array $keys a list of keys identifying the cached values
	 * @return array a list of cached values indexed by the keys
	 */
	protected function getValues($keys)
	{
	    return apc_fetch($keys);
	}

    /**
     * Stores a value identified by a key in cache.
     * This is the implementation of the method declared in the parent class.
     *
     * @param string $key
     *            the key identifying the value to be cached
     * @param string $value
     *            the value to be cached
     * @param integer $expire
     *            the number of seconds in which the cached value will expire. 0 means never expire.
     * @return boolean true if the value is successfully stored into cache, false otherwise
     */
    protected function setValue($key, $value, $expire)
    {
        $this->extractDependency($value);
        if(function_exists('apc_store'))
        {
            return apc_store ( $key, $value, $expire );
        }
        else if(function_exists('apcu_store'))
        {
            return apcu_store ( $key, $value, $expire );
        }
        else
        {
            return false;
        }
    }

    public function extractDependency($value)
    {
        if(!is_array($value))
            $value = unserialize ($value );

        if (is_array ( $value ) && $value [1] instanceof ICacheDependency)
        {
            if ($value [1] instanceof CChainedCacheDependency)
            {
                $chain = $value [1];
                foreach ( $chain->getDependencies () as $dep )
                {
                    $this->processDependency($dep->stateName);
                }
            }
            else if ($value [1] instanceof CGlobalStateCacheDependency)
            {
                $this->processDependency($value [1]->stateName);
            }
        }

    }

	/**
	 * Stores a value identified by a key into cache if the cache does not contain this key.
	 * This is the implementation of the method declared in the parent class.
	 *
	 * @param string $key the key identifying the value to be cached
	 * @param string $value the value to be cached
	 * @param integer $expire the number of seconds in which the cached value will expire. 0 means never expire.
	 * @return boolean true if the value is successfully stored into cache, false otherwise
	 */
	protected function addValue($key,$value,$expire)
	{
	    return apc_add($key,$value,$expire);
	}

	/**
	 * Deletes a value with the specified key from cache
	 * This is the implementation of the method declared in the parent class.
	 * @param string $key the key of the value to be deleted
	 * @return boolean if no error happens during deletion
	 */
	protected function deleteValue($key)
	{
	    $value = $this->getValue($key);
	    if(!empty($value))
	        $this->extractDependency($value);
        if(function_exists('apc_delete'))
            return apc_delete($key);
        if(function_exists('apcu_delete'))
            return apcu_delete($key);
        return false;
	}

	/**
	 * Deletes all values from cache.
	 * This is the implementation of the method declared in the parent class.
	 * @return boolean whether the flush operation was successful.
	 * @since 1.1.5
	 */
	protected function flushValues()
	{
		return apc_clear_cache('user');
	}

	public function processDependency($stateName)
	{
	    $mats = [];
	    if(!preg_match('/^(?<type>.)(?<id>\d+)$/', $stateName,$mats))
	    {
	        return;
	    }

	    switch($mats['type'])
	    {
	        case 'p':
	            //project
	            $id = $mats['id'];
	            $proj = Project::model()->cacheModel()->findByPk($id);
	            $this->deleteSuperCache(Yii::app()->createUrl('/admin/aproject/super',['id' => $id,'lang' => 'en']));
	            $this->deleteSuperCache(Yii::app()->createUrl('/admin/aproject/super',['id' => $id,'lang' => 'es']));
	            Yii::app()->cache->delete("{$id}_pmajors");
	            break;
	        case 'c':
	            //COMPANY
	            $id = $mats['id'];
	            if(Yii::app()->user->checkAccess(AuthConstants::OPT_NO_MODERATION))
	            {
    	            $this->deleteSuperCache(Yii::app()->createUrl('/admin/acompany/super',['id' => $id,'lang' => 'en']));
    	            $this->deleteSuperCache(Yii::app()->createUrl('/admin/acompany/super',['id' => $id,'lang' => 'es']));
	            }
	            $this->deleteSuperCache(Yii::app()->createUrl('/editor/ecompany/index',['id' => $id,'lang' => 'en']));
	            $this->deleteSuperCache(Yii::app()->createUrl('/editor/ecompany/index',['id' => $id,'lang' => 'es']));
	            Yii::app()->cache->delete("{$id}_cmajors");
	            break;
	        case 's':
	            //sector
	            $id = $mats['id'];
	            $this->deleteSuperCache(Yii::app()->createUrl('/admin/asector/super',['id' => $id,'lang' => 'en']));
	            $this->deleteSuperCache(Yii::app()->createUrl('/admin/asector/super',['id' => $id,'lang' => 'es']));

	            $this->deleteSuperCache(Yii::app()->createUrl('/admin/asector/fullview',['id' => $id,'lang' => 'en']));
	            $this->deleteSuperCache(Yii::app()->createUrl('/admin/asector/fullview',['id' => $id,'lang' => 'es']));
	            #201603041405:vikas:Gurgaon:#425
	            Yii::app()->cache->delete('treelisting');
	            Yii::app()->cache->delete("{$id}_smajors");

	            break;
            default:
	            error_log(__METHOD__ . ": dont know about CODE: {$mats['type']} of $stateName");
	            break;
	    }
	}

	public function deleteSuperCache($urlpath)
	{
	    if(isset(Yii::app()->params['runmode']) && Yii::app()->params['runmode'] == 'test')
	        return;

	    global $key;
	    global $cache_path,$cache_compression,$wp_cache_gzip_encoding;
	    global $wp_cache_request_uri,$blog_cache_dir,$cache_path;
	    $key = '';
	    require_once realpath(Yii::app()->basePath . '/../wp182650/wp-content/wp-cache-config.php');

	    if ($cache_compression) {
	        $wp_cache_gzip_encoding = gzip_accepted();
	    }
	    error_log(__METHOD__ . " - " . $urlpath . "," . var_export(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS),true));
	    $dir = get_current_url_supercache_dir();
	    $purgepath = untrailingslashit($dir) . $urlpath;
	    //wp_cache_debug( "prune_super_cache files " . $purgepath,1 );
	    prune_super_cache($purgepath,true);


	    $backup = $wp_cache_request_uri;
	    $blog_cache_dir = $cache_path;
	    $wp_cache_request_uri = $urlpath;
	    $data = wp_super_cache_init();
	    @unlink( $data['meta_pathname'] );
	    @unlink( $data['cache_file'] );
	    //wp_cache_debug( "deleting files " . $data['meta_pathname'] . "," . $data['cache_file'],1 );
	    $wp_cache_request_uri = $backup;
	}

	/**
	 * Will track all updating global states so that we can also cleanup
	 * the cache from super cache directory in real time.
	 *
	 * @param unknown $key
	 * @param unknown $value
	 * @param string $defaultValue
	 */
	public function setGlobalState($key,$value,$defaultValue=null)
	{
        Yii::app()->setGlobalState($key, $value,$defaultValue);
        $this->processDependency($key);
	}
}
