<?php

namespace aceAuth;
require_once 'generated-conf\config.php';
require_once 'vendor\autoload.php';
require_once 'propel.php';
require_once 'SessionDelegate.php';

use aceAuth\Group;
use aceAuth\GroupQuery;
use aceAuth\Map\GroupTableMap;
use aceAuth\Role;
use aceAuth\RoleQuery;
use aceAuth\Map\RoleTableMap;
use aceAuth\User;
use aceAuth\UserQuery;
use aceAuth\Map\UserTableMap;
use aceAuth\UserGroup;
use aceAuth\UserGroupQuery;
use aceAuth\Map\UserGroupTableMap;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\Collection;
use Mailgun\Mailgun;


class AuthManager
{
    /**
     * Name of instance.
     */
    private $name;
    /**
     * Session Delegate used for handling the temp store of data.
     */
    private $session;
    /**
     * Collection of logged in users.
     */
    public $users = array();

    private $mgClient;

    private $domain;

    /**
     * AuthManager constructor.
     * @param $name
     * @param SessionDelegate $session
     */
    public function __construct($name, SessionDelegate $session)
    {
        $this->name = $name;
        $this->session = $session;
        $this->users = $this->LoadUserArray();
        $this->mgClient = new Mailgun('key-3559b69536b5cbbf75d83ffe1bd5ea4a');
        $this->domain = "sandbox8c881d2fd94548dab4f15de0f0468e9d.mailgun.org";
    }

    function LoadUserArray()
    {
        if (isset($_SESSION['Ace_Auth']['users']))
        {
            if (!empty($_SESSION['Ace_Auth']['users']))
            {
                return $_SESSION['Ace_Auth']['users'];
            }

            return [];
        }
        return [];
    }
    /**
     * registar is a method for receiving user information and writing it to the database.
     * @param null $username
     * @param null $password
     * @param null $email
     */
    function registar($username = null, $password = null, $email = null)
    {


        $clean_username = filter_var($username, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $clean_password = filter_var($password, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $hash_password = $this->hash($clean_password);

        $clean_email = filter_var($email, FILTER_SANITIZE_EMAIL);

        $user = new User();
        $user->setUsername($clean_username);
        $user->setPassword($hash_password);
        $user->setEmail($clean_email);
        $id = $user->save();

        $user->toArray(UserTableMap::TYPE_FIELDNAME);

        print_r($user);
        if (isset($id)) {
            $this->session->WriteAuthData($this->name(), $id);


            echo 'save successful';
        }


    }

    /**
     * a method to receive user credential and check them against the database and login them in .
     * @param $username
     * @param $password
     * @param bool $remember_me
     * @return bool|int
     */
    public function login($username, $password, $remember_me = false)
    {

        $user = $this->findUser($username);

        if ($this->checkIfLoggedIn($user->getId())==false) {

            if (!isset($_COOKIE['remember_me']) || empty($_COOKIE['remember_me'])) {
                if (!isset($user)) {
                    return false;
                }

                if (!$this->verify($password, $user->getPassword())) {
                    return false;
                }

                if ($remember_me == true) {
                    $expire_in = 7200;
                    $token=1 ;
                    $user->setRememberMe($token);
                    setcookie('remember_me', $token, time() + $expire_in);
                    $user->save();
                }

                array_push($this->users, $user->getId());
                
                $this->session->WriteAuthData('users', $this->users);
            } else {
                $token = $_COOKIE['remember_me'];
                if ($user->getRememberMe() === $token) {
                    $this->loginUser($user);
                }
            }

            return $user->getId();
        } else {
            echo "you are logged in dingus";
            return $user->getId();
        }
    }

    /**
     * method takes user id and queries the data base to get Username
     * @param $id
     * @return string
     */
    function GetUserName($id)
    {
        $u = new UserQuery();
        $user = $u->findOneById($id);
        return $user->getUsername();
    }

    /**
     * method handles the logout of the user.
     * @param $id
     */
    public function logout($id)
    {
        foreach (array_keys($this->users,$id,true) as $key) {
            unset($this->users[$key]);
        }

        $this->session->WriteAuthData('users', $this->users);

    }

    /**
     *
     */
    public function resetPassword()
    {
    }

    /**
     * handles the writing of the user to session and internal collection
     * @param \aceAuth\User $user
     */
    public function loginUser(User $user)
    {
        array_push($this->users, $user->getId());
        $this->session->WriteAuthData('users', $this->users);
    }

    /**
     * getter method for instance name of auth manager
     * @return mixed
     */
    function name()
    {
        return $this->name;
    }

    /**
     * method to hash the user password
     * @param $password
     * @return bool|string
     */
    function hash($password)
    {
        return password_hash($password, PASSWORD_BCRYPT, array('cost' => 8));
    }

    /**
     * method handles the verification of a password
     * @param $password
     * @param $hash
     * @return bool
     */
    function verify($password, $hash)
    {
        return password_verify($password, $hash);
    }

    /**
     * method checks if the user is logged in
     * @param \aceAuth\User $user
     * @return bool
     */
    function checkIfLoggedIn($id)
    {
        $list = $this->users;
        return in_array($id, $list);

    }
    /**
     * method finds a user by Username
     * @param $username
     * @return \aceAuth\User
     */
    function findUser($username)
    {
        $u = new UserQuery();
        $user = $u->findOneByUsername($username);
        return $user;
    }

    /**
     * method handles checking if a user has a role
     * @param $username
     * @param $checkValue
     * @return bool
     */
    function checkRole($username, $checkValue)
    {
        $user = $this->findUser($username);
        if ($this->checkIfLoggedIn($user)) {
            $r = new RoleQuery();
            $chkRole = $r->findOneByRole($checkValue);
            $groups = $user->getGroups();
            foreach ($groups as $i) {
                if ($i->getRoles()->contains($chkRole)) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * method gets the groups a user belongs to
     * @param $id
     * @return array|bool
     */
    function getUserGroups($id)
    {
        $q = new UserQuery();
        $user = $q->findOneById($id);
        if ($user->countGroups() >= 1) {

            $relation = $user->getGroups();
            return $relation->toArray();
        }
        return false;
    }

    /**
     * handles the creation of a group
     * @param $name
     * @param $description
     * @return int
     */
    function createGroup($name, $description)
    {

        $group = new Group();
        $group->setName($name);
        $group->setDescription($description);
        $group->save();
        $group->reload();

        return $group->getId();
    }

    /**
     * handles adding a user to a group
     * @param $userId
     * @param $groupid
     * @param null $roleId
     * @return bool
     */
    function addMemberToGroup($userId, $groupId)
    {
        $u = NEW UserQuery();
        $user = $u->findOneById($userId);
        $g = new GroupQuery();
        $group = $g->findOneById($groupId);


        $group->addUser($user);

         $group->save();
    }

    /**
     * handles the creation of roles.
     * @param $Groupid
     * @param $roleName
     * @param $roleDescription
     * @return int
     */
    function CreateRole($Groupid,$roleName,$roleDescription)
    {
        $g = new GroupQuery();
        $group = $g->findOneById($Groupid);
        $role = new Role();
        $role->setRole($roleName);
        $role->setDescription($roleDescription);
        $group->addGroupRole($role);
        return $group->save();

    }

    /**
     * get an array of all users
     * @return array
     */
    function getAllUsers()
    {
        $u = new UserQuery();
        $user = $u->find();
        return $user->toArray();
    }

    /**
     * gets a array of all roles linked to a group
     * @param $groupId
     * @return array
     */
    function getGroupRoles($groupId)
    {
        $g = new GroupQuery();
        $group = $g->findOneById($groupId);
        $roles = $group->getGroupRoles();
        return $roles->toArray();

    }

    /**
     * gets the name of the group based on id
     * @param $id
     * @return string
     */
    function getGroupName($id)
    {
        $g = new GroupQuery();
        $group = $g->findOneById($id);
        return $group->getName();
    }

    /**
     * gets all the in a group
     * @param $id
     * @return array
     */
    function getGroupMembers($id)
    {

        $ug = new UserGroupQuery();
        $users = $ug->filterByGroupId($id)->joinUser()->withColumn('Username')->find();
        return $users->toArray();

    }

    /**
     * handles the editing of the users role in a group.
     * @param $groupId
     * @param $UserId
     * @param $roleId
     */
    function editMemberRole($groupId,$UserId,$roleId)
    {
        $ug = new UserGroupQuery();
        $user = $ug->filterByGroupId($groupId)->findOneByUserId($UserId);
        $user->setRoleId($roleId);
        $user->save();

    }
    /**
     * gets a array of users with roles.
     * @param $id
     */
    function getGroupMembersWithRole($id)
    {
        $ug = new UserGroupQuery();
        $users = $ug->filterByGroupId($id)->joinUser()->withColumn('Username')->joinGroupRole()->withColumn('Role')->find();
        
        return $users->toArray();
    
    }

    function sendEnrollEmail($groupId,$email,$URL)
    {
        $g = new GroupQuery();
        $group = $g->findOneById($groupId);

        $token = bin2hex(random_bytes(25));
        $user = new User();
        $user->setUsername($email);
        $pw = $this->hash('password');
        $user->setPassword($pw);
        $user->setEmail($email);
        $user->setEnrollmentId($token);
        $user->save();
        $user->reload();
        $group->addUser($user);
        $group->save();
        $group->reload();

        $mgClient = new Mailgun('key-3559b69536b5cbbf75d83ffe1bd5ea4a');
        $domain = "sandbox8c881d2fd94548dab4f15de0f0468e9d.mailgun.org";
       return $result =$mgClient->sendMessage($domain, array(
            'from'           => 'BitSpace<postmaster@sandbox8c881d2fd94548dab4f15de0f0468e9d.mailgun.org>',
            'to'             => $email,
            'subject'        => 'You have been invited',
            'text'           => 'You have been invited to join'.$group->getName().'follow the link to set up your account',
            'html'           => "<a href='$URL?token=$token'>Click Here</a> "

        ));


    }

    function RetrieveEnrolledAccount($token)
    {
        $u = new UserQuery();
        $user = $u->findOneByEnrollmentId($token);
        return $user->toArray();
    }

    function SetUpEnrolledAccount($params)
    {
        $u = new UserQuery();
        $user = $u->findOneById($params['id']);
        $pw = $this->hash($params['password']);
        $user->setUsername($params['username']);
        $user->setPassword($pw);
        return $user->save();

    }

}


