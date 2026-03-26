<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Security extends CI_Security {

    /**
     * Redireciona ao login em vez de exibir erro 500 em falha de CSRF.
     */
    public function csrf_show_error()
    {
        $base = rtrim(config_item('base_url'), '/');
        header('Location: ' . $base . '/index.php/mapos/login');
        exit;
    }

    /**
     * Define o cookie CSRF com SameSite=Lax para compatibilidade
     * com browsers modernos e proxy reverso (Hostinger).
     */
    public function csrf_set_cookie()
    {
        $expire       = time() + $this->_csrf_expire;
        $secure       = (config_item('cookie_secure') === TRUE);
        $domain       = config_item('cookie_domain') ?: '';
        $path         = config_item('cookie_path') ?: '/';

        setcookie($this->_csrf_cookie_name, $this->_csrf_hash, [
            'expires'  => $expire,
            'path'     => $path,
            'domain'   => $domain,
            'secure'   => $secure,
            'httponly' => FALSE,
            'samesite' => 'Lax',
        ]);

        log_message('debug', 'CSRF cookie Set');

        return $this;
    }
}
