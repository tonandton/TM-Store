<?php

namespace App;

enum ProductVariationTypeEnum: string
{
       case Select = 'Select';
       case Checkbox = 'Radio';
       case Image = 'Image';

       public static function labels(): array
       {
              return [
                     self::Select->value => __('Select'),
                     self::Checkbox->value => __('Checkbox'),
                     self::Image->value => __('Image'),
              ];
       }
}
