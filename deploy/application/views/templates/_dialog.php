<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>dialog demo</title>
  <link rel="stylesheet" href="http://code.jquery.com/mobile/1.5.0-alpha.1/jquery.mobile-1.5.0-alpha.1.min.css">
  <script src="http://code.jquery.com/jquery-3.2.1.min.js"></script>
  <script src="http://code.jquery.com/mobile/1.5.0-alpha.1/jquery.mobile-1.5.0-alpha.1.min.js"></script>
</head>
<body>
 
<div data-role="page" id="page1">
  <div data-role="header">
    <h1>jQuery Mobile Example</h1>
  </div>
  <div role="main" class="ui-content">
    <a href="#dialogPage" data-rel="dialog">Open dialogdddd</a>
  </div>
  <div data-role="footer">
    <h2></h2>
  </div>
</div>
 
<div data-role="page" id="dialogPage">
  <div data-role="header">
    <h2>Dialogdd</h2>
  </div>
  <div role="main" class="ui-content">
    <p>I am a dialog</p>
    <a href="" data-role="button" data-rel="back" data-theme="b">Ok, I get it</a>
    <a href="" data-role="button" data-rel="back" data-theme="a">Ahhhh</a>
  </div>
</div>
 
</body>
</html>