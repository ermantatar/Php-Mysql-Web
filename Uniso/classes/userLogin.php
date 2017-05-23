<?php

class UserLogin {
        public static function userLoggedIn() {

                // her class will be using it/ to check user is logged in or not! 
                // cookie var, surekli girmeme gerek yok. 

                if (!(isset($_COOKIE['SNID']))) {
                        return false;
                }else{

                        
                        if (access::create_query('SELECT user_id FROM login_tokens WHERE token=:token', array(':token'=>sha1($_COOKIE['SNID'])))) {
                                $userid = access::create_query('SELECT user_id FROM login_tokens WHERE token=:token', array(':token'=>sha1($_COOKIE['SNID'])))[0]['user_id'];

                                 
                                if (!(isset($_COOKIE['SNID_']))) {
                                        // eger cookie set edilmemisse. 
                                        //buraya gel true yap.
                                        // get token for login token table 
                                        //
                                        $cstrong = True;
                                        $token = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));
                                        access::create_query('INSERT INTO login_tokens VALUES (\'\', :token, :user_id)', array(':token'=>sha1($token), ':user_id'=>$userid));
                                        //token set et. 
                                        access::create_query('DELETE FROM login_tokens WHERE token=:token', array(':token'=>sha1($_COOKIE['SNID'])));

                                        // ***cookie boyle yapma cuneyd hoca degistir dedi, arastir bu yontem iyi degil ****
                                        // php de olmuyacak cookie unutma!! arastir!
                                        setcookie("SNID", $token, time() + 60 * 60 * 24 * 7, '/', NULL, NULL, TRUE);
                                        setcookie("SNID_", '1', time() + 60 * 60 * 24 * 3, '/', NULL, NULL, TRUE);

                                        // return userid.

                                        return $userid;
                                } else {
                                        // do not anything and return userid. 
                                        
                                        
                                        return $userid;
                                }
                        }
                
                }
        }
}

?>
