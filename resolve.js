const http = require('https');
http.get('https://maps.app.goo.gl/VrDTohypqJf4KfRu9', (res) => {
    console.log("Status:", res.statusCode);
    console.log("Location:", res.headers.location);
}).on('error', (e) => {
    console.error(e);
});
