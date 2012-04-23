<?php
/**
 * Methods for checking the CAPTCHA and the solutions from the user.
 *
 * @link          http://example.com CAPTCHA Project
 */
require_once dirname(__FILE__).'/../config.php';

/**
 * Controller.
 *
 * Class holding everything that is related to checking the CAPTCHA and the solutions from the user.
 *
 * @package       -
 * @subpackage    -
 */
class Controller {

/**
 * Check CAPTCHA solution from the user.
 *
 * @param array $data Array contain the re-arranged images and the encrypted right solution.
 * @return boolean TRUE for the right solution and FALSE for the wrong solution.
 * @access public
 */
    function check($data=array()) {
        return sha1(CAPTCHA_SALT.json_encode($data['arrange'])) == $data['valid'];
    }
}
