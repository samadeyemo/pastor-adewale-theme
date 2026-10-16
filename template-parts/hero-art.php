<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
$n = isset( $args['n'] ) ? (int) $args['n'] : 0;
$v = $n % 3;
if ( 0 === $v ) { ?>
<svg viewBox="0 0 420 320" width="78%" fill="none" aria-hidden="true"><rect x="60" y="70" width="140" height="190" rx="8" fill="#ffb547" fill-opacity=".18" stroke="#ffb547" stroke-width="2"/><rect x="220" y="70" width="140" height="190" rx="8" fill="#ffb547" fill-opacity=".10" stroke="#ffb547" stroke-width="2"/><path d="M85 110h90M85 135h90M85 160h70M245 110h90M245 135h90M245 160h70" stroke="#ffd38a" stroke-width="3" stroke-linecap="round"/><path d="M210 70v190" stroke="#ffb547" stroke-width="2"/><circle cx="210" cy="40" r="22" stroke="#ffd38a" stroke-width="2"/><path d="M210 28v24M198 40h24" stroke="#ffd38a" stroke-width="3" stroke-linecap="round"/></svg>
<?php }
if ( 1 === $v ) { ?>
<svg viewBox="0 0 420 320" width="78%" fill="none" aria-hidden="true"><rect x="90" y="190" width="240" height="40" rx="6" fill="#ffb547" fill-opacity=".25" stroke="#ffb547" stroke-width="2"/><rect x="110" y="145" width="210" height="40" rx="6" fill="#fff" fill-opacity=".12" stroke="#ffd38a" stroke-width="2"/><rect x="80" y="100" width="230" height="40" rx="6" fill="#ffb547" fill-opacity=".35" stroke="#ffb547" stroke-width="2"/><path d="M110 120h90M130 165h80M110 210h120" stroke="#ffe2b0" stroke-width="3" stroke-linecap="round"/><circle cx="330" cy="90" r="38" stroke="#ffd38a" stroke-opacity=".6" stroke-width="2"/></svg>
<?php }
if ( 2 === $v ) { ?>
<svg viewBox="0 0 420 320" width="70%" fill="none" aria-hidden="true"><rect x="120" y="130" width="180" height="130" rx="10" fill="#ffb547" fill-opacity=".2" stroke="#ffb547" stroke-width="2"/><rect x="105" y="105" width="210" height="36" rx="8" fill="#ffb547" fill-opacity=".38" stroke="#ffb547" stroke-width="2"/><path d="M210 105v155" stroke="#ffd38a" stroke-width="3"/><path d="M210 105c-10-36-52-36-52-14s34 14 52 14zM210 105c10-36 52-36 52-14s-34 14-52 14z" stroke="#ffd38a" stroke-width="3"/></svg>
<?php }
