<?php
class Helper
{
  const STATUS_ACTIVE = 1;
  const STATUS_DISABLED = 0;
  const STATUS_ACTIVE_TEXT = 'Active';
  const STATUS_DISABLED_TEXT = 'Disabled';
  const STATUS_INACTIVE_TEXT_ORDER = "<span style='padding:4px;color:#fff;background: red;width:65px;display:inline-block;
border-radius:5px;text-align:center'>Đang chờ</span>";
  const STATUS_ACTIVE_TEXT_ORDER = "<span style='padding:4px;color:#fff;background: green;width:65px;display:inline-block;
border-radius:5px;text-align: center'>Đã xong</span>";

  /**
   * Get status text
   * @param int $status
   * @return string
   */
  public static function getStatusText($status = 0) {
    $status_text = '';
    switch ($status) {
      case self::STATUS_ACTIVE:
        $status_text = self::STATUS_ACTIVE_TEXT;
        break;
      case self::STATUS_DISABLED:
        $status_text = self::STATUS_DISABLED_TEXT;
        break;
    }
    return $status_text;
  }
    public static function getStatusTextOrder($status)
    {
        $status_text = '';
        switch ($status) {
            case self::STATUS_DISABLED:
                $status_text = self::STATUS_INACTIVE_TEXT_ORDER;
                break;
            case self::STATUS_ACTIVE:
                $status_text = self::STATUS_ACTIVE_TEXT_ORDER;
                break;
        }

        return $status_text;
    }
  public static function getSlug($str) {
    $str = trim(mb_strtolower($str));
    $str = preg_replace('/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/', 'a', $str);
    $str = preg_replace('/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/', 'e', $str);
    $str = preg_replace('/(ì|í|ị|ỉ|ĩ)/', 'i', $str);
    $str = preg_replace('/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/', 'o', $str);
    $str = preg_replace('/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/', 'u', $str);
    $str = preg_replace('/(ỳ|ý|ỵ|ỷ|ỹ)/', 'y', $str);
    $str = preg_replace('/(đ)/', 'd', $str);
    $str = preg_replace('/[^a-z0-9-\s]/', '', $str);
    $str = preg_replace('/([\s]+)/', '-', $str);
    return $str;
  }

}