<?php
namespace App\Library;

class Encryption
{

private $ENCRYPTION_ALGORITHM = 'AES-256-CBC';

private $ENCRYPTION_KEY="!@#$%^&*CTA";
    /**
     * Returns an encrypted & utf8-encoded
     */
    public static function encryptbk($pure_string, $encryption_key='!@#$%^&*') {
        $iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $encrypted_string = mcrypt_encrypt(MCRYPT_BLOWFISH, $encryption_key, utf8_encode($pure_string), MCRYPT_MODE_ECB, $iv);
        return $encrypted_string;
    }

    /**
     * Returns decrypted original string
     */
    function decryptbk($encrypted_string, $encryption_key='!@#$%^&*') {
        $iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $decrypted_string = mcrypt_decrypt(MCRYPT_BLOWFISH, $encryption_key, $encrypted_string, MCRYPT_MODE_ECB, $iv);
        return $decrypted_string;
    }

  public  function encrypt_bk_2($ClearTextData) {
    // This function encrypts the data passed into it and returns the cipher data with the IV embedded within it.
    // The initialization vector (IV) is appended to the cipher data with 
    // the use of two colons serve to delimited between the two.
   
    $EncryptionKey = base64_decode($this->ENCRYPTION_KEY);
    $InitializationVector  = openssl_random_pseudo_bytes(openssl_cipher_iv_length($this->ENCRYPTION_ALGORITHM));
    $EncryptedText = openssl_encrypt($ClearTextData, $this->ENCRYPTION_ALGORITHM, $EncryptionKey, 0, $InitializationVector);
    return base64_encode($EncryptedText . '::' . $InitializationVector);
}

public function decrypt_bk_2($CipherData) {
    // This function decrypts the cipher data (with the IV embedded within) passed into it 
    // and returns the clear text (unencrypted) data.
    // The initialization vector (IV) is appended to the cipher data by the EncryptThis function (see above).
    // There are two colons that serve to delimited between the cipher data and the IV.
    
    $EncryptionKey = base64_decode($this->ENCRYPTION_KEY);
    list($Encrypted_Data, $InitializationVector ) = array_pad(explode('::', base64_decode($CipherData), 2), 2, null);
    return openssl_decrypt($Encrypted_Data, $this->ENCRYPTION_ALGORITHM, $EncryptionKey, 0, $InitializationVector);
}
public  function encrypt($ClearTextData,$encode='') {
   
    return base64_encode($ClearTextData);
   
}

public  function decrypt($ClearTextData,$decode='') {
   
    return base64_decode($ClearTextData);
   
}

function simpleCrypt( $string, $action = 'e' ) {
    // you may change these values to your own
    $secret_key = 'officeday';
    $secret_iv = 'officeday.net';
 
    $output = false;
    $encrypt_method = "AES-256-CBC";
    $key = hash( 'sha256', $secret_key );
    $iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );
 
    if( $action == 'e' ) {
        $output = base64_encode( openssl_encrypt( $string, $encrypt_method, $key, 0, $iv ) );
    }
    else if( $action == 'd' ){
        $output = openssl_decrypt( base64_decode( $string ), $encrypt_method, $key, 0, $iv );
    }
 
    return $output;

}
}

?>