<?php

  class UserFacade extends DBConnection {

    public function fetchUsers() {
      $sql = $this->connect()->prepare("SELECT * FROM users");
      $sql->execute();
      return $sql;
    }

    public function verifyUsernameAndPassword($username, $password) {
      $sql = $this->connect()->prepare("SELECT username, password FROM users WHERE username = ? AND password = ?");
      $sql->execute([$username, $password]);
      $count = $sql->rowCount();
      return $count;
    }

    public function addUser($firstName, $lastName, $username, $password) {
      $sql = $this->connect()->prepare("INSERT INTO users(first_name, last_name, username, password) VALUES (?, ?, ?, ?)");
      $sql->execute([$firstName, $lastName, $username, $password]);
      return $sql;
    }

    public function updateUser($updateUserId, $firstName, $lastName, $username, $password) {
      $sql = $this->connect()->prepare("UPDATE users SET first_name = '$firstName', last_name = '$lastName', username = '$username', password = '$password' WHERE id = $updateUserId");
      $sql->execute();
      return $sql;
    }

    public function deleteUser($userId) {
      $sql = $this->connect()->prepare("DELETE FROM users WHERE id = $userId");
      $sql->execute();
      return $sql;
    }

    public function isLoggedIn($userId) {
      $sql = $this->connect()->prepare("UPDATE user SET is_logged_in = 1 WHERE id = $userId");
      $sql->execute();
      return $sql;
    }

    public function isLoggedOut($userId) {
      $sql = $this->connect()->prepare("UPDATE user SET is_logged_in = 0 WHERE id = $userId");
      $sql->execute();
      return $sql;
    }

    public function signIn($username, $password) {
      $sql = $this->connect()->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
      $sql->execute([$username, $password]);
      return $sql;
    }

  }

?>