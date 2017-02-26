<?php

namespace SemaphoreApp\Tests;

use SemaphoreApp\User_Login_Notifier;
use phpmock\phpunit\PHPMock;

/**
 * Sample test case.
 */
class User_Login_NotifierTest extends \WP_UnitTestCase
{
    use PHPMock;

    /** @var User_Login_Notifier */
    protected static $class_instance;

    /** @var \WP_User currently logged user. */
    protected static $current_user;

    public static function setUpBeforeClass()
    {
        global $current_user;
        self::$current_user = $current_user;
        self::$class_instance = User_Login_Notifier::get_instance();
    }

    public function test_replace_placeholders()
    {
        $this->assertSame('collins', self::$class_instance->replace_placeholders('{username}', self::$current_user));
        $this->assertSame('Admin', self::$class_instance->replace_placeholders('{firstname}', self::$current_user));
        $this->assertSame('User', self::$class_instance->replace_placeholders('{lastname}', self::$current_user));

        return self::$current_user;
    }

    public function test_send_email()
    {
        $time = $this->getFunctionMock('SemaphoreApp', "wp_mail");
        $time->expects($this->once())->with(
            $this->stringContains('collins@wordpress.org'),
            $this->stringContains('Someone logged in'),
            $this->stringContains('we just thought you')
        );

        self::$class_instance->send_email('collins', self::$current_user);
    }
}
