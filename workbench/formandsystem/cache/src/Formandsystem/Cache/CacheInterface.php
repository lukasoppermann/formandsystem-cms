<?php namespace Formandsystem\Cache;

interface CacheInterface {


  /**
   * get
   *
   * @access	public
   * @param   string $key
   * @return  mixed
   */
   public function get($key);


  /**
   * put
   *
   * @access	public
   * @param   string $key
   * @param   mixed $value
   * @param   integer $minutes
   * @return  mixed
   */
   public function put($key, $value, $minutes = null);


    /**
     * has
     *
     * @access	public
     * @param   string $key
     * @return  bool
     */
     public function has($key);


}
