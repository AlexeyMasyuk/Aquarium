  <script src="http://code.jquery.com/jquery-latest.js">
  <script type="text/javascript">
    setInterval("my_function();",5000); 
    function my_function(){
      $('#refresh').load(location.href + ' #time');
    }
  </script>
  </script>
</head>
<body>
  <div id="refresh"></div>
  <div id="time">
    <?php echo date('H:i:s');?>
  </div>  
</body>
</html>