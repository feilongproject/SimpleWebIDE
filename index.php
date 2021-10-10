<?php include("./config.php")?>
<!DOCTYPE HTML>
<html lang="zh">
  <head>
    <meta charset="UTF-8">
    <title>SimpleWebIDE - 飞龙project</title>
    <link href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdn.staticfile.org/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
    <script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script>
    async function runcode(code,cin,type){
        console.log(code,type);
        if(type == "c_cpp"){
		var res=await fetch("<?php echo $ApiUrl?>?code="+encodeURIComponent(code)+"&cin="+encodeURIComponent(cin));
          var data = await res.text();
          $("#cout").html("<pre class=\"fillall\">" + data.replace(/</g,"<").replace(/>/g,">").replace(/\n/g,"<br>") + "</pre>");
        }

      }
    </script>
    <style type="text/css" media="screen">
      body {background-color: #2D2F32;color: #fff;}
      #editor {margin: 0;height:100%;position: absolute;top: 5%;bottom: 0;left: 0;right: 0;}
      .inout{margin: 0;height:100%;width:100% ;position: absolute;top: 20%}
      #cin {margin: 0;height:50%;width:50% ;position: absolute;top: 20%;bottom: 0;left: 0;right: 0;}
      #cout {margin: 0;height:50%;width:50% ;position: absolute;top: 20%;bottom: 0;left: 50%;right: 0;}
      .container {margin: 0;top: 0;bottom: 0;}
      #editordiv {height: 75%;margin: 0;position: absolute;top: 0;bottom: 0;left:0;right:0%;}
      #iframediv {margin: 0;position: absolute;top: 80%;bottom: 0%;left: 0%;right: 0%;}
      .col-md-2 {margin: 0;position: absolute;top: 0;bottom: 0;left: 83.333%;right:0;}
      .form-control {width: auto;}
      .command-group {margin: 0;height:50%;width:100% ;position: absolute;top: 0%;bottom: 0;left: 0;right: 0;} 
    </style>
  </head>
  <body>
    <div>
      <div class="container">
	<h3>SimpleWebIDE - 
          <a href="https://feilongproject.com/">飞龙project</a>
          GitHub：<a href="https://github.com/feilongproject/SimpleWebIde">GitHub</a>
        </h3>
        <div class="editer-form">
          <div class="col-md-5 column" id="editordiv">
            <pre id="editor"></pre>
          </div>
        </div>
      <div class="col-md-5 column" id="iframediv">
        <div class="inout">
          <pre id="cin"></pre>
          <pre id="cout"></pre>
        </div>

        <div class="command-group">
          <select name="language" id="language" class="form-control">
            <option value="c_cpp" selected>C++（.cpp）</option>
          </select>
          <button id="changelang" class="btn btn-default">更改语言</button>
          <select name="skin" id="skin" class="form-control">
              <?php require("./skin.html")?>
	  </select>
          <button id="changeskin" class="btn btn-default">更改皮肤</button>
          <button class="btn btn-default" id="cheak">
            <span class="glyphicon glyphicon-play-circle"></span>运行代码
          </button>
          <button class="btn btn-default" id="savecode">
            <span class="glyphicon glyphicon-save"></span>保存代码（通过Cookie）
          </button>
          <button class="btn btn-default" id="readcode">
            <span class="glyphicon glyphicon-open"></span>读入代码（通过Cookie）
          </button>
      </div>
    </div>
    <script src="src-min-noconflict/ace.js" type="text/javascript" charset="utf-8"></script>
    <script>
      var cin = ace.edit("cin");
      cin.setOptions({enableLiveAutocompletion: true});
      cin.setTheme("ace/theme/tomorrow_night");
      cin.session.setMode("ace/mode/c_cpp");

      var cout = ace.edit("cout");
      cout.setOptions({enableLiveAutocompletion: true});
      cout.setTheme("ace/theme/tomorrow_night");
      cout.session.setMode("ace/mode/c_cpp");

      var editor = ace.edit("editor");
      editor.setOptions({enableLiveAutocompletion: true});
      editor.setTheme("ace/theme/tomorrow_night");
      editor.session.setMode("ace/mode/c_cpp");
      $("#changelang").click(function(){
        editor.session.setMode("ace/mode/" + $("#language").val());
      });
      $("#changeskin").click(function(){
        editor.setTheme("ace/theme/" + $("#skin").val());
      });
      $("#cheak").click(function(){
        var result = runcode(editor.getValue(),cin.getValue(), $("#language").val());
      });
      $("#savecode").click(function(){
        $.cookie("code", editor.getValue(),{ expires: 365});
      });
      $("#readcode").click(function(){
        editor.setValue($.cookie("code"));
      });
    </script>
  </body>
</html>
