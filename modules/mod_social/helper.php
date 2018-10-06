<?php
/**
* @package		JJ Module Generator
* @author		JoomJunk
* @copyright	Copyright (C) 2011 - 2012 JoomJunk. All Rights Reserved
* @license		http://www.gnu.org/licenses/gpl-3.0.html
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

?>

<?php 
class Instagram {

  /**
   * The API base URL
   */
  const API_URL = 'https://api.instagram.com/v1/';

  /**
   * The API OAuth URL
   */
  const API_OAUTH_URL = 'https://api.instagram.com/oauth/authorize';

  /**
   * The OAuth token URL
   */
  const API_OAUTH_TOKEN_URL = 'https://api.instagram.com/oauth/access_token';

  /**
   * The Instagram API Key
   * 
   * @var string
   */
  private $_apikey;

  /**
   * The Instagram OAuth API secret
   * 
   * @var string
   */
  private $_apisecret;

  /**
   * The callback URL
   * 
   * @var string
   */
  private $_callbackurl;

  /**
   * The user access token
   * 
   * @var string
   */
  private $_accesstoken;

  /**
   * Available scopes
   * 
   * @var array
   */
  private $_scopes = array('basic', 'likes', 'comments', 'relationships');

  /**
   * Available actions
   * 
   * @var array
   */
  private $_actions = array('follow', 'unfollow', 'block', 'unblock', 'approve', 'deny');

  /**
   * Default constructor
   *
   * @param array|string $config          Instagram configuration data
   * @return void
   */
  public function __construct($config) {
    if (true === is_array($config)) {
      // if you want to access user data
      $this->setApiKey($config['apiKey']);
      $this->setApiSecret($config['apiSecret']);
      $this->setApiCallback($config['apiCallback']);
    } else if (true === is_string($config)) {
      // if you only want to access public data
      $this->setApiKey($config);
    } else {
      //throw new Exception("Error: __construct() - Configuration data is missing.");
    }
  }

  /**
   * Generates the OAuth login URL
   *
   * @param array [optional] $scope       Requesting additional permissions
   * @return string                       Instagram OAuth login URL
   */
  public function getLoginUrl($scope = array('basic')) {
    if (is_array($scope) && count(array_intersect($scope, $this->_scopes)) === count($scope)) {
      return self::API_OAUTH_URL . '?client_id=' . $this->getApiKey() . '&redirect_uri=' . urlencode($this->getApiCallback()) . '&scope=' . implode('+', $scope) . '&response_type=code';
    } else {
      //throw new Exception("Error: getLoginUrl() - The parameter isn't an array or invalid scope permissions used.");
    }
  }

  /**
   * Search for a user
   *
   * @param string $name                  Instagram username
   * @param integer [optional] $limit     Limit of returned results
   * @return mixed
   */
  public function searchUser($name, $limit = 0) {
    return $this->_makeCall('users/search', false, array('q' => $name, 'count' => $limit));
  }

  /**
   * Get user info
   *
   * @param integer [optional] $id        Instagram user ID
   * @return mixed
   */
  public function getUser($id = 0) {
    $auth = false;
    if ($id === 0 && isset($this->_accesstoken)) { $id = 'self'; $auth = true; }
    return $this->_makeCall('users/' . $id, $auth);
  }

  /**
   * Get user activity feed
   *
   * @param integer [optional] $limit     Limit of returned results
   * @return mixed
   */
  public function getUserFeed($limit = 0) {
    return $this->_makeCall('users/self/feed', true, array('count' => $limit));
  }

  /**
   * Get user recent media
   *
   * @param integer [optional] $id        Instagram user ID
   * @param integer [optional] $limit     Limit of returned results
   * @return mixed
   */
  public function getUserMedia($id = 'self', $limit = 0) {
    return $this->_makeCall('users/' . $id . '/media/recent', ($id === 'self'), array('count' => $limit));
  }

  /**
   * Get the liked photos of a user
   *
   * @param integer [optional] $limit     Limit of returned results
   * @return mixed
   */
  public function getUserLikes($limit = 0) {
    return $this->_makeCall('users/self/media/liked', true, array('count' => $limit));
  }

  /**
   * Get the list of users this user follows
   *
   * @param integer [optional] $id        Instagram user ID
   * @param integer [optional] $limit     Limit of returned results
   * @return mixed
   */
  public function getUserFollows($id = 'self', $limit = 0) {
    return $this->_makeCall('users/' . $id . '/follows', true, array('count' => $limit));
  }

  /**
   * Get the list of users this user is followed by
   *
   * @param integer [optional] $id        Instagram user ID
   * @param integer [optional] $limit     Limit of returned results
   * @return mixed
   */
  public function getUserFollower($id = 'self', $limit = 0) {
    return $this->_makeCall('users/' . $id . '/followed-by', true, array('count' => $limit));
  }

  /**
   * Get information about a relationship to another user
   *
   * @param integer $id                   Instagram user ID
   * @return mixed
   */
  public function getUserRelationship($id) {
    return $this->_makeCall('users/' . $id . '/relationship', true);
  }

  /**
   * Modify the relationship between the current user and the target user
   *
   * @param string $action                Action command (follow/unfollow/block/unblock/approve/deny)
   * @param integer $user                 Target user ID
   * @return mixed
   */
  public function modifyRelationship($action, $user) {
    if (true === in_array($action, $this->_actions) && isset($user)) {
      return $this->_makeCall('users/' . $user . '/relationship', true, array('action' => $action), 'POST');
    }
    //throw new Exception("Error: modifyRelationship() | This method requires an action command and the target user id.");
  }

  /**
   * Search media by its location
   *
   * @param float $lat                    Latitude of the center search coordinate
   * @param float $lng                    Longitude of the center search coordinate
   * @param integer [optional] $distance  Distance in metres (default is 1km (distance=1000), max. is 5km)
   * @param long [optional] $minTimestamp Media taken later than this timestamp (default: 5 days ago)
   * @param long [optional] $maxTimestamp Media taken earlier than this timestamp (default: now)
   * @return mixed
   */
  public function searchMedia($lat, $lng, $distance = 1000, $minTimestamp = NULL, $maxTimestamp = NULL) {
    return $this->_makeCall('media/search', false, array('lat' => $lat, 'lng' => $lng, 'distance' => $distance, 'min_timestamp' => $minTimestamp, 'max_timestamp' => $maxTimestamp));
  }

  /**
   * Get media by its id
   *
   * @param integer $id                   Instagram media ID
   * @return mixed
   */
  public function getMedia($id) {
    return $this->_makeCall('media/' . $id);
  }

  /**
   * Get the most popular media
   *
   * @return mixed
   */
  public function getPopularMedia() {
    return $this->_makeCall('media/popular');
  }

  /**
   * Search for tags by name
   *
   * @param string $name                  Valid tag name
   * @return mixed
   */
  public function searchTags($name) {
    return $this->_makeCall('tags/search', false, array('q' => $name));
  }

  /**
   * Get info about a tag
   *
   * @param string $name                  Valid tag name
   * @return mixed
   */
  public function getTag($name) {
    return $this->_makeCall('tags/' . $name);
  }

  /**
   * Get a recently tagged media
   *
   * @param string $name                  Valid tag name
   * @param integer [optional] $limit     Limit of returned results
   * @return mixed
   */
  public function getTagMedia($name, $limit = 0) {
    return $this->_makeCall('tags/' . $name . '/media/recent', false, array('count' => $limit));
  }

  /**
   * Get a list of users who have liked this media
   *
   * @param integer $id                   Instagram media ID
   * @return mixed
   */
  public function getMediaLikes($id) {
    return $this->_makeCall('media/' . $id . '/likes', true);
  }

  /**
   * Get a list of comments for this media
   * 
   * @param integer $id                   Instagram media ID
   * @return mixed
   */
  public function getMediaComments($id) {
    return $this->_makeCall('media/' . $id . '/comments', false);
  }

  /**
   * Add a comment on a media
   * 
   * @param integer $id                   Instagram media ID
   * @param string $text                  Comment content
   * @return mixed
   */
  public function addMediaComment($id, $text) {
    return $this->_makeCall('media/' . $id . '/comments', true, array('text' => $text), 'POST');
  }

  /**
   * Remove user comment on a media
   * 
   * @param integer $id                   Instagram media ID
   * @param string $commentID             User comment ID
   * @return mixed
   */
  public function deleteMediaComment($id, $commentID) {
    return $this->_makeCall('media/' . $id . '/comments/' . $commentID, true, null, 'DELETE');
  }

  /**
   * Set user like on a media
   *
   * @param integer $id                   Instagram media ID
   * @return mixed
   */
  public function likeMedia($id) {
    return $this->_makeCall('media/' . $id . '/likes', true, null, 'POST');
  }

  /**
   * Remove user like on a media
   *
   * @param integer $id                   Instagram media ID
   * @return mixed
   */
  public function deleteLikedMedia($id) {
    return $this->_makeCall('media/' . $id . '/likes', true, null, 'DELETE');
  }

  /**
   * Get information about a location
   *
   * @param integer $id                   Instagram location ID
   * @return mixed
   */
  public function getLocation($id) {
    return $this->_makeCall('locations/' . $id, false);
  }

  /**
   * Get recent media from a given location
   *
   * @param integer $id                   Instagram location ID
   * @return mixed
   */
  public function getLocationMedia($id) {
    return $this->_makeCall('locations/' . $id . '/media/recent', false);
  }

  /**
   * Get recent media from a given location
   *
   * @param float $lat                    Latitude of the center search coordinate
   * @param float $lng                    Longitude of the center search coordinate
   * @param integer [optional] $distance  Distance in meter (max. distance: 5km = 5000)
   * @return mixed
   */
  public function searchLocation($lat, $lng, $distance = 1000) {
    return $this->_makeCall('locations/search', false, array('lat' => $lat, 'lng' => $lng, 'distance' => $distance));
  }

  /**
   * Pagination feature
   * 
   * @param object  $obj                  Instagram object returned by a method
   * @param integer $limit                Limit of returned results
   * @return mixed
   */
  public function pagination($obj, $limit = 0) {
    if (true === is_object($obj) && !is_null($obj->pagination)) {
      if (!isset($obj->pagination->next_url)) {
        return;
      }
      $apiCall = explode('?', $obj->pagination->next_url);
      if (count($apiCall) < 2) {
        return;
      }
      $function = str_replace(self::API_URL, '', $apiCall[0]);
      $auth = (strpos($apiCall[1], 'access_token') !== false);
      if (isset($obj->pagination->next_max_id)) {
        return $this->_makeCall($function, $auth, array('max_id' => $obj->pagination->next_max_id, 'count' => $limit));
      } else {
        return $this->_makeCall($function, $auth, array('cursor' => $obj->pagination->next_cursor, 'count' => $limit));
      }
    } else {
      //throw new Exception("Error: pagination() | This method doesn't support pagination.");
    }
  }

  /**
   * Get the OAuth data of a user by the returned callback code
   *
   * @param string $code                  OAuth2 code variable (after a successful login)
   * @param boolean [optional] $token     If it's true, only the access token will be returned
   * @return mixed
   */
  public function getOAuthToken($code, $token = false) {
    $apiData = array(
      'grant_type'      => 'authorization_code',
      'client_id'       => $this->getApiKey(),
      'client_secret'   => $this->getApiSecret(),
      'redirect_uri'    => $this->getApiCallback(),
      'code'            => $code
    );
    
    $result = $this->_makeOAuthCall($apiData);
    return (false === $token) ? $result : $result->access_token;
  }

  /**
   * The call operator
   *
   * @param string $function              API resource path
   * @param array [optional] $params      Additional request parameters
   * @param boolean [optional] $auth      Whether the function requires an access token
   * @param string [optional] $method     Request type GET|POST
   * @return mixed
   */
  protected function _makeCall($function, $auth = false, $params = null, $method = 'GET') {
    if (false === $auth) {
      // if the call doesn't requires authentication
      $authMethod = '?client_id=' . $this->getApiKey();
    } else {
      // if the call needs an authenticated user
      if (true === isset($this->_accesstoken)) {
        $authMethod = '?access_token=' . $this->getAccessToken();
      } else {
        //throw new Exception("Error: _makeCall() | $function - This method requires an authenticated users access token.");
      }
    }
    
    if (isset($params) && is_array($params)) {
      $paramString = '&' . http_build_query($params);
    } else {
      $paramString = null;
    }
    
    $apiCall = self::API_URL . $function . $authMethod . (('GET' === $method) ? $paramString : null);
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiCall);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json'));
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    
    if ('POST' === $method) {
      curl_setopt($ch, CURLOPT_POST, count($params));
      curl_setopt($ch, CURLOPT_POSTFIELDS, ltrim($paramString, '&'));
    } else if ('DELETE' === $method) {
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
    }
    
    $jsonData = curl_exec($ch);
    if (false === $jsonData) {
      ////throw new Exception("Error: _makeCall() - cURL error: " . curl_error($ch));
    }
    curl_close($ch);
    
    return json_decode($jsonData);
  }

  /**
   * The OAuth call operator
   *
   * @param array $apiData                The post API data
   * @return mixed
   */
  private function _makeOAuthCall($apiData) {
    $apiHost = self::API_OAUTH_TOKEN_URL;
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiHost);
    curl_setopt($ch, CURLOPT_POST, count($apiData));
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($apiData));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    
    $jsonData = curl_exec($ch);
    if (false === $jsonData) {
      //throw new Exception("Error: _makeOAuthCall() - cURL error: " . curl_error($ch));
    }
    curl_close($ch);
    
    return json_decode($jsonData);
  }

  /**
   * Access Token Setter
   * 
   * @param object|string $data
   * @return void
   */
  public function setAccessToken($data) {
    (true === is_object($data)) ? $token = $data->access_token : $token = $data;
    $this->_accesstoken = $token;
  }

  /**
   * Access Token Getter
   * 
   * @return string
   */
  public function getAccessToken() {
    return $this->_accesstoken;
  }

  /**
   * API-key Setter
   * 
   * @param string $apiKey
   * @return void
   */
  public function setApiKey($apiKey) {
    $this->_apikey = $apiKey;
  }

  /**
   * API Key Getter
   * 
   * @return string
   */
  public function getApiKey() {
    return $this->_apikey;
  }

  /**
   * API Secret Setter
   * 
   * @param string $apiSecret 
   * @return void
   */
  public function setApiSecret($apiSecret) {
    $this->_apisecret = $apiSecret;
  }

  /**
   * API Secret Getter
   * 
   * @return string
   */
  public function getApiSecret() {
    return $this->_apisecret;
  }
  
  /**
   * API Callback URL Setter
   * 
   * @param string $apiCallback
   * @return void
   */
  public function setApiCallback($apiCallback) {
    $this->_callbackurl = $apiCallback;
  }

  /**
   * API Callback URL Getter
   * 
   * @return string
   */
  public function getApiCallback() {
    return $this->_callbackurl;
  }

}


class Pinterest_API {
        
        var $base_url;
        var $access_token;
        
        function __construct($access_token='') {
            $this->base_url = 'https://api.pinterest.com/v3';
            $this->access_token = $access_token;
        }
        
        function fetch_access_token($client_id, $client_secret, $username, $password) {

            $ch=curl_init();
            curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);                                                

            $post= array(
                "grant_type" => 'password',
                "scope"  => "read_write",
                "redirect_uri" => "http://pinterest.com/about/iphone/"
            );

            $host = "https://api.pinterest.com";
            $endpoint = "/v3/oauth/code_exchange/?consumer_id=$client_id&scope=read";
            $request_url = $host . $endpoint;
            curl_setopt($ch, CURLOPT_URL, $request_url);
            curl_setopt($ch, CURLOPT_POST,1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$post);
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,1); 
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $s=curl_exec($ch);
            $info = curl_getinfo($ch);
			
			if (false === $s) {
			  //throw new Exception("Error: _makeOAuthCall() - cURL error: " . curl_error($ch));
			}
            
            curl_close($ch);

            if ($info['http_code'] >= 200 and $info['http_code'] < 300) {
                list($junk, $access_token) = explode('=', $s, 2);
                $this->access_token = $access_token;
            } 
			
            return $s;
        }
        
        function upload_pin($params) {
            
            $post = self::params_filter($params, array(
                'board' => self::REQUIRED,      // board id #
                'details' => self::REQUIRED,    // description, a string, limit unknown, accepts markups
                'image' => self::REQUIRED,      // currently only accepts path to a file
                'latitude' => 0,
                'longitude' => 0,
                'publish_to_twitter' => 0,
                'publish_to_facebook' => 0    
            ));
        
            return $this->post('/pin/', $post);
        }
        
        function repin($params) {
            
            $params = self::params_filter($params, array(
                'board' => self::REQUIRED,
                'details' => self::REQUIRED,
                'pin' => self::REQUIRED,
            ));
            
            $post = array(
                'board' => $params['board'],
                'details' => $params['details'],
            );
            
            $endpoint = '/repin/' . $params['pin'] . '/';
            
            return $this->post($endpoint, $post);            
        }
        
        function activity($params=array()) {
            return $this->get('/activity/', $params);
        }
        
		function all($params=array()) {
		    $params = self::params_filter($params, array(
                'limit' => 36,
                'page' => 1
            ));
            
            return $this->get('/all/', $params);
		}

        function popular($params=array()) {
            $params = self::params_filter($params, array(
                'limit' => 36,
                'page' => 1
            ));
            
            return $this->get('/popular/', $params);
        }
        
        function newboards($params=array()) {
            return $this->get('/newboards/', $params);
        }
        
        function boards($params=array()) {
            return $this->get('/boards/', $params);    
        }
		function userinfo($username, $params=array()) {
            return $this->get('/users/'.$username, $params);
        }
		function getfolower($url) {
            return $this->getdom($url);
        }
		function userpins($username, $params=array()) {
            return $this->fetch('/pidgets/boards/'.$username.'/shoes/pins', $params);
        }
		function getpin($pin_ids, $params=array()) {
            return $this->fetch('/pidgets/pins/info/?pin_ids='.$pin_ids);
        }
        
        function categories($params=array()) {
            $params = self::params_filter($params, array(
                'limit' => 36,
                'page' => 1
            ));
            return $this->get('/boards/categories/', $params);
        }
        
        function post($endpoint, $post=array()) {
            $ch=curl_init();

            $request_url = $this->base_url . $endpoint;
            if ($this->access_token) {
                $request_url = "$request_url?access_token=" . $this->access_token;
            }
            
            curl_setopt($ch, CURLOPT_USERAGENT, 'Pinterest For iPhone / 1.4.3');
            
            curl_setopt($ch, CURLOPT_URL, $request_url);
            curl_setopt($ch, CURLOPT_POST,1);

            curl_setopt($ch, CURLOPT_POSTFIELDS,$post);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); 
            
#            curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
#            curl_setopt($ch, CURLOPT_PROXY, "127.0.0.1");
#            curl_setopt($ch, CURLOPT_PROXYPORT, 8888);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            
            $resp=curl_exec($ch);            
            $info = curl_getinfo($ch);
            curl_close($ch);
            
            return $resp;
        }
        
        function fetch($endpoint, $params=array()) {
			
            foreach ($params as $k => $v){
                $encoded_params[] = urlencode($k).'='.urlencode($v);
            }
			
            if($params){
            	$request_url = $this->base_url . $endpoint . "?" . implode('&', $encoded_params);
			}else{
				$request_url = $this->base_url . $endpoint;
			}
			
			$jsonData = file_get_contents($request_url);
			
			return json_decode($jsonData);
			
        }
		
		function getdom($request_url) {
			
			$domData = file_get_html($request_url)->plaintext;
			
			return $domData;
			
        }
		
		function get($endpoint, $params=array()) {
			
            foreach ($params as $k => $v){
                $encoded_params[] = urlencode($k).'='.urlencode($v);
            }
			
            if($params){
            	$request_url = $this->base_url . $endpoint . "?" . implode('&', $encoded_params);
			}else{
				$request_url = $this->base_url . $endpoint;
			}
    
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $request_url);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json'));
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			
			
			
			$jsonData = curl_exec($ch);
			
			if (false === $jsonData) {
			  //throw new Exception("Error: _makeCall() - cURL error: " . curl_error($ch));
			}
			
			curl_close($ch);
			//print_r($request_url);
			//echo'<pre>';print_r($jsonData);die();
			return json_decode($jsonData);
			
			
			
        }
        
        
        static function params_filter($params, $defaults) {
            
            foreach ($defaults as $k => $v) {
                
                if (!isset($params[$k])) {
                    
                    if ($v === self::REQUIRED) {
                        
                        $trace = debug_backtrace();
                        $function = $trace[1]['function'];
                        $caller = $trace[2]['function'].' in '.$trace[2]['file'].':'.$trace[2]['line'];
                        trigger_error(self::REQUIRED . ": $k (caller was $caller)");
                    
                    } else {
                        $params[$k] = $v;
                    }
                }
            }
            return $params;
        }
        
        const REQUIRED = 'arg is required';
        
    } // end class Pinterest_API
	
	
class TwitterAPIExchange{
    private $oauth_access_token;
    private $oauth_access_token_secret;
    private $consumer_key;
    private $consumer_secret;
    private $postfields;
    private $getfield;
    protected $oauth;
    public $url;

    /**
     * Create the API access object. Requires an array of settings::
     * oauth access token, oauth access token secret, consumer key, consumer secret
     * These are all available by creating your own application on dev.twitter.com
     * Requires the cURL library
     * 
     * @param array $settings
     */
    public function __construct(array $settings)
    {
        if (!in_array('curl', get_loaded_extensions())) 
        {
            //throw new Exception('You need to install cURL, see: http://curl.haxx.se/docs/install.html');
        }
        
        if (!isset($settings['oauth_access_token'])
            || !isset($settings['oauth_access_token_secret'])
            || !isset($settings['consumer_key'])
            || !isset($settings['consumer_secret']))
        {
            //throw new Exception('Make sure you are passing in the correct parameters');
        }

        $this->oauth_access_token = $settings['oauth_access_token'];
        $this->oauth_access_token_secret = $settings['oauth_access_token_secret'];
        $this->consumer_key = $settings['consumer_key'];
        $this->consumer_secret = $settings['consumer_secret'];
    }
    
    /**
     * Set postfields array, example: array('screen_name' => 'J7mbo')
     * 
     * @param array $array Array of parameters to send to API
     * 
     * @return TwitterAPIExchange Instance of self for method chaining
     */
    public function setPostfields(array $array)
    {
        if (!is_null($this->getGetfield())) 
        { 
            //throw new Exception('You can only choose get OR post fields.'); 
        }
        
        if (isset($array['status']) && substr($array['status'], 0, 1) === '@')
        {
            $array['status'] = sprintf("\0%s", $array['status']);
        }
        
        $this->postfields = $array;
        
        return $this;
    }
    
    /**
     * Set getfield string, example: '?screen_name=J7mbo'
     * 
     * @param string $string Get key and value pairs as string
     * 
     * @return \TwitterAPIExchange Instance of self for method chaining
     */
    public function setGetfield($string)
    {
        if (!is_null($this->getPostfields())) 
        { 
            //throw new Exception('You can only choose get OR post fields.'); 
        }
        
        $search = array('#', ',', '+', ':');
        $replace = array('%23', '%2C', '%2B', '%3A');
        $string = str_replace($search, $replace, $string);  
        
        $this->getfield = $string;
        
        return $this;
    }
    
    /**
     * Get getfield string (simple getter)
     * 
     * @return string $this->getfields
     */
    public function getGetfield()
    {
        return $this->getfield;
    }
    
    /**
     * Get postfields array (simple getter)
     * 
     * @return array $this->postfields
     */
    public function getPostfields()
    {
        return $this->postfields;
    }
    
    /**
     * Build the Oauth object using params set in construct and additionals
     * passed to this method. For v1.1, see: https://dev.twitter.com/docs/api/1.1
     * 
     * @param string $url The API url to use. Example: https://api.twitter.com/1.1/search/tweets.json
     * @param string $requestMethod Either POST or GET
     * @return \TwitterAPIExchange Instance of self for method chaining
     */
    public function buildOauth($url, $requestMethod)
    {
        if (!in_array(strtolower($requestMethod), array('post', 'get')))
        {
            //throw new Exception('Request method must be either POST or GET');
        }
        
        $consumer_key = $this->consumer_key;
        $consumer_secret = $this->consumer_secret;
        $oauth_access_token = $this->oauth_access_token;
        $oauth_access_token_secret = $this->oauth_access_token_secret;
        
        $oauth = array(
            'oauth_consumer_key' => $consumer_key,
            'oauth_nonce' => (string)mt_rand(),
            'oauth_signature_method' => 'HMAC-SHA1',
            'oauth_token' => $oauth_access_token,
            'oauth_timestamp' => time(),
            'oauth_version' => '1.0'
        );
        
		$oauth = array_map('rawurlencode', $oauth);
		
        $getfield = $this->getGetfield();
        
        if (!is_null($getfield))
        {
            $getfields = str_replace('?', '', explode('&', $getfield));
            foreach ($getfields as $g)
            {
                $split = explode('=', $g);
                $oauth[$split[0]] = $split[1];
            }
        }
        
        $base_info = $this->buildBaseString($url, $requestMethod, $oauth);
        $composite_key = rawurlencode($consumer_secret) . '&' . rawurlencode($oauth_access_token_secret);
        $oauth_signature = base64_encode(hash_hmac('sha1', $base_info, $composite_key, true));
        $oauth['oauth_signature'] = $oauth_signature;
        
        $this->url = $url;
        $this->oauth = $oauth;
        
        return $this;
    }
    
    /**
     * Perform the actual data retrieval from the API
     * 
     * @param boolean $return If true, returns data.
     * 
     * @return string json If $return param is true, returns json data.
     */
    public function performRequest($return = true)
    {
        if (!is_bool($return)) 
        { 
            //throw new Exception('performRequest parameter must be true or false'); 
        }
        
        $header = array($this->buildAuthorizationHeader($this->oauth), 'Expect:');
        
        $getfield = $this->getGetfield();
        $postfields = $this->getPostfields();

        $options = array( 
            CURLOPT_HTTPHEADER => $header,
            CURLOPT_HEADER => false,
            CURLOPT_URL => $this->url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 10,
			CURLOPT_SSL_VERIFYPEER => false
        );

        if (!is_null($postfields))
        {
            $options[CURLOPT_POSTFIELDS] = $postfields;
        }
        else
        {
            if ($getfield !== '')
            {
                $options[CURLOPT_URL] .= $getfield;
            }
        }

        $feed = curl_init();
        curl_setopt_array($feed, $options);
        $json = curl_exec($feed);
		if (false === $json) {
		  ////throw new Exception("Error: _makeCall() - cURL error: " . curl_error($feed));
		}
        curl_close($feed);
		
		//echo'<pre>';print_r($json);die;
        if ($return) { return json_decode($json); }
    }
    
    /**
     * Private method to generate the base string used by cURL
     * 
     * @param string $baseURI
     * @param string $method
     * @param array $params
     * 
     * @return string Built base string
     */
    private function buildBaseString($baseURI, $method, $params) 
    {
        $return = array();
        ksort($params);
        
        foreach($params as $key=>$value)
        {
            $return[] = "$key=" . $value;
        }
        
        return $method . "&" . rawurlencode($baseURI) . '&' . rawurlencode(implode('&', $return)); 
    }
    
    /**
     * Private method to generate authorization header used by cURL
     * 
     * @param array $oauth Array of oauth data generated by buildOauth()
     * 
     * @return string $return Header used by cURL for request
     */    
    private function buildAuthorizationHeader($oauth) 
    {
        $return = 'Authorization: OAuth ';
        $values = array();
        
        foreach($oauth as $key => $value)
        {
            $values[] = "$key=\"" . rawurlencode($value) . "\"";
        }
        
        $return .= implode(', ', $values);
        return $return;
    }

}

?>