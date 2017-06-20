require('dotenv').config();

const env = process.env;
const EchoServer = require('laravel-echo-server');

const options = {
    "authHost": env.APP_URL,
    "authEndpoint": "/broadcasting/auth",
    "database": "redis",
    "databaseConfig": {
        "redis": {}
    },
    "devMode": env.APP_DEBUG,
    "host": null,
    "port": "6001",
    "protocol": (env.SSL_CERT && env.SSL_KEY) ? "https" : "http",
    "socketio": {},
    "sslCertPath": env.SSL_CERT ? env.SSL_CERT : "",
    "sslKeyPath": env.SSL_KEY ? env.SSL_KEY : ""
};

EchoServer.run(options);
