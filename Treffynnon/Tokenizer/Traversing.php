<?php

namespace Treffynnon\Tokenizer\Traversing;

use \Functional as F,
    \Treffynnon\Tokenizer\Parse as P,
    \React\Curry;

function get_token($tokens, $token_index) {
    return array_key_exists($token_index, $tokens) ?
           $tokens[$token_index] :
           null;
}

function get_tokens($tokens, $token_to_start, $tokens_to_end) {
    $return = array();
    $fetch_string = Curry\bind('\\' . __NAMESPACE__ . '\\fetch_tokens_until', $tokens, Curry\…(), $tokens_to_end);
    F\each($tokens, function($token, $index) use ($fetch_string, $token_to_start, &$return) {
        if($token_to_start == $token['id']) {
            $return[] = trim($fetch_string($index));
        }
    });
    return $return;
}

function fetch_tokens_until($tokens, $initial_index, $tokens_to_end, $state = '') {
    $token = get_token($tokens, ++$initial_index);
    if(is_null($token) or
       in_array($token['id'], $tokens_to_end) or
       in_array($token['text'], $tokens_to_end)) {
        return $state;
    }
    return fetch_tokens_until($tokens, $initial_index, $tokens_to_end, $state . $token['text']);
}

function get_use_tokens($tokens) {
    return get_tokens($tokens, T_USE, array(T_AS, ';', '('));
} 