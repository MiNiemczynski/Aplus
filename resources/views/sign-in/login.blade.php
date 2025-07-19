<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Aplus - Login page</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="mt-5 bg-light">
  <div class="container mt-5 text-center" style="max-width: 500px;">
    <h1 class="mb-4">Aplus - your school guide</h1>
    <p class="lead">Welcome to the best school diary in the world!</p>
    <h2 class="mb-4 text-center">Log in</h2>

    @if(isset($errors))
      @foreach ($errors as $error)
        <p style="color:red;">* {{ $error }}</p>
      @endforeach
    @else
      <p style="color:green;">No errors</p>
    @endif

    <form method="POST" action="/login">
    @csrf
      <div class="mb-3">
        <label for="email" class="form-label">E-mail address</label>
        <input type="email" class="form-control" id="email" name="email" value="{{ $email ?? "" }}" required>
      </div>

      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password" required>
      </div>
      
      <button type="submit" class="btn btn-primary w-100">Log in</button>
    </form>
    <div class="text-center mt-3">
      <a href="/register" value="register">Don't have an account? Sign in!</a>
    </div>
  </div>
</body>
</html>
