{strip}
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="theme-color" content="#173e2c" />
  <title>Sign in · EGAR CRM</title>
  <link rel="stylesheet" href="public/react-login/assets/login.css?v=3" />
</head>
<body>
  <form id="egar-login-form" action="index.php?module=Users&action=Login" method="POST">
    <div id="egar-react-login" data-login-error="{if isset($smarty.request.error)}1{else}0{/if}"></div>
  </form>
  <noscript>This sign-in experience requires JavaScript.</noscript>
  <script type="module" src="public/react-login/assets/login.js?v=3"></script>
</body>
</html>
{/strip}
