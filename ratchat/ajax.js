// ajax.js
// requires: ratax.js
if ( typeof(ratax) != 'function' ) {
	throw new Error('ratax.js is required');
}


function RatChat() {
	//var r = new Object();
	var xhr = new ratax();
	xhr.rpcuri = 'ratchat/ajax.php';
	var lastMsg = 0;
	var input = null;
	var output = null;
	var channel = 0;
	var pollFreq = 5;
	var pollInterval = null;
	var that = this;

	//alert('it works, ajax.js');

	// Establecer la frecuencia de actualización (en segundos)
	// Set refresh rate (in seconds)
	this.setFreq = function (seconds) { pollFreq = seconds; }
	// Obtiene la frecuencia de actualización (en segundos)
	// Get the refresh rate (in seconds)
	this.getFreq = function () { return pollFreq; }
	
	// Fijar un <INPUT> como campo de entrada
	// Set an <INPUT> as input field
	this.setInput = function (textfield) {
		input = textfield;
		var f = input.onkeypress;
		if ( typeof(f) != 'function' ) f=function () {};
		var c = this;
		input.onkeypress = function (e) {
			var key;
			if(window.event) key = window.event.keyCode;     //IE
			else key = e.which;     //firefox
			f();
			if(key == 13) { c.sendMsg(); return false; } else return true;
		}
	}
	
	// Enviar un mensaje (versión interna)
	// Send a message (internal version)
	this.sendMsg = function () {
		var msg = input.value;
		input.value='';
		if ( msg.match(/^\//) ) return this.command(msg);
		this.post(msg);
		this.pollMsg();
	}
	
	// Fijar un <DIV> para la salida
	// Set a <DIV> for output
	this.setOutput = function (div) {
		output = div;
	}
	
	// Establecer el nickname a utilizar
	// Set the nickname to use
	this.setNick = function (nick) { return xhr.call('setNick',{'nick':nick},null,false); }
	// Obtener el nickname actual
	// Get the current nickname
	this.getNick = function () { return xhr.call('getNick',null,null,false); }
	
	this.setChannel = function (chanid) { channel = chanid; }
	this.getChannel = function () { return channel; }
	
	// Enviar un mensaje al canal activo
	// Send a message to the active channel
	this.post = function (msg) { return xhr.call('post',{'chanid':channel,'msg':msg},null,false); }
	
	// Obtener los mensajes del canal activo
	// Get active channel messages
	this.get = function () {
		var m = xhr.call('get',{'chanid':channel,'lastmsg':lastMsg},null,false);
		if ( m.length>0 ) { lastMsg = m[0].lastmsg; }
		return m;
	}
	
	// Iniciar las peticiones periódicas (polling)
	// Start periodic requests (polling)
	this.startPolling = function () {
		this.pollMsg();
		pollInterval = setInterval(this.pollMsg, pollFreq*1000);
	}
	
	// Detener la petición periódica (polling)
	// Stop the periodic request (polling)
	this.stopPolling = function () { clearInterval(pollInterval); }
	
	// Polling de los mensajes del canal activo
  // Polling of active channel messages
	var pollingBusy = false;
	this.pollMsg = function () {
		if ( pollingBusy ) return;
		pollingBusy = true;
		var m = chat.get();
		for ( var i=0 ; i < m.length ; i++ ) {
			displayMsg(m[i]);
		}
		pollingBusy = false;
	}

	// Mostrar un mensaje
  // Display a message
	function displayMsg(m) {
		if ( m.userid.match(/^[[]/) ) { return displaySysMsg(m); }
		// Creamos algunos elementos
		// Create some elements
		var p = document.createElement('P');
		var ts = document.createElement('DIV');
		var name = document.createElement('DIV');
		var msg = document.createElement('DIV');

		// Clases CSS
		// CSS Classes
		ts.className = 'timestamp';
		name.className = 'username';
		msg.className = 'msg';
		
		// Contenido
		// Content
		ts.appendChild(document.createTextNode(m.time.replace(/^.*? ([0-9]{2}:[0-9]{2})...$/,'$1') ));
		name.title = 'Fecha/Hora: '+m.time;
		name.appendChild( document.createTextNode(m.userid) );
		msg.appendChild( document.createTextNode(m.msg) );
		
		// Inserción
		// Insertion
		p.appendChild(ts);
		p.appendChild(name);
		p.appendChild(msg);
		output.appendChild(p);

		// Scrolldown y limpieza
		// Scrolldown and cleaning
		output.scrollTop = output.scrollHeight;
		while ( output.childNodes.length > 100 ) {
			output.removeChild(output.childNodes[0]);
		}
	}
	
	function displaySysMsg(m) {
		// Creamos algunos elementos
		// Create some elements
		var p = document.createElement('P');
		var msg = document.createElement('SPAN');

		// Clases CSS
		// CSS Classes
		msg.className = 'sysmsg';
		
		// Contenido
		// Content
		msg.appendChild( document.createTextNode(m.msg) );
		
		// Inserción
		// Insertion
		p.appendChild(msg);
		output.appendChild(p);

		// Scrolldown y limpieza
		// Scrolldown and cleaning
		output.scrollTop = output.scrollHeight;
		while ( output.childNodes.length > 100 ) {
			output.removeChild(output.childNodes[0]);
		}
	}
	
	
	this.command = function (string) {
		var cmd = string.replace(/^\/([a-z]+).*$/,'$1');
		var m = {"time":"","userid":"","msg":""};
		switch (cmd) {
			case 'nick':
				var nick = string.replace(/^[^ ]+ (.*)$/,'$1');
				xhr.call('setNick',{'nick':nick},null,false);
				m.msg = 'Ahora eres conocido como '+xhr.call('getNick',null,null,false);
				break;
			case 'freq':
				var f = Number(string.replace(/^[^ ]+ (.*)$/,'$1'));
				if ( f > 0 ) {
					this.setFreq(f);
				}
				m.msg = 'Frecuencia actual: '+this.getFreq()+' s';
				break;
			case 'help':
				m.msg = 'Comandos permitidos';displaySysMsg(m);
				m.msg = '/help — este mensaje';displaySysMsg(m);
				m.msg = '/nick [nombre] — establece tu nombre ';displaySysMsg(m);
				m.msg = '/freq [segundos] — cada cuántos segundos se consulta el servidor';displaySysMsg(m);
				return;
				break;
			default:
			m.msg = '/help para obtener ayuda';
		}
		displaySysMsg(m);
	}

	return this;
}

var chat = new RatChat();

