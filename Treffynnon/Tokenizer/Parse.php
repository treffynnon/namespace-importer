<?php

namespace Treffynnon\Tokenizer\Parse;

use \Functional as F;

function src($php_source) {
    return normalise_tokens(token_get_all($php_source));
}

function normalise_tokens($tokens) {
    return F\map($tokens, function($token){
        return get_token_array($token);
    });
}

function get_token_array($token) {
    return is_array($token) ?
           get_normalised_token_from_array($token) :
           get_normalised_token_from_string($token);
}

function get_normalised_token_from_array($token) {
    return array(
        'id'   => $token[0],
        'name' => token_name($token[0]),
        'text' => $token[1],
    );
}

function get_normalised_token_from_string($token) {
    return array(
        'id'   => TR_SIMPLE_STRING,
        'name' => 'TR_SIMPLE_STRING',
        'text' => $token,
    );
}
