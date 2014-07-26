<html>
  <script src="jquery-2.1.1.min.js"></script>
  <script src="jquery.tinysort.min.js"></script>
  <script type="text/javascript">
  <!--
    function toggle_visibility(id) {
       var e = document.getElementById(id);
       if(e.style.display == 'block')
          e.style.display = 'none';
       else
          e.style.display = 'block';
    }
    function send_command(id){
      var request = $.ajax({
        url: "send_command.php",
        type: "POST",
        data: {file: id},
      });
      request.done(function( msg ) {
        console.log("Request success" + msg);
      });
      request.fail(function( jqXHR, textStatus ) {
        console.log( "Request failed:" + textStatus );
      });
    }
    $(window).load(function() {
      $('#all_series>.series').tsort("",{attr:"id"});
      $('#loading').hide();
      $('#content').show();
      $('#search').on('keyup', function() {
        var val = $.trim(this.value);
        $(".series").hide();
        $(".series").filter(function() {
          return $(this).data('filter').toLowerCase().indexOf(val.toLowerCase()) != -1
        }).show();
      });
    });
  //-->
  //</script>
  <head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <meta name="viewport" content="width=device-width" />
    <title>Martin's kickass watch list</title>
  </head>
  <body>
    <div class="loading" id="loading">
      <div class="middle">
        <div class="inner">
          <img src="loading.gif">
        </div>
      </div>
    </div>
    <div id="content" style="display: none">
    <div id="all_series">
    <?php
      $next_episode = "";
      $di = new RecursiveDirectoryIterator('series');
      foreach (new RecursiveIteratorIterator($di) as $filename => $file) {
        if (strpos($filename,'next') !== false) {
          $next_file = file($filename);
          foreach($next_file as $next) {
            $next_episode = rtrim($next);
          }
        }
        if (strpos($filename,'episodes') !== false) {
          preg_match('#/(.*?)/#', $filename, $matches);
          $series_name = $matches[1];
          $episode_file = file($filename);
          echo '<div class="series" data-filter="' . $series_name . '" id="' . $series_name . '_series">';
          echo '  <div class="banner">';
          echo '    <a href="#' . $series_name . '_series"><img src="series/' . $series_name . '/banner.webp" onclick="toggle_visibility(\'' . $series_name . '_episodes\')"></a>';
          echo '  </div>';
          echo '  <div class="episodes" id="' . $series_name . '_episodes">';
          foreach($episode_file as $episode) {
            $episode = rtrim($episode);
            if ($next_episode == $episode) {
              echo '    <div class="next_episode" onclick="send_command(\'' . $episode . '\')">';
              echo '      ' . $episode;
              echo '    </div>';
            } else {
              echo '    <div class="episode" onclick="send_command(\'' . $episode . '\')">';
              echo '      ' . $episode;
              echo '    </div>';
            }
          }
          echo '  </div>';
          echo '</div>';
          $next_episode = "";
        }
      }
    ?>
      </div>
      <div id="controls_padder"></div>
      <div class="controls" id="controls">
        <div class="middle">
          <div class="inner">
            <div class="button" id="pausebutton" onClick="send_command('pause')"></div>
            <div class="button" id="stopbutton" onClick="send_command('stop')"></div>
            <div id="searchbar"><input type="search" name="filter" id="search" value="" tabindex=1 /></div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>