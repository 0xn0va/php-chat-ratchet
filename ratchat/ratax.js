/*
	ratax.js
	
	Esta sencilla clase sirve para trabajar con JSON asíncrono.
*/

function ratax() {
	this.className = 'ratax';
	this.version = 'Ratax 0.1a';
	this.rpcuri = '';
	this.rpcid = 0;
	
	// Correctly escape strings for JSON
	this.escaper = function(data) {
		data = data.replace(/(["\/])/,'\$1');
		data = data.replace(/\f/,'\\f');
		data = data.replace(/\n/,'\\n');
		data = data.replace(/\r/,'\\r');
		data = data.replace(/\t/,'\\t');
		return data;
	}
	
	
	// Serialize an object into JSON
	this.serializer = function(data) {
		if ( data == null ) { return 'null'; }
		if ( typeof(data) == 'object' || typeof(data) == 'array' ) {
			var ret = '';
			for (var i in data) {
				ret += (ret=='')?'':',';
				ret += this.serializer(i)+':'+this.serializer(data[i]);
			}
			return '{'+ret+'}';
		}
		
		if ( typeof(data) == 'number' ) { return data; }
		if ( typeof(data) == 'string' ) { return '"'+this.escaper(data)+'"'; }
		
		throw new Error('Unhandled data type: '+typeof(data));
	}
	
	// JSON-RPC call
	this.call = function (method, args, callback, sync) {
		var call = new Object();
		call.method = method;
		call.params = args;
		call.id = ++this.rpcid;
		var callData = this.serializer(call);
		
		// If no sync-mode specified, assume it's async/non-blocking
		if ( sync != false ) { sync = true; }
		
		var xml = new XMLHttpRequest();
		xml.ratax = this;
		xml.callback = callback;
		if ( sync ) { xml.onreadystatechange = this.handler; }
		xml.open('POST',this.rpcuri,sync);
		xml.setRequestHeader('Content-type', 'application/json');
		xml.setRequestHeader('Content-length', callData.length);
		xml.setRequestHeader('Connection', 'close');
		xml.send(callData);
		
		if ( !sync )
		return this.process(xml.responseText);
	}

	// This is the actual processing of the response
	this.process = function(response) {
		// Error handling
		try { var data = eval('('+response+')'); }
		catch (e) { throw new Error('Bad response\n'+response); }
		if ( data == null ) { throw new Error('Null data received'); }

		// If response is error, throw it
		if ( data.error != null ) { throw new Error(data.error); }

		// If we actually have a method call, validate and call it
		if ( typeof(data.method) != 'undefined' ) {
			if ( eval('typeof '+data.method) == 'function' ) {
				eval(data.method)(data.params);
			}
		}
		
		// If a handler is set, cascade to it
		if ( typeof(this.callback) == 'function' ) { this.callback(data); }
		
		// If in sync mode, we will return the actual result
		return data.result;
	}

	
	// Asynchronous XHR handler
	this.handler = function () {
		if (this.readyState==4) {// 4 = "loaded"
			
			if (this.status==200)
			{// 200 = OK
				return this.ratax.process(this.responseText);
			}
			else
			{
				throw new Error('Error '+this.status+' when reading '+this);
			}
		}
	}
	
}