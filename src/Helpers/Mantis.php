<?php

namespace Devpaulopaixao\MantisBugcatcher\Helpers;

class Mantis
{
    public function __construct()
    {
        
    }

    /**
     * Create an issue minimal
     * @access private
     * @return void
     */
    private function checkEnvVariables():void{
        //CHECK BASIC INFORMATIONS
        if(is_null(env('MANTIS_URL'))){
            throw new \Exception('ENV missing MANTIS_URL variable');
        }

        if(is_null(env('MANTIS_SECRET'))){
            throw new \Exception('Env missing MANTIS_SECRET variable');
        }

        if(is_null(env('MANTIS_PROJECT_ID'))){
            throw new \Exception('ENV missing MANTIS_PROJECT_ID variable');
        }

        if(is_null(env('MANTIS_PROJECT_NAME'))){
            throw new \Exception('Env missing MANTIS_PROJECT_NAME variable');
        }
    }
    
    /**
     * Create an issue minimal
     *
     * @access public
     * @param array $data [
     * 
     * Array contendo os parâmetros necessários para executar a funcionalidade.
     *
     * @param string $summary
     * @param string $description
     * @param array $category[
     *  @param string $name
     * ]
     * 
     * ]
     * @return Object
     */
    public function createAnIssueMinimal(array $data):object{

        try {
            
            self::checkEnvVariables();

            if(!isset($data['summary'])){
                throw new \Exception('Missing error summary attribute');
            }

            if(!isset($data['description'])){
                throw new \Exception('Missing error description attribute');
            }

            if(!isset($data['category'])){
                throw new \Exception('Missing error category attribute');
            }

            if(isset($data['category']) && !isset($data['category']['name'])){
                throw new \Exception('Missing error category name attribute');
            }

            $httpClient = new Client([
                'headers' => [
                    'Accept'        => 'application/json',
                    'Content-Type'  => 'application/json',
                    'Authorization' => env('MANTIS_SECRET')
                ]       
            ]);
            
            $response = $httpClient->post(sprintf('%s/api/rest/issues', env('MANTIS_URL')),
                [
            'connect_timeout' => env('MANTIS_TIMEOUT', 3.14),
                'body' => json_encode(
                    [
                        'summary'          => $data['summary'],
                        'description'      => $data['description'],
                        'category'         => $data['category'],
                        'project'          => [
                            'name'         => env('MANTIS_PROJECT_NAME'),
                        ],
                    ]
                )]
            );

            return (object)[
                "status"   => 'success',
                "data"     => json_decode($response->getBody()->getContents()),
            ];
        
        } catch (\Throwable $e) {
            return (object)[
                "status"   => 'error',
                "code"     => isset($response) ? $response->getStatusCode() : 000,
                "message"  => $e->getMessage(),
            ];
        }
    }

    /**
     * Create an issue minimal
     *
     * @access public
     * @param array $data [
     * 
     * Array contendo os parâmetros necessários para registrar a issue completa.
     *
     * @param string $summary
     * @param string $description
     * @param string $additional_information (optional)
     * @param array $project[
     *  @param integer $id
     *  @param string $name
     * ]
     * @param array|integer $category[
     *  @param integer $id
     *  @param string $name
     * ]
     * @param array $handler[
     *  @param string $name
     * ]
     * @param array|integer $view_state[
     *  @param integer $id
     *  @param string $name
     * ]
     * @param array $priority[
     *  @param string $name
     * ]
     * @param array $severity[
     *  @param string $name
     * ]
     * @param array $reproducibility[
     *  @param string $name
     * ]
     * @param bool $sticky (optional) false
     * @param array $custom_fields (optional)[
     *  @param array $field[
     *      @param integer $id
     *      @param string $name
     *  ]
     *  @param string $value
     * ]
     * @param array $tags (optional)[
     *  @param string $name
     * ]
     * 
     * ]
     * @return Object
     */
    public function createAnIssue(array $data):object{

        try {
            self::checkEnvVariables();

            if(!isset($data['summary'])){
                throw new \Exception('Missing error summary attribute');
            }

            if(!isset($data['description'])){
                throw new \Exception('Missing error description attribute');
            }

            if(isset($data['sticky']) && !is_bool($data['sticky'])){
                throw new \Exception('Wrong sticky attribute. Only boolean type accepted');
            }

            if(isset($data['custom_fields']) && !is_array($data['custom_fields'])){
                throw new \Exception('Wrong custom_fields attribute. Only array type accepted');
            }
            
            if(isset($data['tags']) && !is_array($data['tags'])){
                throw new \Exception('Wrong tags attribute. Only array type accepted');
            }
            //SET DEFAULT VALUES
            $data['additional_information']        = isset($data['additional_information']) ? $data['additional_information'] : "";
            $data['category']['id']                = isset($data['category']['id']) ? $data['category']['id'] : 5;
            $data['category']['name']              = isset($data['category']['name']) ? $data['category']['name'] : "bugtracker";
            $data['handler']['name']               = isset($data['handler']['name']) ? $data['handler']['name'] : "vboctor";
            $data['view_state']['id']              = isset($data['view_state']['id']) ? $data['view_state']['id'] : 10;
            $data['view_state']['name']            = isset($data['view_state']['name']) ? $data['view_state']['name'] : "public";
            $data['severity']['name']              = isset($data['severity']['name']) ? $data['severity']['name'] : "trivial";
            $data['reproducibility']['name']       = isset($data['reproducibility']['name']) ? $data['reproducibility']['name'] : "always";
            $data['sticky']                        = isset($data['sticky']) ? $data['sticky'] : false;
            $data['custom_fields']                 = isset($data['custom_fields']) ? $data['custom_fields'] : [];
            $data['tags']                          = isset($data['tags']) ? $data['tags'] : [];


            $httpClient = new Client([
                'headers' => [
                    'Accept'        => 'application/json',
                    'Content-Type'  => 'application/json',
                    'Authorization' => env('MANTIS_SECRET')
                ]       
            ]);
            
            $response = $httpClient->post(sprintf('%s/api/rest/issues', env('MANTIS_URL')),
                [
                'connect_timeout' => env('MANTIS_TIMEOUT', 3.14),
                'body' => json_encode(
                    [
                        'summary'                     => $data['summary'],//"Nova excessão ocorrida em ". now()->format('d/m/Y H:i')
                        'description'                 => $data['description'],//$e->getMessage()
                        'additional_information'      => $data['additional_information'],
                        'project'          => [
                            'id'           => env('MANTIS_PROJECT_ID'),
                            'name'         => env('MANTIS_PROJECT_NAME'),
                        ],
                        'category'         => [
                            'id'           => $data['category']['id'],
                            'name'         => $data['category']['name'],
                        ],                    
                        'handler'          => [
                            'name'         => $data['handler']['name'],
                        ],
                        'view_state'       => [
                            'id'           => $data['view_state']['id'],
                            'name'         => $data['view_state']['name'],
                        ],
                        'priority'         => [
                            'name'         => $data['priority']['name'],
                        ],
                        'severity'         => [
                            'name'         => $data['severity']['name'],
                        ],
                        "reproducibility"  => [
                            "name"         => $data['reproducibility']['name'],
                        ],
                        'sticky'           => $data['sticky'],
                        'custom_fields'    => $data['custom_fields'],
                        'tags'             => $data['tags'],
                    ]
                )]
            );


            return (object)[
                "status"   => 'success',
                "data"     => json_decode($response->getBody()->getContents()),
            ];
        
        } catch (\Throwable $e) {
            return (object)[
                "status"   => 'error',
                "code"     => isset($resposne) ? $response->getStatusCode() : 000,
                "message"  => $e->getMessage(),
            ];
        }

    }
}