<?php

namespace SemaphoreApp;

class User_Login_Notifier
{
    public function __construct()
    {
        add_action('wp_login', array($this, 'send_email'), 10, 2);
    }

    /**
     * Email subject or title.
     *
     * @return mixed
     */
    public function email_subject()
    {
        return __('Someone logged in to your account. Is this you?');
    }

    /**
     * Email subject or title.
     *
     * @return mixed
     */
    public function email_body()
    {
        return <<<BODY
Hi {firstname} {lastname}, we just thought you should know someone logged in to your account with username {username}.
IF this is you, ignore this message otherwise contact us immediately via contact@website.com    
BODY;
    }

    /**
     * Callback triggered after a successful user login.
     *
     * @param string $user_login
     * @param \WP_User $user
     */
    public function send_email($user_login, $user)
    {
        wp_mail(
            $user->user_email,
            $this->email_subject(),
            $this->replace_placeholders($this->email_body(), $user)
        );
    }

    /**
     * Replaces placeholders in the email body with their real values.
     *
     * @param string $email_body
     * @param \WP_User $user
     *
     * @return mixed
     */
    public function replace_placeholders($email_body, $user)
    {
        $search = array(
            '{username}',
            '{firstname}',
            '{lastname}',
        );

        $replace = array(
            $user->user_login,
            $user->first_name,
            $user->last_name
        );

        return str_replace($search, $replace, $email_body);
    }

    /**
     * @return User_Login_Notifier
     */
    public static function get_instance()
    {
        static $instance = null;

        if (is_null($instance)) {
            $instance = new self();
        }

        return $instance;
    }
}