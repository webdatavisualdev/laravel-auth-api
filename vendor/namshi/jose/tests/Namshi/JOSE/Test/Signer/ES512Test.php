<?php

namespace Namshi\JOSE\Test\Signer;

use \PHPUnit_Framework_TestCase as TestCase;
use Namshi\JOSE\Signer\ES512;

class ES512Test extends TestCase
{

    public function setup()
    {
        // https://github.com/sebastianbergmann/phpunit/issues/1356
        if (defined('HHVM_VERSION')) {
            $this->markTestSkipped();
        }
        $this->privateKey = openssl_pkey_get_private(SSL_KEYS_PATH . "private.es512.key");
        $this->public = openssl_pkey_get_public(SSL_KEYS_PATH . "public.es512.key");
        $this->signer = new ES512;
    }

    public function testVerificationWorksProperly()
    {
        $encrypted = $this->signer->sign('aaa', $this->privateKey);
        $this->assertInternalType('bool', $this->signer->verify($this->public, $encrypted, 'aaa'));
        $this->assertTrue($this->signer->verify($this->public, $encrypted, 'aaa'));
    }

    public function testSigningWorksProperly()
    {
        $this->assertInternalType('string', $this->signer->sign('aaa', $this->privateKey));
    }

}
