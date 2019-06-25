<head>
  <title>Products</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <link rel='stylesheet' href='./format.css'>
  <link rel='icon' href='https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRJRD4TXXE-9ZIiXxNMpYSZ3JIMFZHeVpnGuSfC9mA3F4KINk8Y'>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>

<body>
<nav class="navbar navbar-expand-lg bg-dark navbar-dark fixed-top">
  <ul class="navbar-nav mr-auto">
    <li class="nav-item">
      <a class="nav-link" href="./index.php">Overview</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="./list.php">Product List</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="./categories.php">Categories</a>
    </li>
  </ul>
  <form method='get' class="form-inline my-2 my-lg-0" action="./product.php">
    <input class="form-control mr-sm-2" name='id' type="text" placeholder="Search by ProductID">
    <button class="btn btn-info my-2 my-sm-0" type="submit">Search</button>
  </form>
</nav><br>
