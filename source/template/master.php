<?php
!defined('IN_KC') && exit('Access Denied');
/**
 * @file    master
 * @author  ryan <cumt.xiaochi@gmail.com>
 * @created
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>伪博扮演</title>
        <meta property="qc:admins" content="245072776127216116631611006375" />
        <meta name="description" content="<?php echo get_set($page['description']); ?>" />
        <meta name="keywords" content="<?php echo implode(', ', get_set($page['keywords'], array())); ?>" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <?php
        echo css_node('reset');
        echo get_set($page['style'])? css_node($page['style'], 'less') : css_node('style', 'less');
//        echo js_node('less-1.3.0.min');
        ?>
        <script>
            less = {};
            less.env = 'development';
        </script>
        <?php
        echo js_node('less-1.3.0.min');
        ?>
        <?php if (ON_SERVER): ?>
        <script type="text/javascript">

        var _gaq = _gaq || [];
        _gaq.push(['_setAccount', 'UA-34837342-1']);
        _gaq.push(['_trackPageview']);

        (function() {
          var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
          ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
          var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
        })();

        </script>
        <?php endif; ?>
    </head>
    <body>
        <div class="append_parent"><!-- append parent -->
        </div>
        <div class="header"><!-- head -->
            <?php if ($show_header) { include 'template/block/header.php'; } ?>
        </div>
        <div class="content">
            <?php include $template; ?>
        </div>
        <div class="footer"><!-- footer -->
            <?php if ($show_footer) { include 'template/block/footer.php'; } ?>
        </div>
        <?php
        echo js_node('jquery-1.7.2.min');
        echo js_var('G', array('ROOT_URL'=>ROOT));
        echo implode('', $page['scripts']);
        echo js_node('every');
        ?>
    </body>
</html>
