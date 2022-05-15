<?php

namespace model;

use Error;

abstract class AbstractModel
{
  protected static $_SESSION_NAME = null;
  //set
  public static function setSession($val)
  {
    if (empty(static::$_SESSION_NAME)) {
      throw new Error('$_SESSION_NAMEを設定して下さい。');
    }
    $_SESSION[static::$_SESSION_NAME] = $val;
  }
  //get
  public static function getSession()
  {
    return $_SESSION[static::$_SESSION_NAME] ?? null;
  }
  public static function clearSession()
  {
    static::setSession(null);
  }
  public static function getSessionAndFlush()
  {
    try {
      return static::getSession();
    } finally {
      static::clearSession();
    }
  }
}
