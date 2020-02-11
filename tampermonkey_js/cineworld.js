// ==UserScript==
// @name         Cineworld Calculate End Time
// @version      0.1
// @description  Trying to Calculate the end times of films to see when the film ends
// @author       snightingale
// @match        *://www.cineworld.co.uk/cinemas/*/*
// @require      http://code.jquery.com/jquery-3.4.1.min.js
// @run-at       document-idle
// ==/UserScript==

var $ = window.jQuery;

$(document).ready(function(){
    $("button").click(function(){
        location.reload(true);
    });

    $('div.movie-row').each(function() {
        // Get the Length of the film
        var filmLength = $(this).find('div.qb-movie-info span').text();

        // Convert to Int
        var filmLengthInt = parseInt(filmLength); //Output will be 234.

        console.log("hello 1 "+filmLength);

        // Get each time
        $(this).find('div.qb-movie-info-column a').each(function() {
            // Get the Length of the film
            var filmtimes = $(this).text();

            // Show correct time with add mins
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