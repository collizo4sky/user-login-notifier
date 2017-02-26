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

    protected $backupGlobals = false;

    /**
     * @var User_Login_Notifier
     */
    protected $class_instance;

    /**
     * @var \WP_User currently logged user.
     */
    protected $current_user;

    public function setUp()
    {
        global $current_user;

        $this->current_user = $current_user;
        $this->class_instance = User_Login_Notifier::get_instance();
    }

    public function test_replace_placeholders()
    {
        $this->assertSame('collins', $this->class_instance->replace_placeholders('{username}', $this->current_user));
        $this->assertSame('Admin', $this->class_instance->replace_placeholders('{firstname}', $this->current_user));
        $this->assertSame('User', $this->class_instance->replace_placeholders('{lastname}', $this->current_user));

        return $this->current_user;
    }


    /**
     * @depends test_replace_placeholders
     * @param \WP_User $current_user
     */
    public function test_send_email($current_user)
    {
        $time = $this->getFunctionMock('SemaphoreApp', "wp_mail");
        $time->expects($this->once())->with(
            $this->stringContains('collins@wordpress.org'),
            $this->stringContains('Someone logged in'),
            $this->stringContains('we just thought you')
        );

        $this->class_instance->send_email('collins', $current_user);
    }
}
