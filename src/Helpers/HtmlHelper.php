<?php

namespace Bulbakh\Telenorma\Helpers;

class HtmlHelper
{
    private static function tag(string $tag, string $var = '', array $attr = [], array $css = []): string
    {
        $res = '<' . $tag . ' ';
        if ($attr) {
            foreach ($attr as $key => $value) {
                $res .= $key . '="' . $value . '" ';
            }
        }

        $res .= ' style="';
        if ($css) {
            foreach ($css as $key => $value) {
                $res .= $key . ':' . $value . '; ';
            }
        }
        return $res . '">' . $var . '</' . $tag . '>';
    }

    public static function table(string $var, array $attr = [], $css = []): string
    {
        return self::tag('table', $var, $attr, $css);
    }

    public static function tr($var, $attr = [], $css = []): string
    {
        return self::tag('tr', $var, $attr, $css);
    }

    public static function td($var, array $attr = [], array $css = []): string
    {
        return self::tag('td', $var, $attr, $css);
    }

    public static function a(string $var, array $attr, array $css = []): string
    {
        return self::tag('a', $var, $attr, $css);
    }

    public static function div(string $var, array $attr, array $css = []): string
    {
        return self::tag('div', $var, $attr, $css);
    }

    public static function img(array $attr, array $css = []): string
    {
        return self::tag('img', '', $attr, $css);
    }

    public static function i(array $attr, array $css = []): string
    {
        return self::tag('i', '', $attr, $css);
    }

    public static function span(string $var, array $attr, array $css = []): string
    {
        return self::tag('span', $var, $attr, $css);
    }

    public static function br(int $count = 1): string
    {
        $res = '';
        for ($i = 1; $i <= $count; $i++) {
            $res .= self::tag('br');
        }
        return $res;
    }

    public static function script(string $script): string
    {
        return self::tag('script', '', ['src' => $script]);
    }

    public static function head(string $var): string
    {
        return self::tag('head', $var);
    }

    public static function form(string $var, array $attr): string
    {
        return self::tag('form', $var, $attr);
    }

    public static function input(string $label, array $attr): string
    {
        return $label . ' ' . self::tag('input', '', $attr);
    }

    public static function select(string $label, array $options, array $attr): string
    {
        $list = '';
        foreach ($options as $key => $option) {
            $list .= self::tag('option', $option, ['value' => $key]);
        }
        return $label . ' ' . self::tag('select', $list, $attr);
    }

    public static function submit(string $label, array $attr = []): string
    {
        $attr['type'] = 'submit';
        $attr['value'] = $label;
        return self::input('', $attr);
    }

    public static function link(string $href, array $attr): string
    {
        $attr['href'] = $href;
        return self::tag('link', '', $attr);
    }

    public static function css(string $href): string
    {
        return self::link($href, ['rel' => "stylesheet"]);
    }

    public static function button(string $label, array $attr = []): string
    {
        $attr['type'] = 'button';
        $attr['value'] = $label;
        return self::input('', $attr);
    }
}
