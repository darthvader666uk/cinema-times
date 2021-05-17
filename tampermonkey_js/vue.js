// ==UserScript==
// @name        Vue Calculate End Time
// @icon        https://www.myvue.com/assets/images/favicons/apple-touch-icon-57x57.png
// @author      snightingale
// @license     MIT
// @version     1.0
// @namespace   https://github.com/darthvader666uk
// @homepageURL https://github.com/darthvader666uk/cinema-times
// @supportURL  https://github.com/darthvader666uk/cinema-timesissues
// @downloadURL https://raw.githubusercontent.com/darthvader666uk/cinema-times/master/tampermonkey_js/vue.js
// @updateURL   https://raw.githubusercontent.com/darthvader666uk/cinema-times/master/tampermonkey_js/vue.js
// @description Trying to Calculate the end times of films to see when the film ends (assumes 30 Mins for Trailers)
// @match       *://www.myvue.com/cinema/*/whats-on
// @require     http://code.jquery.com/jquery-3.4.1.min.js
// @run-at      document-idle
// ==/UserScript==

var $ = window.jQuery;

$(document).ready(function(){
    $('div.filmlist__item').each(function() {

        console.log("Hello 1");

        // Get the Length of the film
        var filmLengthFind = $(this).find('div.filmlist__meta-container dd:first').text();

        console.log("filmLengthFind:"+filmLengthFind);

        // var filmLength = filmLengthFind.match(/\d+/);

        // // Make sure something is returnd
        // if (filmLength) {
        //     console.log("filmLength:"+filmLength);

        //     // Convert to Int
        //     var filmLengthInt = parseInt(filmLength); //Output will be 234.
    
        //     // Get each time
        //     $(this).find('.filmTimes a').each(function() {
        //         // Get the Length of the film
        //         var filmtimes = $(this).text();

        //         // Show correct time with add mins
        //         var newTime = addMinutes(filmtimes, filmLengthInt);
    
        //         $(this).text(filmtimes+" - "+newTime);
    
        //     });
        // }
    });
});

function addMinutes(time, minsToAdd) {
  function D(J){ return (J<10? '0':'') + J;};
  var piece = time.split(':');
  var mins = piece[0]*60 + +piece[1] + +minsToAdd + 30;

  return D(mins%(24*60)/60 | 0) + ':' + D(mins%60);
}