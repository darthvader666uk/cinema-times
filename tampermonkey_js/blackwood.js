// ==UserScript==
// @name        Blackwood Maxime Cinema Calculate End Time
// @icon        https://www.blackwoodcinema.co.uk/images/PDBLACK.png
// @author      snightingale
// @license     MIT
// @version     1.0
// @namespace   https://github.com/darthvader666uk
// @homepageURL https://github.com/darthvader666uk/cinema-times
// @supportURL  https://github.com/darthvader666uk/cinema-timesissues
// @downloadURL https://raw.githubusercontent.com/darthvader666uk/cinema-times/master/tampermonkey_js/blackwood.js
// @updateURL   https://raw.githubusercontent.com/darthvader666uk/cinema-times/master/tampermonkey_js/blackwood.js
// @description Trying to Calculate the end times of films to see when the film ends (assumes 30 Mins for Trailers)
// @match       *://www.blackwoodcinema.co.uk/*
// @require     http://code.jquery.com/jquery-3.4.1.min.js
// @run-at      document-idle
// ==/UserScript==

var $ = window.jQuery;

$(document).ready(function(){
    $('div.PD_performance').each(function() {

        // Get the Length of the film
        var filmLength = cleanFilmLength($(this).find('div.ratingText p').text());

        // Convert to Int
        var filmLengthInt = parseInt(filmLength); //Output will be 234.

        // Get each time
        $(this).find('div.PD_dateperformances a').each(function() {

            // // Get the Length of the film
            var filmtimes = cleanFilmTime($(this).text());

            // // Show correct time with add mins
            var newTime = addMinutes(filmtimes, filmLengthInt);

            $(this).text(filmtimes+" - "+newTime);

        });
    });
});

function addMinutes(time, minsToAdd) {
    function D(J){ return (J<10? '0':'') + J;};
    var piece = time.split(':');
    var mins = piece[0]*60 + +piece[1] + +minsToAdd + 30;

    return D(mins%(24*60)/60 | 0) + ':' + D(mins%60);
}

function cleanFilmLength(filmLength) {
    var popFilmLength = filmLength.split(":").pop();
    var trimFilmLength = $.trim(popFilmLength)
    var strReplaceFilmLength = trimFilmLength.replace(" mins", "");

    // COnvert to Int
    return parseInt(strReplaceFilmLength); //Output will be 234.
}

function cleanFilmTime(filmtimes) {
    return filmtimes.replace(" Subtitled", "");
}