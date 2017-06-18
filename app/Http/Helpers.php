<?php

function api_token() {
    return Auth::user()->api_token ?: null;
}