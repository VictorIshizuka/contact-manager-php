<!DOCTYPE html>
<html lang="en" data-theme="dark">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title> <?= $title ?? 'Contacts manager' ?></title>

  <link rel="stylesheet" href="/assets/css/app.css">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
  <link
    rel="stylesheet"
    type="text/css"
    href="https://cdn.jsdelivr.net/npm/@phosphor-icons/web@2.1.1/src/regular/style.css" />
  <link
    rel="stylesheet"
    type="text/css"
    href="https://cdn.jsdelivr.net/npm/@phosphor-icons/web@2.1.1/src/fill/style.css" />

  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

  <style type="text/tailwindcss">
    @theme {
      --font-sans-serif:'sans-serif'
    }
    @layer base {
    h1 { @apply text-5xl font-bold; }
    h2 { @apply text-4xl font-bold; }
    h3 { @apply text-3xl font-bold; }
  }
  </style>
</head>

<?php

$validations = flash()->get('validations');

?>

<?php
$template = auth() ? 'app' : 'auth';
require base_path("views/templates/{$template}.php");
?>

</html>