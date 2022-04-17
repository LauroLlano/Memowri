<!DOCTYPE html>
<html lang="en">
<head>
    <title>Page not found - 404</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Save your notes and keep them organized with MemoWri!">
    <meta name="keywords" content="memowri, notes, cloud notes, note">
    <meta name="author" content="Lauro Llano">

    <!--Bootstrap CSS-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!--Bootstrap JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <style type="text/css">
        body{
            background-color: #C4CCD9;
            height: 100%;

        }

        .main-content{
            border: 1px solid #2d2d2d;
            background-color: white;
            padding:1rem;
            box-shadow: 0px 10px 10px -10px #5D6572;
        }


        .main-content h1{
          font-weight: bold;
          color: #444444;
          font-size: 100px;
          text-shadow: 2px 4px 5px #6E6E6E;
          text-align: center;
        }

        .main-content h6{
          color: #42494F;
          text-align: center;
        }
        .main-content p{
          color: #9897A0;
          font-size: 14px;
          text-align: center;

        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="d-flex flex-column min-vh-100 justify-content-center align-items-center">
                    <div class="main-content">
                      <h1>404</h1>
                      <h6>Page not found - www.memowri.com</h6>
                      <p>{{ $exception!=NULL && $exception->getMessage()!="" ? $exception->getMessage() : "The page you are trying to access does not exist"}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
