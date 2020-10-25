// Вспомогательная функция для добавления обработчика событий
function addEvent (el, event, callback) {
  if ('addEventListener' in el) {                  // Если addEventListener работает
    el.addEventListener(event, callback, false);   // Используем его
  } else {                                         // В противном случае
    el['e' + event + callback] = callback;         // Создаем специальный код для IE
    el[event + callback] = function () {
      el['e' + event + callback](window.event);
    };
    el.attachEvent('on' + event, el[event + callback]); // Используем attachEvent()
  }  // для вызова второй функции, которая потом вызывает первую
}

// Вспомогательная функция для удаления обработчика событий
function removeEvent(el, event, callback) {
  if ('removeEventListener' in el) {                      // If removeEventListener works
    el.removeEventListener(event, callback, false);       // Используем его 
  } else {                                                // В противном случае
    el.detachEvent('on' + event, el[event + callback]);   // Создаем специальный код для IE
    el[event + callback] = null;
    el['e' + event + callback] = null;
  }
}

// Функция для преобразования Unix timestamp в дату и время
function timestampToDate(unixtimestamp){

    // Convert timestamp to milliseconds
    var date = new Date(unixtimestamp*1000);

    // Year
    var year = date.getFullYear();

    // Month
    var month = ('0'+(date.getMonth()+1)).slice(-2); // Ставим 0 перед месяцем

    // Day
    var day = ('0'+(date.getDate())).slice(-2); // Ставим 0 перед днём

    // Hours
    var hours = date.getHours();

    // Minutes
    var minutes = "0" + date.getMinutes();

    // Seconds
    var seconds = "0" + date.getSeconds();

    // Display date time in yyyy-MM-dd h:m:s format
    var convdataTime = year+'-'+month+'-'+day+' ' +hours+ ':' + minutes.substr(-2) + ':' + seconds.substr(-2);

    return convdataTime;
}

