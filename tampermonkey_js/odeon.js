// ==UserScript==
// @name        Odeon Calculate End Time
// @icon        https://www.odeon.co.uk/images/favicon.png
// @author      snightingale
// @license     MIT
// @version     1.0
// @namespace   https://github.com/darthvader666uk
// @homepageURL https://github.com/darthvader666uk/cinema-times
// @supportURL  https://github.com/darthvader666uk/cinema-timesissues
// @downloadURL https://raw.githubusercontent.com/darthvader666uk/cinema-times/master/tampermonkey_js/odeon.js
// @updateURL   https://raw.githubusercontent.com/darthvader666uk/cinema-times/master/tampermonkey_js/odeon.js
// @description Trying to Calculate the end times of films to see when the film ends (assumes 30 Mins for Trailers)
// @match       *://www.odeon.co.uk/cinemas/*
// @require     http://code.jquery.com/jquery-3.4.1.min.js
// @run-at      document-idle
// ==/UserScript==

var $ = window.jQuery;

$(document).ready(function(){
    filmUpdate(1); // Day 1
    filmUpdate(2); // Day 2
    filmUpdate(3); // Day 3
    filmUpdate(4); // Day 4
    filmUpdate(5); // Day 5
    filmUpdate(6); // Day 6
    filmUpdate(7); // Day 7
    filmUpdate(8); // Day 8
    filmUpdate(9); // Day 9
    filmUpdate(10); // Day 10
});

function filmUpdate(day){
    $('div.film-detail.DAY'+day).each(function() {
        var filmID= $(this).attr('id');
        // Convert to Int
        var filmIDInt = parseInt(filmID); //Output will be 234.

        // Get the Length of the film
        var getFilmLength = cleanFilmLength($('#film-'+filmIDInt+' .grad-hor .presentation-info span.description').text());

        // Get each time
        $('#performances-DAY'+day+'-'+filmIDInt+' a').each(function() {

            // Get the Length of the film
            var filmtimes = $(this).text();

            if (filmtimes) {
                // Show correct time with add mins
                var newTime = addMinutes(filmtimes, getFilmLength);

                $(this).text(filmtimes+" - "+newTime);
            }
        });
    });
}

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