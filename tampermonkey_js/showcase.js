// ==UserScript==
// @name        Showcase Calculate End Time
// @icon        https://www.showcasecinemas.co.uk/images/favicon.ico
// @author      snightingale
// @license     MIT
// @version     1.0
// @namespace   https://github.com/darthvader666uk
// @homepageURL https://github.com/darthvader666uk/cinema-times
// @supportURL  https://github.com/darthvader666uk/cinema-timesissues
// @downloadURL https://raw.githubusercontent.com/darthvader666uk/cinema-times/master/tampermonkey_js/showcase.js
// @updateURL   https://raw.githubusercontent.com/darthvader666uk/cinema-times/master/tampermonkey_js/showcase.js
// @description Trying to Calculate the end times of films to see when the film ends (assumes 30 Mins for Trailers)
// @match       *://www.showcasecinemas.co.uk/showtimes/*
// @require     http://code.jquery.com/jquery-3.4.1.min.js
// @run-at      document-idle
// ==/UserScript==

var $ = window.jQuery;

$(document).ready(function(){

    // $("button").click(function(){
    //     location.reload(true);
    // });

    $('div.filmListItem').each(function() {

        console.log("Hello 1");

        // // Get the Length of the film
        // var filmLength = $(this).find('div.qb-movie-info span').text();

        // // Convert to Int
        // var filmLengthInt = parseInt(filmLength); //Output will be 234.

        // console.log("hello 1 "+filmLength);

        // // Get each time
        // $(this).find('div.qb-movie-info-column a').each(function() {
        //     // Get the Length of the film
        //     var filmtimes = $(this).text();

        //     // Show correct time with add mins
        //     var newTime = addMinutes(filmtimes, filmLengthInt);

        //     $(this).text(filmtimes+" - "+newTime);

        // });

    });
});

function addMinutes(time, minsToAdd) {
  function D(J){ return (J<10? '0':'') + J;};
  var piece = time.split(':');
  var mins = piece[0]*60 + +piece[1] + +minsToAdd + 30;

  return D(mins%(24*60)/60 | 0) + ':' + D(mins%60);
}