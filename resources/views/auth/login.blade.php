@extends('layouts.app')

@section('content')
<style>
  .password-toggle-wrapper {
    position: relative;
  }

  .password-toggle-icon {
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    color: #717171;
    transition: color 0.3s ease;
    z-index: 10;
  }

  .password-toggle-icon:hover {
    color: #222222;
  }

  .password-toggle-wrapper input {
    padding-right: 40px;
  }
</style>

<div class="row mt-3">
  <div class="col-6 offset-3">
    <h1>Log In</h1>
    <form method="POST" action="{{ route('login') }}" class="needs-validation" novalidate>
      @csrf
      
      <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" name="username" placeholder="Enter Username" class="form-control" id="username" required>
        <div class="invalid-feedback">Please enter your username</div>
      </div>

      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <div class="password-toggle-wrapper">
          <input type="password" name="password" placeholder="Enter Password" class="form-control" id="password" required>
          <i class="fas fa-eye password-toggle-icon" id="togglePassword"></i>
        </div>
        <div class="invalid-feedback">Please enter your password</div>
      </div>

      <div class="mb-3 form-check">
        <input type="checkbox" name="remember" class="form-check-input" id="remember">
        <label class="form-check-label" for="remember">Remember Me</label>
      </div>

      <button type="submit" class="mt-3 btn btn-success">Log In</button>
    </form>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');

    if (togglePassword && passwordInput) {
      togglePassword.addEventListener('click', function() {
        // Toggle the type attribute
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        
        // Toggle the eye icon
        this.classList.toggle('fa-eye');
        this.classList.toggle('fa-eye-slash');
      });
    }
  });
</script>
@endsection
