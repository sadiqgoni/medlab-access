document.addEventListener("DOMContentLoaded", () => {
    // Password visibility toggle
    const passwordToggles = document.querySelectorAll(".password-toggle")
  
    passwordToggles.forEach((toggle) => {
      toggle.addEventListener("click", function () {
        const input = this.previousElementSibling
        const icon = this.querySelector("i")
  
        if (input.type === "password") {
          input.type = "text"
          icon.classList.remove("fa-eye")
          icon.classList.add("fa-eye-slash")
        } else {
          input.type = "password"
          icon.classList.remove("fa-eye-slash")
          icon.classList.add("fa-eye")
        }
      })
    })
  
    // Form animations
    if (typeof gsap !== "undefined") {
      gsap.from(".form-group", {
        y: 20,
        opacity: 0,
        duration: 0.4,
        stagger: 0.1,
        ease: "power2.out",
        delay: 0.2,
      })
  
      gsap.from(".auth-title, .auth-subtitle", {
        y: -20,
        opacity: 0,
        duration: 0.5,
        stagger: 0.1,
        ease: "power2.out",
      })
  
      gsap.from(".icon-circle", {
        scale: 0.8,
        opacity: 0,
        duration: 0.5,
        ease: "back.out(1.7)",
      })
    }
  
    // Form validation feedback
    const inputs = document.querySelectorAll("input, select, textarea")
  
    inputs.forEach((input) => {
      input.addEventListener("focus", function () {
        this.parentElement.classList.add("focused")
      })
  
      input.addEventListener("blur", function () {
        this.parentElement.classList.remove("focused")
  
        // Simple validation feedback
        if (this.value) {
          this.classList.add("is-valid")
          this.classList.remove("is-invalid")
        } else if (this.hasAttribute("required")) {
          this.classList.add("is-invalid")
          this.classList.remove("is-valid")
        }
      })
    })
  })
  