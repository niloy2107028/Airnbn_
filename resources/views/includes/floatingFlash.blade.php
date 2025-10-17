<style>
  .flash-toast {
    position: fixed;
    bottom: 8rem;
    left: 1.5rem;
    z-index: 9999;
    max-width: 300px;
    padding: 1rem 1.25rem;
    border-radius: 0.75rem;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.25);
    opacity: 0;
    transform: translateX(-1.5rem);
    animation: slideUpFade 0.4s ease-out forwards;
    font-size: 1rem;
    pointer-events: none;
  }
  .flash-toast.success {
    background-color: #1f883d;
    color: white;
  }
  .flash-toast.error {
    background-color: #d33a3a;
    color: white;
  }
  @keyframes slideUpFade {
    to {
      opacity: 1;
      transform: translateX(0);
    }
  }
  .flash-bar {
    position: absolute;
    bottom: 0;
    left: 0;
    height: 4px;
    width: 100%;
    background-color: white;
    overflow: hidden;
    border-radius: 0.5rem;
  }
  .flash-toast.success .flash-bar {
    color: #4ade80;
  }
  .flash-toast.error .flash-bar {
    color: #f87171;
  }
  .flash-bar::after {
    content: "";
    position: absolute;
    height: 100%;
    background-color: currentColor;
    animation: flashProgress 4s linear forwards;
    border-radius: 0.5rem;
  }
  @keyframes flashProgress {
    from {
      width: 100%;
    }
    to {
      width: 0%;
    }
  }
</style>

@if(session('success'))
<div id="flash-message" class="flash-toast success">
  {{ session('success') }}
  <div class="flash-bar"></div>
</div>
@endif

@if(session('error'))
<div id="flash-message" class="flash-toast error">
  {{ session('error') }}
  <div class="flash-bar"></div>
</div>
@endif

<script>
  // Auto-remove flash message after animation completes
  const flashMsg = document.getElementById("flash-message");
  if (flashMsg) {
    setTimeout(() => {
      flashMsg.style.animation = "slideUpFade 0.4s ease-out reverse";
      setTimeout(() => flashMsg.remove(), 400);
    }, 4000);
  }
</script>
