// ==UserScript==
// @name        Cineworld Calculate End Time
// @icon        https://www.cineworld.co.uk/xmedia/img/10108/fav.png
// @author      snightingale
// @license     MIT
// @version     1.0
// @namespace   https://github.com/darthvader666uk
// @homepageURL https://github.com/darthvader666uk/cinema-times
// @supportURL  https://github.com/darthvader666uk/cinema-timesissues
// @downloadURL https://raw.githubusercontent.com/darthvader666uk/cinema-times/master/tampermonkey_js/cineworld.js
// @updateURL   https://raw.githubusercontent.com/darthvader666uk/cinema-times/master/tampermonkey_js/cineworld.js
// @description Trying to Calculate the end times of films to see when the film ends (assumes 30 Mins for Trailers)
// @match       *://www.cineworld.co.uk/cinemas/*/*
// @require     http://code.jquery.com/jquery-3.4.1.min.js
// @run-at      document-idle
// ==/UserScript==

var $ = window.jQuery;

$(document).ready(function(){
    $("button").click(function(){
        location.reload(true);
    });

    $('div.movie-row').each(function() {
        // Get the Length of the film
        var filmLength = $(this).find('div.qb-movie-info span').text();


        // console.log("hello 1 "+filmLength);

        // Split the film length as it now shows genre
        filmarr = filmLength.split('|') 

        // console.log(filmarr[1]);

        // clean the time to make it an number
        filmLengthClean = filmarr[1].replace(' mins', '');

        // console.log(filmLengthClean);


        // Convert to Int
        var filmLengthInt = parseInt(filmLengthClean); //Output will be 234.

        // console.log(filmLengthInt);

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