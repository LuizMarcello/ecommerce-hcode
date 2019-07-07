<?php

namespace Hcode\Model;

use \Hcode\DB\Sql;
use \Hcode\Model;

class User extends Model
{
    const SESSION = "User";

    public static function login($login, $password)
    {
        $sql = new Sql();

        $results = $sql->select("SELECT * FROM tb_users WHERE
        deslogin  =:LOGIN", array(":LOGIN" => $login));

        if (count($results) === 0) {
            throw new \Exception("Usuário inexistente ou senha inválida.");
        }
        //Terá os valores de todos os campos do objeto:
        $data = $results[0];

        //função que verifica a senha do parâmetro
        //com o hash da mesma no BD.
        //Retorna 'true' ou 'false';
        if (password_verify($password, $data["despassword"]) === true) {
            $user = new User();

            $user->setData($data);

            $_SESSION[User::SESSION] = $user->getValues();

            return $user;
        } else {
            throw new \Exception("Usuário inexistente ou senha inválida.");
        }
    }

    public static function verifyLogin($inadmin = true)
    {
        if (
            !isset($_SESSION[User::SESSION]) || !$_SESSION[User::SESSION] ||
            !(int) $_SESSION[User::SESSION]["iduser"] > 0 ||
            (bool) $_SESSION[User::SESSION]["inadmin"] !== $inadmin
        ) {
            header("Locaton: /admin/login");
            exit;
        }
    }
    public static function logout()
    {
        $_SESSION[User::SESSION] = null;
    }
}
