<?php

abstract class User {
    private $name;
    private $email;

    public function __construct($name, $email) {
        $this->name = $name;
        $this->email = $email;
    }

    abstract public function getRole();

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }
}

class Student extends User {
    private $group;

    public function __construct($name, $email, $group) {
        parent::__construct($name, $email);
        $this->group = $group;
    }

    public function getRole() {
        return "Студент";
    }

    public function getGroup() {
        return $this->group;
    }

    public function setGroup($group) {
        $this->group = $group;
    }
}

class Teacher extends User {
    private $subject;

    public function __construct($name, $email, $subject) {
        parent::__construct($name, $email);
        $this->subject = $subject;
    }

    public function getRole() {
        return "Викладач";
    }

    public function getSubject() {
        return $this->subject;
    }

    public function setSubject($subject) {
        $this->subject = $subject;
    }
}

$student = new Student("Ян Короп", "yan@example.com", "КН-24");
$teacher = new Teacher("Константин Сурков", "konstantyn@example.com", "Програмування");

echo "<h3>Інформація про студентa:</h3>";
echo "Ім’я: " . $student->getName() . "<br>";
echo "Email: " . $student->getEmail() . "<br>";
echo "Роль: " . $student->getRole() . "<br>";
echo "Група: " . $student->getGroup() . "<br><br>";

echo "<h3>Інформація про викладача:</h3>";
echo "Ім’я: " . $teacher->getName() . "<br>";
echo "Email: " . $teacher->getEmail() . "<br>";
echo "Роль: " . $teacher->getRole() . "<br>";
echo "Предмет: " . $teacher->getSubject() . "<br>";
?>
