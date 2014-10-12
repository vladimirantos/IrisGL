<?php

namespace Iris\Base;
use \Iris\Core;
/**
 * Základní styly písma
 */
class FontStyle extends Core\Enum{
    const Normal = 0x11;
    const Italic = 0x12;
    const Bold = 0x13;
    const BoldItalic = 0x14;
}

/**
 * Základní řezy písma
 */
class GenericFontFamily extends Core\Enum{
      const Serif = 0x21;
      const SansSerif = 0x22;
      const Monospace = 0x23;
}

/**
 * @author Vladimír Antoš
 * @version 1.0
 */
class Font {
    
}