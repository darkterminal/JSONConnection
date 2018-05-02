<?php

namespace Darkterminal;

/**
* Json Connection
*
* @author  Darkterminal <trojanboy302@gmail.com>
* @package JSONConnection
* @version v1.0
* 
*/
class JSONConnection
{
	public $database;

	/**
	 * Load JSON File
	 * @param [string] $jsonfile path to json file
	 */
	public function __construct( $jsonfile )
	{
		$this->database = $jsonfile;
	}

	/**
	 * [insert Method]
	 * @param  array  $new array data will inserted!
	 * @return string      JSON String
	 */
	public function insert( array $new )
	{
		// read json file
		$data = file_get_contents($this->database);

		// decode json
		$json_arr = json_decode($data, true);
		$count = count($json_arr);

		$newKey 	= array_keys($new);

		for ($i=0; $i < $count; $i++) {

				if ( $new[$newKey[0]] == $json_arr[$i][$newKey[0]] ) {
				    return [
				    	'code' => 502,
				    	'message' => 'Code is exists!'
				    ];
				    exit(0);
				}

				if ( $new[$newKey[1]] == $json_arr[$i][$newKey[1]] ) {
					return [
						'code' => 502,
						'message' => 'Name is exists!'
					];
					exit(0);
				}

		}

		// Add new data
		$json_arr[] = $new;

		// encode json and save to file
		file_put_contents($this->database, json_encode($json_arr));
		return [
			'code' => 201,
			'message' => 'Data successfully inserted!',
			'time' => "Process took ". number_format(microtime(true) - time(), 2). " seconds."
		];
	}

	/**
	 * [selectAll Method]
	 * @return [json] list all data from database
	 */
	public function selectAll()
	{
		// load file
		$data = file_get_contents($this->database);

		// decode json to associative array
		$json_arr = json_decode($data, true);
		return [
			'code' => 200,
			'message' => 'Fetch all data from database',
			'time' => "Process took ". number_format(microtime(true) - time(), 2). " seconds.",
			'data' => $json_arr
		];
	}

	/**
	 * [update Method]
	 * @param  array  $find    Find resource using Key and Value
	 * @param  array  $replace replace data from key and value
	 * @return json          last data has modified
	 */
	public function update( array $find, array $replace )
	{
		$compareKey = explode(',', implode(',', $find))[0];
		$compareVal = explode(',', implode(',', $find))[1];

		$keyIndentifier = explode(',', implode(',', $replace))[0];
		$valueIndentifier = explode(',', implode(',', $replace))[1];
		
		// load file
		$data = file_get_contents($this->database);

		// decode json to array
		$json_arr = json_decode($data, true);
		foreach ($json_arr as $key => $value) {

		    if ( $value[$compareKey] == $compareVal ) {
		        $json_arr[$key][$keyIndentifier] = $valueIndentifier;	        
		    }
   
		}

		// encode array to json and save to file
		file_put_contents($this->database, json_encode($json_arr));
		return [
			'code' => 200,
			'message' => "Data id : {$compareVal} has been update in database",
			'time' => "Process took ". number_format(microtime(true) - time(), 2). " seconds.",
			'data' => $this->getLast()
		];
	}

	/**
	 * [delete Method]
	 * @param  string $column key name of data
	 * @param  int    $id     id or uniq of data
	 * @return
	 */
	public function delete( string $column, int $id )
	{
		// read json file
		$data = file_get_contents($this->database);

		// decode json to associative array
		$json_arr = json_decode($data, true);

		// get array index to delete
		$arr_index = array();
		foreach ($json_arr as $key => $value)
		{
		    if ( $value[ $column ] == $id )
		    {
		        $arr_index[] = $key;
		    }
		}

		// delete data
		foreach ($arr_index as $i)
		{
		    unset($json_arr[$i]);
		}

		// rebase array
		$json_arr = array_values($json_arr);

		// encode array to json and save to file
		file_put_contents($this->database, json_encode($json_arr));
		return [
			'code' => 200,
			'message' => "ID : {$id} delete from database",
			'time' => "Process took ". number_format(microtime(true) - time(), 2). " seconds."
		];
	}

	/**
	 * [getLast Method]
	 * @return json the last row on database
	 */
	public function getLast()
	{
		// load file
		$data = file_get_contents($this->database);

		// decode json to associative array
		$json_arr = json_decode($data, true);

		return [
			'code' => 200,
			'message' => "Get Last row database",
			'time' => "Process took ". number_format(microtime(true) - time(), 2). " seconds.",
			'data' => end($json_arr)
		];
	}

	/**
	 * [find Method]
	 * @param  string|integer $query query to search data in database
	 * @return json
	 */
	public function find( $query )
	{
		// load file
		$data = file_get_contents($this->database);
		
		// decode json to associative array
		$json_arr = json_decode($data, true);
		$json_key = array_keys($json_arr[0]);

		$qType = gettype($query);

		switch ($qType) {
			case 'string':
				
				for ($i=0; $i < count($json_arr); $i++) { 

					if ( in_array( $query, $json_arr[$i] ) ) {

						foreach ($json_arr as $key => $value) {
							
						    if ($value[$json_key[1]] == $query) {
						    	return [
						    		'code' => 200,
						    		'message' => "Find data contain {$query}",
						    		'time' => "Process took ". number_format(microtime(true) - time(), 2). " seconds.",
						    		'data' => $json_arr[$key]
						    	];
						    }

						}
					}

				}

				break;
			case 'integer':
				
				for ($i=0; $i < count($json_arr); $i++) { 

					if ( in_array( $query, $json_arr[$i] ) ) {

						foreach ($json_arr as $key => $value) {
							
						    if ($value[$json_key[0]] == $query) {
						    	return [
						    		'code' => 200,
						    		'message' => "Find data contain {$query}",
						    		'time' => "Process took ". number_format(microtime(true) - time(), 2). " seconds.",
						    		'data' => $json_arr[$key]
						    	];
						    }

						}
					}

				}

				break;
			
			default:
				return [
		    		'code' => 301,
		    		'message' => "Data must be string or integer"
		    	];
				break;
		}
	}

}