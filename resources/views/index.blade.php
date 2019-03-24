<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>DOCTOR - Responsive HTML &amp; Bootstrap Template</title>
	<link rel="stylesheet" href="/public/css/bootstrap.min.css">

</head>
<body>
    <div class="container">
        <h1>THIS IS TITLE</h1>

        <form method="POST" id="post-form">
          <div class="form-group">
            <label for="exampleInputEmail1">Email address</label>
            <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Email">
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Имя</label>
            <input type="test" class="form-control" id="name" placeholder="Имя">
          </div>
          <div class="form-group">
            <label>Message</label>
            <textarea class="form-control" rows="3"></textarea>
          </div>
          <button type="submit" class="btn btn-default">Submit</button>
        </form>

        <div class="text-right"><b>Всего сообщений:</b> <i class="badge">0</i></div><br />

        <div class="messages">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <span>Тема сообщения</span>
                        <span class="pull-right label label-info">17:15:00 / 03.07.2017</span>
                    </h3>
                </div>
                <div class="panel-body">
                    bla bla bla<br />
                    bla bla bla<br />
                    bla bla bla<br />
                    bla bla bla<br />
                    bla bla bla<br />
                    bla bla bla
                    <hr />
                    <div class="pull-right">
                        <a class="btn btn-info" href="#">
                            <i class="glyphicon glyphicon-pencil"></i>
                        </a>
                        <button class="btn btn-danger">
                            <i class="glyphicon glyphicon-trash"></i>
                        </button>
                    </div>


                </div>


        </div>


    </div>
    <script type="text/javascript" src="/public/js/jquery-1.11.0.min.js"></script>
    <script type="text/javascript" src="/public/js/bootstrap.min.js"></script>
</body>
</html>