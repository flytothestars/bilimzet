<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>Siple Web-Socket Client</title>
</head>
<body>
<script src="socket.js" type="text/javascript"></script>
<input id="sock-addr" type="hidden" value="ws://kcppk.kz:27800/"><br />
Message:
<input id="sock-msg" type="text">
<input id="sock-send-butt" type="button" value="send">
<input id="sock-recon-butt" type="button" value="reconnect"><input id="sock-disc-butt" type="button" value="disconnect">
Полученные сообщения от веб-сокета: 
<div id="sock-info" style="border: 1px solid"> </div>
</body>
</html>