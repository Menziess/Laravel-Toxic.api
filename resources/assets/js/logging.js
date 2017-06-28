/**
 * Error logging.
 */
window.onerror = function (msg, url, line, column, error) {
    const string = msg.toLowerCase();
    const substring = "script error";
    if (string.indexOf(substring) > -1){
        console.log('Script Error: See Browser Console for Detail');
    } else {
      const message = {
          'message': msg,
          'url': url,
          'line': line,
          'column': column,
          'error': error
      };
      const request = {
        method: 'post',
        url: '/api/log',
        data: message
      };

      axios(request).then(response => {
        console.log(response);
      }).error(error => {
        console.error(error);
      }).catch(exception => {
        console.log(exception);
      });
    }

    return false;
};