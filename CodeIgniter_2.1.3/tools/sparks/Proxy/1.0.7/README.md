# CodeIgniter Proxy Library

You could also include it manually, put Proxy.php under './application/libraries/'

## Features :
- Support all HTTP method (GET, POST, PUT, DELETE) [NEW].
- Support custom HTTP header, and basic HTTP Authorization [NEW].
- Get Full HTTP Header.
- Get Full HTTP Response (Content).
- Get Crawled web content.
- Google Geocoding Functionality [NEW].
- Maintained css path, js path, image, anchor tag and form at rendered option.
- Set Proxy Call support.
- Set Delay HTTP Call support.
- Set User Agent (Browser Identity)  support.
- Internal cache (using gzip).
- Persistent Call (processing redirect, either from header or meta)
- NO NEED FANCY CURL STUFF DEPEDENCIES! PURE PHP.
- Cookie support.
- Log and error flag.

## Usage

Simple way to use this library. In any controller, put this line...

```php
$this->load->library('proxy');
$this->proxy->site('http://codeigniter.com',TRUE);
```

Above example will give you rendered page of CodeIgniter site, if you didn't want to render it directly, or it was a json which you want to save to var, simply do this...

```php
$this->load->library('proxy');
//$ip = your ip variable ex: '202.134.0.15'
$json_var = $this->proxy->site('http://ip2country.sourceforge.net/ip2c.php?ip='.$ip.'&format=JSON');
```

Get crawled page of CodeIgniter Forums...

```php
$this->load->library('proxy');
$this->proxy->crawl('codeigniter.com/forums',TRUE);
```

Get Geocoding Responses from Google Maps Service (http://code.google.com/intl/id-ID/apis/maps/documentation/geocoding/)...

```php
$this->load->library('proxy');
// Generate json response by address
$this->proxy->geocode('1600 Amphitheatre Parkway, Mountain View, CA');
// Generate json response by latlng
$this->proxy->geocode(array('40.714224','-73.961452'));
// Generate xml response by latlng and set sensor to TRUE
$this->proxy->geocode(array(40.714224,-73.961452),'XML',TRUE);
```

To call your rendered controller (maybe in some situation, you need it instead use redirect() function)

```php
$this->load->library('proxy');
$this->proxy->controller('your_target_controller_name/target_function/some_id', TRUE);
```

Set proxy call

```php
$this->load->library('proxy');
$this->proxy->set_proxy('proxy_host',80,'username','password');
$this->proxy->site('twitter.com',TRUE);
```

Get HTTP header

```php
$this->load->library('proxy');
// get rendered HTTP header of CodeIgniter site
$this->proxy->head('codeigniter.com',TRUE);
// for use it as variable, put FALSE on second passed param or simple let it blank
$site_httpheader = $this->proxy->head('codeigniter.com');
```

Set delay call and user agent (browser identity).

```php
$this->load->library('proxy');
$this->proxy->site('http://codeigniter.com',TRUE);
// set user agent and delay
$this->proxy->set_delay(5);
$this->proxy->set_useragent($this->session->userdata('user_agent'));
$this->proxy->site('twitter.com',TRUE); 
```

HTTP (GET, POST, PUT, DELETE), REST and HTTP Authentfication.

```php
$this->load->library('proxy');
// An easy example performing basic 'POST' and get the result rendered. 
echo $this->proxy->http('POST', 'http://somesite.com/login.php', array('username' => 'username', 'password' => 'password'));
// Perform an API Call
// An example of GET
$username = 'taufanaditya';
$tweets = $this->proxy->http('GET', 'http://twitter.com/statuses/user_timeline/'.$username.'.json');
// Perform a Rest Client Call, without cURL.
// An example of POST, with Basic HTTP Authentification
echo $this->proxy->http('POST', 'api.yourdomain.com/api/users', array('id' => 10, 'name' => 'Changed via Proxy'), array('auth' => 'username:password'));
// An example of PUT, with custom HTTP header (like API Key, or anything else)
$new_user = array(
	'name'             => 'John Doe',
	'username'         => 'johndoe',
	'email'            => 'johndoe@otherworlds.com',
	'password'         => 'secret',
	'confirm_password' => 'secret',
);
echo $this->proxy->http('PUT','api.yourdomain.com/api/users', $new_user, array('X-API-KEY' => 'fooandbarnotencrypted'));
```