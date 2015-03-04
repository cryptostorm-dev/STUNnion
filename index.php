<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
		<meta charset="UTF-8" />
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>STUNnion - better safe than ëëëëëëëëëëëëëëëk</title>
		<style type="text/css">
			@font-face {
				font-family:'vt323regular';
				src:url('fonts/VT323-Regular-webfont.eot');
				src:url('fonts/VT323-Regular-webfont.eot?#iefix') format('embedded-opentype'),
					url('fonts/VT323-Regular-webfont.woff2') format('woff2'),
					url('fonts/VT323-Regular-webfont.woff') format('woff'),
					url('fonts/VT323-Regular-webfont.ttf') format('truetype'),
					url('fonts/VT323-Regular-webfont.svg#vt323regular') format('svg');
				font-weight:normal;
				font-style:normal;
			}
			html {
				background-image:url('assets/bg.png');
			}
			body,html {
				font-family:'vt323regular';
				color:#3c3;
				margin:0;
				padding:16px 32px;
				text-shadow: 0 0 0.1em #3c3;
			}
			p {
				font-size:24px;
				opacity:0.7;
				margin:16px 0;
			}
			h1 {
				font-size:36px;
				font-style:italic;
				opacity:0.9;
				margin:16px 0;
			}
			h4 {
				font-size:28px;
				font-style:italic;
				opacity:0.9;
				margin:16px 0;
			}
			ul {
				font-size:28px;
				color:#c33;
				text-shadow: 0 0 0.2em #c33;
				opacity:0.7;
				margin:0;
			}
			hr {
				border-width:0;
				height:1px;
				border-bottom:1px solid #3c3;
				box-shadow: 0 0 0.2em #3c3;
				opacity:0.7;
				margin:32px 0;
				padding:0;
			}
		</style>
	</head>
	<body>
		<h1>STUNnion aka stunmbj4vvnuv5pr.onion</h1>
		<p>
			When you visit this site, an HTML5 webRTC request is made to a STUN server, asking your web browser to disclose your physical (ISP) address.
			They're tricksy things, + aren't bloked by the usual no-script or ghostery-style extensions. 
			There's some links below for more info, + tools to protect yourself whilst visiting .onions.
                        Cheers! ~ <a href = "https://stormgm7blbk7odd.onion/">cryptõstõrm</a>
		</p>
		<hr noshade />
		<h4>STUNion says your local (nonpublic) IP address is...</h4>
		<ul></ul>
		<h4>STUNion has reason to believe your public/ISP IP address is...</h4>
		<ul></ul>
		<iframe id="iframe" sandbox="allow-same-origin" style="display: none"></iframe>
		<script>
			//get the IP addresses associated with an account
			function getIPs(callback){
				var ip_dups = {};
				//compatibility for firefox and chrome
				var RTCPeerConnection = window.RTCPeerConnection
					|| window.mozRTCPeerConnection
					|| window.webkitRTCPeerConnection;
				var useWebKit = !!window.webkitRTCPeerConnection;
				//bypass naive webrtc blocking using an iframe
				if(!RTCPeerConnection){
					//NOTE: you need to have an iframe in the page right above the script tag
					//
					//<iframe id="iframe" sandbox="allow-same-origin" style="display: none"></iframe>
					//<script>...getIPs called in here...
					//
					var win = iframe.contentWindow;
					RTCPeerConnection = win.RTCPeerConnection
						|| win.mozRTCPeerConnection
						|| win.webkitRTCPeerConnection;
					useWebKit = !!win.webkitRTCPeerConnection;
				}
				//minimal requirements for data connection
				var mediaConstraints = {
					optional: [{RtpDataChannels: true}]
				};
				//firefox already has a default stun server in about:config
				//    media.peerconnection.default_iceservers =
				//    [{"url": "stun:stun.services.mozilla.com"}]
				var servers = undefined;
				//add same stun server for chrome
				if(useWebKit)
					servers = {iceServers: [{urls: "stun:stun.services.mozilla.com"}]};
				//construct a new RTCPeerConnection
				var pc = new RTCPeerConnection(servers, mediaConstraints);
				function handleCandidate(candidate){
					//match just the IP address
					var ip_regex = /([0-9]{1,3}(\.[0-9]{1,3}){3})/
					var ip_addr = ip_regex.exec(candidate)[1];
					//remove duplicates
					if(ip_dups[ip_addr] === undefined)
						callback(ip_addr);
					ip_dups[ip_addr] = true;
				}
				//listen for candidate events
				pc.onicecandidate = function(ice){
					//skip non-candidate events
					if(ice.candidate)
						handleCandidate(ice.candidate.candidate);
				};
				//create a bogus data channel
				pc.createDataChannel("");
				//create an offer sdp
				pc.createOffer(function(result){
					//trigger the stun server request
					pc.setLocalDescription(result, function(){}, function(){});
				}, function(){});
				//wait for a while to let everything done
				setTimeout(function(){
					//read candidate info from local description
					var lines = pc.localDescription.sdp.split('\n');
					lines.forEach(function(line){
						if(line.indexOf('a=candidate:') === 0)
							handleCandidate(line);
					});
				}, 1000);
			}
			//insert IP addresses into the page
			getIPs(function(ip){
				var li = document.createElement("li");
				li.textContent = ip;
				//local IPs
				if (ip.match(/^(192\.168\.|169\.254\.|10\.|172\.(1[6-9]|2\d|3[01]))/))
					document.getElementsByTagName("ul")[0].appendChild(li);
				//assume the rest are public IPs
				else
					document.getElementsByTagName("ul")[1].appendChild(li);
			});
		</script>
		<h4>Also this is your browser user-agent (check out EFF's Panopticlick site to learn more: panopticlick.eff.org):</h4>
		<ul><li id="UserAgent"></li></ul>
		<!-- <ul><li><?php echo $HTTP_USER_AGENT;?></li></ul> -->
		<hr noshade />
		<p>
		<p>STUNion is a fork of of Daniel Roesler's webrtc-ips project (github.com/diafygi/webrtc-ips); many thanks for the original work</p>
		<p>source code for STUNion is here: github.com/cryptostorm/STUNnion</p>
		<p>info on blocking STUN IP leaks is collected here: cryptostorm.org/webrtc</p>
		<p>we've implemented full STUNblock functionality at the torstorm.org gateway; details here: cryptostorm.org/torstorm</p>
		<p>additional resources & prior research on the topic collected & credited at: <a href = "http://cstorm5dzz7vgmvo.onion/viewtopic.php?f=64&t=8549">cstorm5dzz7vgmvo.onion/stunnion</a> (non-onion URL: cryptostorm.org/stunnion)</p>
		<p>folks using our deepDNS-based native .onion access from cryptostorm are generally STUN-protected; see: <a href = "http://cstorm5dzz7vgmvo.onion/viewtopic.php?f=47&t=8544">cstorm5dzz7vgmvo.onion/widget</a> (non-onion URL: cryptostorm.org/widget)</p>
		<p>thanks again to the Tor Project team for ensuring anyone using Tor Browser Bundle is STUNnion-free for life!</p>
		<p>and umm... <a href = "http://5deqglhxcoy3gbx6.onion/">kittens</a>? (=^ェ^=)</p>
		<p></p>
		<script type="text/javascript" src="js/jquery.min.js"></script>
		<script type="text/javascript">$('#UserAgent').html(navigator.userAgent);</script>
	</body>
</html>
