<?php

/**
 * Gluu-oxd-library
 *
 * An open source application library for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2016, Gluu inc, USA, Austin
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	    Gluu-oxd-library
 * @version     2.4.4
 * @author	    Vlad Karapetyan
 * @author		vlad.karapetyan.1988@mail.ru
 * @copyright	Copyright (c) 2016, Gluu inc federation (https://gluu.org/)
 * @license	    http://opensource.org/licenses/MIT	MIT License
 * @link	    https://gluu.org/
 * @since	    Version 2.4.4
 * @filesource
 */

/**
 * UMA RS Protect resources class
 *
 * Class is connecting to oXD-server via socket, and adding resources in gluu-server.
 *
 * @package		Gluu-oxd-library
 * @subpackage	Libraries
 * @category	Relying Party (RP) and User Managed Access (UMA)
 * @author		Vlad Karapetyan
 * @author		vlad.karapetyan.1988@mail.ru
 * @see	        Client_Socket_OXD_RP
 * @see	        Client_OXD_RP
 * @see	        Oxd_RP_config
 */

require_once 'Client_OXD_RP.php';

class Uma_rs_protect extends Client_OXD_RP{

    /**
     * @var string $request_oxd_id                         This parameter you must get after registration site in gluu-server
     */
    private $request_oxd_id = null;

    /**
     * @var array $request_resources                       This parameter you must get after registration site in gluu-server
     */
    private $request_resources = array();
    public $request_condition = array();
    /**
     * Constructor
     *
     * @return	void
     */
    public function __construct()
    {
        parent::__construct(); // TODO: Change the autogenerated stub
    }


    /**
     * @return string
     */
    public function getRequestOxdId()
    {
        return $this->request_oxd_id;
    }

    /**
     * @param string $request_oxd_id
     * @return void
     */
    public function setRequestOxdId($request_oxd_id)
    {
        $this->request_oxd_id = $request_oxd_id;
    }

    /**
     * @return array
     */
    public function getRequestResources()
    {

        return $this->request_resources;
    }

    public function addResource($path){
        $request_resources =  array(
            'path'=>$path,
            'conditions' => $this->request_condition
        );
        array_push($this->request_resources, $request_resources);
        $this->request_condition = null;
    }

    public function addConditionForPath(array $httpMethods, array $scopes, array $ticketScopes){
        $request_condition =   array(
                                        "httpMethods" => $httpMethods,
                                        "scopes" => $scopes,
                                        "ticketScopes" => $ticketScopes
        );

        array_push($this->request_condition, $request_condition);
        return $this->request_condition;
    }
    public function getCondition(){
        return  $this->request_condition;
    }
    /**
     * Protocol command to oXD server
     * @return void
     */
    public function setCommand()
    {
        $this->command = 'uma_rs_protect';
    }

    /**
     * Protocol parameter to oXD server
     * @return void
     */
    public function setParams()
    {
        $this->params = array(
            "oxd_id" => $this->getRequestOxdId(),
            "resources" => $this->getRequestResources()

        );
    }

}