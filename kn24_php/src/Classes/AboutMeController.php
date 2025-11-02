<?php
/**
 * Файл контролера AboutMeController
 *
 * Контролер для сторінки "Про мене". Відповідає за відображення
 * інформації про розробника, університет та навички.
 *
 * @package     kn24_php
 * @subpackage  Controllers
 * @author      Ян
 * @version     1.2.0
 */

namespace Classes;

use Classes\Viewer;

/**
 * Клас AboutMeController
 *
 * Обробляє логіку для сторінки "Про мене".
 * Передає дані про розробника в шаблон через клас Viewer.
 */
class AboutMeController
{
    /** @var string Ім'я розробника */
    private string $name = "Ян";

    /** @var string Назва університету */
    private string $university = "Ельворті";

    /** @var string Назва групи */
    private string $group = "КН-24";

    /** @var array Список навичок розробника */
    private array $skills = [
        'PHP (з Latte)',
        'HTML/CSS',
        'JavaScript',
        'MySQL',
        'MVC Architecture'
    ];

    /**
     * Метод show
     *
     * Основний метод контролера, який викликається роутером.
     * Збирає дані про розробника та передає їх у шаблон для рендерингу.
     *
     * @return void
     */
    public function show(): void
    {
        // Збираємо всі дані для передачі в шаблон
        $data = [
            'title'     => 'Про мене',
            'myName'    => $this->name,
            'myUni'     => $this->university,
            'myGroup'   => $this->group,
            'skills'    => $this->skills
        ];

        // Рендеримо шаблон через Viewer (як у інших контролерах)
        Viewer::show('aboutme', $data);
    }

    /**
     * Отримує ім'я розробника
     *
     * @return string Ім'я розробника
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Отримує назву університету
     *
     * @return string Назва університету
     */
    public function getUniversity(): string
    {
        return $this->university;
    }

    /**
     * Отримує назву групи
     *
     * @return string Назва групи
     */
    public function getGroup(): string
    {
        return $this->group;
    }

    /**
     * Отримує список навичок
     *
     * @return array Масив навичок розробника
     */
    public function getSkills(): array
    {
        return $this->skills;
    }
}