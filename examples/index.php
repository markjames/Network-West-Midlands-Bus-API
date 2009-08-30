<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>NetworkWmBuses</title>
	<meta name="description" content="" />
	<meta name="keywords" content="" />
	<meta name="author" content="" />
	<meta name="copyright" content="" />

	<link rel="Shortcut Icon" href="/favicon.ico" type="image/x-icon" />
	<link rel="alternate" type="application/rss+xml" title="News feed" href="/base/feed/"/>
	<meta name="robots" content="all" />
	<meta http-equiv="imagetoolbar" content="no" />

	<!-- Framework CSS -->
	<link rel="stylesheet" href="../../mmkit/base/screen.css" type="text/css" media="screen, projection, print" />
	<link rel="stylesheet" href="../../mmkit/base/print.css" type="text/css" media="print" />
	<!--[if IE]><link rel="stylesheet" href="../../mmkit/base/ie.css" type="text/css" media="screen, projection, print" /><![endif]-->
	
	
	<link rel="stylesheet" href="prettify/prettify.css" type="text/css" media="screen, projection, print" />
	<script src="prettify/prettify.js" type="text/javascript" charset="utf-8"></script>
	
	<style type="text/css">
		body { padding: 1em; }
		#skip-links { display: none; }
		a strong {color: red;}
	</style>

</head>
<body onload="prettyPrint()">
	<p id="skip-links"><a href="#content" title="Skip To Content">Skip To Content</a></p>
	<div id="wrapper" class="container">

		<!-- Site header -->
		<div id="header">
			<p id="logo"><h1>McGuyvered Bus Times API</h1></p>
		</div>

		<!-- Main content -->
		<div id="main">

<h2>Overview</h2>
<p>This library provides PHP programmatic access to the <a href="netwm.mobi">netwm.mobi</a> bus departure information. This is the result of an early-afternoon of hackery. You should not use the endpoint on this domain, and the code is sitting in a local repo which you lot can't get at.</p>

<h2>Services</h2>

<h3>Bus Stop Search</h3>

<p><a href="http://mark.james.name/buses/examples/endpoint.php?action=stop.search&amp;location=B1%202EP&amp;format=php">http://mark.james.name/buses/examples/endpoint.php?action=stop.search&amp;location=<strong>Postcode</strong>&amp;format=<strong>php|json</strong></a></p>

<p>Example JSON Response</p>

<pre class="prettyprint lang-javascript">[{
    &quot;name&quot;: &quot;Repertory Theatre (&gt;W)&quot;,
    &quot;departuresLink&quot;: &quot;http:\/\/www.netwm.mobi\/departureboard;jsessionid=ljcPX-BZXgvpb3tk.busmobile-p1?stopCode=43002153901&quot;,
    &quot;code&quot;: &quot;43002153901&quot;,
    &quot;location&quot;: &quot;on Cambridge St, International Convention Centre (&lt;500m)&quot;,
    &quot;latlng&quot;: {
        &quot;lat&quot;: 52.4794497,
        &quot;lng&quot;: -1.90811121
    }
},
{
    &quot;name&quot;: &quot;International Convention Centre (Opp)&quot;,
    &quot;departuresLink&quot;: &quot;http:\/\/www.netwm.mobi\/departureboard;jsessionid=ljcPX-BZXgvpb3tk.busmobile-p1?stopCode=43000215401&quot;,
    &quot;code&quot;: &quot;43000215401&quot;,
    &quot;location&quot;: &quot;on Cambridge St, International Convention Centre (&lt;500m)&quot;,
    &quot;latlng&quot;: {
        &quot;lat&quot;: 52.4792085,
        &quot;lng&quot;: -1.91012913
    }
},
{
    &quot;name&quot;: &quot;International Convention Centre (Stop JG)&quot;,
    &quot;departuresLink&quot;: &quot;http:\/\/www.netwm.mobi\/departureboard;jsessionid=ljcPX-BZXgvpb3tk.busmobile-p1?stopCode=43000215101&quot;,
    &quot;code&quot;: &quot;43000215101&quot;,
    &quot;location&quot;: &quot;on Broad St, International Convention Centre (&lt;500m)&quot;,
    &quot;latlng&quot;: {
        &quot;lat&quot;: 52.4784955,
        &quot;lng&quot;: -1.90652285
    }
},</pre>

<h3>Departures</h3>

<p><a href="http://mark.james.name/buses/examples/endpoint.php?action=stop.departures&amp;stopcode=43000530302&amp;format=php">http://mark.james.name/buses/examples/endpoint.php?action=stop.departures&amp;stopcode=<strong>numeric stop code</strong>&amp;format=<strong>php|json</strong></a></p>

<p>Example JSON Response</p>

<pre class="prettyprint lang-javascript">[{
    &quot;service&quot;: &quot;28A&quot;,
    &quot;operator&quot;: &quot;WNXB&quot;,
    &quot;stopCode&quot;: &quot;43000530302&quot;,
    &quot;destination&quot;: &quot;Alum Rock&quot;,
    &quot;departureTime&quot;: 1251559920
},
{
    &quot;service&quot;: &quot;51&quot;,
    &quot;operator&quot;: &quot;TWM&quot;,
    &quot;stopCode&quot;: &quot;43000530302&quot;,
    &quot;destination&quot;: &quot;Walsall&quot;,
    &quot;departureTime&quot;: 1251559932
},
{
    &quot;service&quot;: &quot;51&quot;,
    &quot;operator&quot;: &quot;TWM&quot;,
    &quot;stopCode&quot;: &quot;43000530302&quot;,
    &quot;destination&quot;: &quot;Walsall&quot;,
    &quot;departureTime&quot;: 1251560292
}]</pre>

		<!-- End of main -->
		</div>

		<!-- Footer -->
		<div id="footer" class="column">
			
		</div>

	</div>
</body>
</html>