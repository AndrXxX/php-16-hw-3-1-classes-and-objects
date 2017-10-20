<?php

class News
{
    private static $newsCount;
    private $title;
    private $author;
    private $content;
    private $dateTime;
    private $comments = [];

    public function __construct($title, $content, $author)
    {
        self::incrNewsCount();
        $this->author = $author;
        $this->title = $title;
        $this->content = $content;
        $this->dateTime = new DateTime();
    }

    private static function incrNewsCount()
    {
        ++self::$newsCount;
    }

    public static function getNewsCount()
    {
        return self::$newsCount;
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function getDateTime()
    {
        return $this->dateTime->format('H:i d.m.Y');
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function setNewComment($author, $comment)
    {
        $this->comments[] = new Comment($author, $comment);
    }

    public function getLastComments($numOfLastComments)
    {
        $lastComments = [];
        if ($numOfLastComments >= count($this->comments)) {
            /* если в действительности комментов меньше чем запрашивали - выводим все */
            return $this->getAllComments();
        }
        if ($numOfLastComments > 0) {
            for ($i = count($this->comments); $i <= $numOfLastComments; --$i) {
                $lastComments[] = $this->comments[$i]->getFullComment();
            }
        }
        return $lastComments;
    }

    public function getAllComments()
    {
        $allComments = [];
        foreach ($this->comments as $comment) {
            $allComments[] = $comment->getFullComment();
        }
        return $allComments;

    }
}

class Comment
{
    private $comment;
    private $author;
    private $dateTime;

    public function __construct($comment, $author)
    {
        $this->comment = $comment;
        $this->author = $author;
        $this->dateTime = new DateTime();
    }

    public function getFullComment()
    {
        return array($this->comment, $this->author, $this->getDateTime());
    }

    public function getDateTime()
    {
        return $this->dateTime->format('H:i d.m.Y');
    }

}

$news = [];
for ($i = 1; $i < rand(2, 10); $i++) {
    $news[$i] = new News('Название новости ' . $i, 'Содержание новости ' . $i, 'Автор ' . $i);
    for ($k = 1; $k < rand(0, 10); $k++) {
        $news[$i]->setNewComment('Автор ' . $k, 'Это комментарий №' . $k);
    }
}

?>

<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="UTF-8">
    <title>Новости</title>
    <style>
      .field {
        display: inline-block;
        vertical-align: top;
      }
    </style>
  </head>
  <body>
    <p>Общее количество новостей: <?= News::getNewsCount() ?> шт.</p>
    <hr>

      <?php foreach ($news as $separateNews) { ?>

        <fieldset class="field">
          <legend><?= $separateNews->getTitle() ?></legend>
          <p><?= $separateNews->getContent() ?></p>
          <small>Автор: <?= $separateNews->getAuthor() ?>, дата: <?= $separateNews->getDateTime() ?>.</small>

          <fieldset>
            <legend>Последние комментарии:</legend>

              <?php
              $numLastComments = count($separateNews->getLastComments(rand(0, 10)));
              if ($numLastComments === 0) {
                  ?>

                <p>Комментариев нет.</p>

                  <?php
              } else { ?>

                <p>Всего комментариев: <?= $numLastComments ?> шт.</p>

                  <?php foreach ($separateNews->getLastComments($numLastComments) as $comment) { ?>
                  <p><?= $comment[0] ?>, <?= $comment[1] ?>, <?= $comment[2] ?> </p>
                  <?php } ?>

              <?php } ?>

          </fieldset>

        </fieldset>
      <?php } ?>
  </body>
</html>