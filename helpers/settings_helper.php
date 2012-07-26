<?php

namespace Portal
{
  class SettingsHelper
  {
    public static function activation_option_to_text( $code )
    {
      switch ( $code ) {
        case 'a':
          return 'No';
        case 'b':
          return 'Yes';
        #case 'c':
        #  return 'Yes, but invitation only';
      }
    }

    public static function activation_option_to_code( $text )
    {
      switch ( $code ) {
        case 'No':
          return 'a';
        case 'Yes':
          return 'b';
        #case 'Yes, but invitation only':
        #  return 'c';
      }
    }
  }
}