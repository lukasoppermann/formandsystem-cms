<?php namespace Formandsystem\Cache;

use Illuminate\Cache\CacheManager;

class LaravelCache implements CacheInterface {

  protected $cache;

  protected $tag;

  protected $minutes;

  public function __construct( CacheManager $cache, $tag, $minutes = 60 )
  {
    $this->cache = $cache;
    $this->tag = $tag;
    $this->minutes = $minutes;
  }

  public function get( $key )
  {
    return $this->cache->tags($this->tag)->get($key);
  }

  public function put( $key, $value, $minutes = null )
  {
    if( is_null($minutes) )
    {
      $minutes = $this->minutes;
    }

    return $this->cache->tags($this->tag)->put($key, $value, $minutes);
  }

  public function has( $key )
  {
    return $this->cache->tags($this->tag)->has($key);
  }

}
