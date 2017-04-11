class Api {
  constructor(api_uri) {
    init(api_uri);
  }

  static init(api_uri) {
    Api.api_uri = api_uri || 'api.php';
  }

  static request(params, callback, method) { //request via post or get the api data
    method = method || "post"; //default method is post

    //var json = JSON.stringify(params);
    var json = Api.urlEncodeObject(params);

    var xhr = new XMLHttpRequest();

    xhr.open("POST", this.api_uri, true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            callback(xhr.responseText);
        }
    }

    xhr.send(json);
  }

  static urlEncodeObject(data) {
    const params = Object.keys(data).map(key => data[key] ? `${encodeURIComponent(key)}=${encodeURIComponent(data[key])}` : '');
    return params.filter(value => !!value).join('&');
  }
}
