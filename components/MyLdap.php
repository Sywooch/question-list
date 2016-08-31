<?php

namespace app\components;

class MyLdap {

    public $accountSuffix = '@imb.ru';
    public $domain = 'imb.ru';
    public $base_dn = 'OU=IMB Users,DC=IMB,DC=RU';
    public $ldapPort = 389;
    public $ldap_conn;
    private $user;
    private $pass;

    function __construct($u, $p) {
        $this->user = $u;
        $this->pass = $p;

        $this->ldap_conn = ldap_connect($this->domain, $this->ldapPort);
     }

    public function isUser(){

        if (@ldap_bind($this->ldap_conn, $this->user.$this->accountSuffix, $this->pass)) {
            return true;
        } else {
            return false;
        }
    }

    public function searchUser(){

        $filter = 'samaccountname='.$this->user;
        $res = ldap_search($this->ldap_conn, $this->base_dn, $filter);
        $arr = ldap_get_entries($this->ldap_conn, $res);

        return [
            'email'=>$arr[0]['mail'][0],
            'name_en'=>isset($arr[0]['displayname'][0]) ? $this->name($arr[0]['displayname'][0]) : $this->user,
            'name_ru'=>isset($arr[0]['ucbru-rusdescription'][0]) ? iconv('windows-1251', 'utf-8', $this->name($arr[0]['ucbru-rusdescription'][0])) : $this->user,
        ];
    }

    public function closeConnect(){
        ldap_close($this->ldap_conn);
    }


    public function name($name){
        $exp = explode(' - ', $name);

        //доделать что бы не выводилось разного овна  RXU и тому подобного
        // $fexp = explode(', ', $exp[0]);
        // var_dump($fexp); die;
        return $exp[0];
    }
}