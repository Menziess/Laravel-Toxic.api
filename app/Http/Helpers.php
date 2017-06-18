<?php

function api_token() {
    return Auth::user() ? Auth::user()->api_token : null;
}