<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Aplus - Register page</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="mt-5 bg-light">
  <div class="container mt-5" style="max-width: 500px;">
    <h2 class="mb-4 text-center">Register</h2>
    
    @if(isset($errors))
      @foreach ($errors as $error)
        <p style="color:red;">* {{ $error }}</p>
      @endforeach
    @else
      <p style="color:green;">No errors</p>
    @endif
    
    @if(isset($email) && !isset($name))
      <p style="color:green;">User {{ $email }} created successfully</p>
    @endif

    <form method="POST" action="/register">
      @csrf
      <div class="mb-3">
        <label for="name" class="form-label">Name and surname</label>
        <input type="text" class="form-control" id="name" name="name" value="{{ $name ?? "" }}" required>
      </div>

      <div class="mb-3">
        <label for="email" class="form-label">E-mail address</label>
        <input type="email" class="form-control" id="email" name="email" value="{{ $email ?? "" }}" required>
      </div>

      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password" required>
      </div>

      <div class="mb-3">
        <label for="password_repeat" class="form-label">Repeat password</label>
        <input type="password" class="form-control" id="password_repeat" name="password_repeat" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Role</label><br>
        <input class="form-check-input" type="radio" name="role" value="student" id="student" checked>
        <label for="student">student</label><br>
        <input class="form-check-input" type="radio" name="role" value="teacher" id="teacher">
        <label for="teacher">teacher</label><br>
        <input class="form-check-input" type="radio" name="role" value="admin" id="admin">
        <label for="admin">administrator</label>
      </div>

      <button type="submit" class="btn btn-success w-100">Register</button>
    </form>
    <div class="text-center mt-3">
      <a href="/login" value="login">Already have an account? Log in!</a>
    </div>
  </div>
</body>
</html>
