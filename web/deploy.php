<!doctype html>
<html class="no-js"   lang="en" dir="ltr">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Deploy</title>
    <link rel="shortcut icon" href="favicon.ico" type="image/vnd.microsoft.icon" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://getbootstrap.com/examples/jumbotron-narrow/jumbotron-narrow.css">
    <script type="text/javascript">
        window.deployDots = 2;
        window.startDeploy = function() {
            var button = document.getElementById('start');
            button.disabled = 'disabled';
            button.value = 'Deploying.';
            window.setInterval(
                function() {
                    var button = document.getElementById('start');
                    button.value = 'Deploying';
                    for (var i = 0; i < window.deployDots; i++) {
                      button.value += '.';
                    }
                    window.deployDots++;
                    if (window.deployDots === 4) {
                      window.deployDots = 1;
                    }
                },
                1000
            );
        };
    </script>
  </head>
  <body>
  <div class="container" style="max-width: 960px;">
  <div class="jumbotron">

<?php
  set_time_limit(0);
  ini_set('display_errors', 0);

  if (empty($_POST)) {
    print '<h1>Deploy</h1>';
    print '<p class="lead">This will download latest code from repository and clear caches.</p>';
    print '<form role="form" method="POST" action="">';
    print '<input type="hidden" name="sent" id="send" value="" />';
    print '<p><input class="btn btn-danger btn-lg" id="start" type="button" value="Deploy!" onclick="document.getElementById(\'send\').value = \'a\'; this.form.submit(); window.startDeploy();" /></p>';
    print '</form>';
  }
  else {
    $commands = array();
    $commands[] = 'echo "<strong>Reverting code</strong</br>" && git checkout . 2>&1';
    $commands[] = 'echo "<strong>Fetching from git</strong><br/>" && git pull origin master 2>&1';
    $commands[] = 'echo "<strong>Clearing caches</strong><br/>" && php ../app/console cache:clear --env=prod 2>&1';
    $command = implode(' && echo "<hr/>" && ', $commands);
    print '<h1>Finished!</h1>';
    print '<p class="lead">Deployment has finished!</p>';
    print '<code style="text-align: left;"><pre>' . shell_exec($command) . '</pre></code>';
  }
?>
</div>
</div>
</body>
</html>
