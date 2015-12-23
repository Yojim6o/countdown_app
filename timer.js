function init(e){
    // var j = Number(window.location.href.split('?')[1]);
    //var j = '241';
    var countdowns = e;
    var index = countdowns[j];
    var title = index["title"];
    var deadline = index["deadline"];
    var schedule = index["schedule"];
    if (getTimeRemaining(deadline)['days'] < 0) {
      createExpiredClock(title, index['message']);
    } else if (deadline) {
      createClockDiv(title);
      initializeClock(title, deadline);
    } else if (schedule) {
      initializeScheduledCountdown(title, schedule);
    }
}


var js = document.createElement("script");

js.type = "text/javascript";
js.src = 'js/functions.js';

document.getElementById("script_cont").appendChild(js);  

var css = document.createElement("style");

css.type = "stylesheet";
css.href = './css/style.css';

document.getElementById("script_cont").appendChild(css);  



var xmlhttp = new XMLHttpRequest();
var url = "manager/js/results.json";

xmlhttp.onreadystatechange = function() {
    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
        var myArr = JSON.parse(xmlhttp.responseText);
        init(myArr);
    }
};
xmlhttp.open("GET", url, true);
xmlhttp.send();