let echo = require('laravel-echo-server');

echo.run(
    {
		"authHost": "http://localhost",
		"authEndpoint": "/broadcasting/auth",
		"clients": [
			{
				"appId": "753bdb32066edb84",
				"key": "188c63d11a9cc4161c40e835ef339aba"
			}
		],
		"database": "redis",
		"databaseConfig": {
			"redis": {},
			"sqlite": {
				"databasePath": "/database/laravel-echo-server.sqlite"
			}
		},
		"devMode": false,
		"host": null,
		"port": "6001",
		"protocol": "http",
		"socketio": {},
		"secureOptions": 67108864,
		"sslCertPath": "",
		"sslKeyPath": "",
		"sslCertChainPath": "",
		"sslPassphrase": "",
		"subscribers": {
			"http": true,
			"redis": true
		},
		"apiOriginAllow": {
			"allowCors": false,
			"allowOrigin": "",
			"allowMethods": "",
			"allowHeaders": ""
		}
	}
);
