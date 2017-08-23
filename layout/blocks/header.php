<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>books</title>
    <!--[if IE]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <link rel="stylesheet" type="text/css" href="/css/main.css">
    <script src="https://code.jquery.com/jquery-3.2.1.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.js"></script>
    <script>
        <?php
        $authors = NULL;
        $authorsObjectArray = (new Model_Authors())->getList();
        $counter = 0;
        foreach ($authorsObjectArray as $author) {
            $authors[$counter] = $author->getFullName();
            $counter++;
        }
        ?>
        var AUTHORS = <?=json_encode($authors)?>;
        var startTime = new Date('<?=$_SESSION['sessionStartTime']->format('c')?>');
    </script>
    <script src="/js/scripts.js"></script>
    <script src="/js/bookForm.js"></script>
</head>
<body>
<div id="timer"></div>