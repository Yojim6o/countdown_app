
// snapshot of time remaining
function getTimeRemaining(endtime){

  var t = Date.parse(endtime) - Date.now();
  var seconds = Math.floor( (t/1000) % 60 );
  var minutes = Math.floor( (t/1000/60) % 60 );
  var hours = Math.floor( (t/(1000*60*60)) % 24 );
  var days = Math.floor( t/(1000*60*60*24) );
  
  return {
    'total': t,
    'days': days,
    'hours': hours,
    'minutes': minutes,
    'seconds': seconds
  };
};

// clockify time to update every 1000 ms
function initializeClock(title, endtime){

  var clock = document.getElementById(title);

  var daysSpan = clock.querySelector('.days');
  var hoursSpan = clock.querySelector('.hours');
  var minutesSpan = clock.querySelector('.minutes');
  var secondsSpan = clock.querySelector('.seconds');


  function updateClock(){
    var t = getTimeRemaining(endtime);

    daysSpan.innerHTML = t.days;
    hoursSpan.innerHTML = t.hours;
    minutesSpan.innerHTML = ('0' + t.minutes).slice(-2);
    secondsSpan.innerHTML = ('0' + t.seconds).slice(-2);

    if(t.total<=0){
      clearInterval(timeinterval);
    };
  }

  updateClock(); // run function once at first to avoid delay
  var timeinterval = setInterval(updateClock,1000);
};

function initializeScheduledCountdown(title, schedule) {
  // iterate over each element in the schedule
  for(var i=0; i<schedule.length; i++){
    var startDate = schedule[i]["start"];
    var endDate = schedule[i]["end"];

    // put dates in milliseconds for easy comparisons
    var startMs = Date.parse(startDate);
    var endMs = Date.parse(endDate);
    var currentMs = Date.now();

    // if current date is between start and end dates, display clock
    if(endMs > currentMs && currentMs >= startMs ){
      createClockDiv(title);
      initializeClock(title, endDate);
      break;
    };
  };
};

function createClockDiv(title) {
    document.write('<div id="' + title + '">' + title + '<br>'
    + 'Days: <span class="days"></span><br>'
    + 'Hours: <span class="hours"></span><br>'
    + 'Minutes: <span class="minutes"></span><br>'
    + 'Seconds: <span class="seconds"></span></div><hr>');
};