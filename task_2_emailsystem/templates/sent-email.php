---------------------------------------------------------------------------------------------------<?
/* @var \Kyriakos\MailPoetTask\Subscriber $subscriber */
/* @var \Kyriakos\MailPoetTask\Newsletters\Newsletter $newsletter */
?>

Recipient: <?= $subscriber->getName(); ?> <<?= $subscriber->getEmail(); ?>>
Subject: <?= $newsletter->getSubject(); ?>
<?= $newsletter->getBody(); ?>


---------------------------------------------------------------------------------------------------

