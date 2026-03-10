<?php

if (! function_exists('format_inline')) {
    function format_inline($text)
    {
        if ($text === null || $text === '') {
            return '';
        }

        // 1. Escape first (critical for security)
        $text = e($text);

        /*
         |--------------------------------------------------------------------------
         | Discord-style formatting (order MATTERS)
         |--------------------------------------------------------------------------
         */

        // ***bold + italic***
        $text = preg_replace(
            '/\*\*\*(.*?)\*\*\*/s',
            '<strong><em>$1</em></strong>',
            $text
        );

        // __**underline + bold**__
        $text = preg_replace(
            '/__\*\*(.*?)\*\*__/s',
            '<u><strong>$1</strong></u>',
            $text
        );

        // **bold**
        $text = preg_replace(
            '/\*\*(.*?)\*\*/s',
            '<strong>$1</strong>',
            $text
        );

        // __underline__
        $text = preg_replace(
            '/__(.*?)__/s',
            '<u>$1</u>',
            $text
        );

        // *italic*
        $text = preg_replace(
            '/\*(.*?)\*/s',
            '<em>$1</em>',
            $text
        );

        // _italic_
        $text = preg_replace(
            '/_(.*?)_/s',
            '<em>$1</em>',
            $text
        );

        // ~~strikethrough~~
        $text = preg_replace(
            '/~~(.*?)~~/s',
            '<del>$1</del>',
            $text
        );

        // ||spoiler|| → highlight (PDF-safe)
        $text = preg_replace(
            '/\|\|(.*?)\|\|/s',
            '<span style="background:#e0e0e0; padding:2px 4px;">$1</span>',
            $text
        );

        // Line breaks
        return nl2br($text);
    }
}
