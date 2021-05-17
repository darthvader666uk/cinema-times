// ==UserScript==
// @name        Gitlab Branch reference
// @icon        https://www.everymancinema.com/Themes/Theme_Everyman/Content/images/icons/favicon.png
// @author      snightingale
// @license     MIT
// @version     1.1
// @namespace   https://github.com/darthvader666uk
// @homepageURL https://github.com/darthvader666uk/cinema-times
// @supportURL  https://github.com/darthvader666uk/cinema-timesissues
// @downloadURL https://raw.githubusercontent.com/darthvader666uk/cinema-times/master/tampermonkey_js/gitlab_branch_reference.js
// @updateURL   https://raw.githubusercontent.com/darthvader666uk/cinema-times/master/tampermonkey_js/gitlab_branch_reference.js
// @description This now displays the branch reference on the issue sidebar underneath Reference for merge requests.
// @match       *://source.updraftplus.com/team-updraft/*/merge_requests/*
// @require     http://code.jquery.com/jquery-3.4.1.min.js
// @run-at      document-idle
// ==/UserScript==

var $ = window.jQuery;

$(document).ready(function () {
    var branch = $('.js-source-branch > a').clone();
    var branch_href = $(branch).attr('href');
    $(".issuable-context-form").append('<div class="block branch-reference"><div class="title hide-collapsed">Branch</div></div>');
    $(".branch-reference").append(branch);
    $('.branch-reference').append('<button class="btn btn-clipboard btn-transparent" data-toggle="tooltip" data-placement="left" data-container="body" data-title="Copy branch to clipboard" data-boundary="viewport" data-clipboard-text="https://source.updraftplus.com'+branch_href+'" type="button" title="" aria-label="Copy branch to clipboard" data-original-title="Copy branch to clipboard"><i aria-hidden="true" data-hidden="true" class="fa fa-clipboard"></i></button>');
});