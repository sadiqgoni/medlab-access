// Enhanced animations for DHR SPACE

// Initialize particles background
function initParticles() {
  const particlesContainer = document.getElementById("particles-container")
  if (!particlesContainer) return

  const particleCount = 50

  for (let i = 0; i < particleCount; i++) {
    const particle = document.createElement("div")
    particle.classList.add("particle")

    // Random size between 2px and 8px
    const size = 2 + Math.random() * 6
    particle.style.width = `${size}px`
    particle.style.height = `${size}px`

    // Random position
    particle.style.left = `${Math.random() * 100}%`
    particle.style.top = `${Math.random() * 100}%`

    // Random opacity
    particle.style.opacity = 0.1 + Math.random() * 0.3

    // Random animation duration and delay
    const duration = 15 + Math.random() * 45
    particle.style.animationDuration = `${duration}s`
    particle.style.animationDelay = `${Math.random() * 10}s`

    // Add to container
    particlesContainer.appendChild(particle)
  }
}

// Initialize 3D scene
function init3DScene() {
  if (typeof THREE === "undefined") {
    console.error("THREE.js is not loaded. Please ensure it is included in your HTML.")
    return
  }

  const canvas = document.getElementById("lab-3d-scene")
  if (!canvas) return

  // Set up scene
  const scene = new THREE.Scene()
  scene.background = null // Transparent background

  // Set up camera
  const camera = new THREE.PerspectiveCamera(75, canvas.clientWidth / canvas.clientHeight, 0.1, 1000)
  camera.position.z = 5

  // Set up renderer
  const renderer = new THREE.WebGLRenderer({
    canvas: canvas,
    antialias: true,
    alpha: true,
  })
  renderer.setSize(canvas.clientWidth, canvas.clientHeight)

  // Create test tubes
  const testTubes = []
  for (let i = 0; i < 3; i++) {
    const tube = createTestTube()
    tube.position.x = (i - 1) * 2
    tube.position.y = Math.random() - 0.5
    scene.add(tube)
    testTubes.push(tube)
  }

  // Add lights
  const ambientLight = new THREE.AmbientLight(0xffffff, 0.5)
  scene.add(ambientLight)

  const directionalLight = new THREE.DirectionalLight(0xffffff, 0.8)
  directionalLight.position.set(1, 1, 1)
  scene.add(directionalLight)

  // Animation loop
  function animate() {
    requestAnimationFrame(animate)

    testTubes.forEach((tube) => {
      tube.rotation.y += 0.01
      tube.position.y = tube.userData.startY + Math.sin(Date.now() * 0.001 + tube.userData.offset) * 0.2
    })

    renderer.render(scene, camera)
  }

  // Create test tube
  function createTestTube() {
    const group = new THREE.Group()

    // Test tube body
    const tubeGeometry = new THREE.CylinderGeometry(0.3, 0.3, 2, 32)
    const tubeMaterial = new THREE.MeshPhongMaterial({
      color: 0xffffff,
      transparent: true,
      opacity: 0.7,
      shininess: 100,
    })
    const tube = new THREE.Mesh(tubeGeometry, tubeMaterial)

    // Bottom cap
    const capGeometry = new THREE.SphereGeometry(0.3, 32, 16, 0, Math.PI * 2, 0, Math.PI / 2)
    const cap = new THREE.Mesh(capGeometry, tubeMaterial)
    cap.position.y = -1
    cap.rotation.x = Math.PI

    // Liquid
    const liquidGeometry = new THREE.CylinderGeometry(0.25, 0.25, 1, 32)
    const liquidMaterial = new THREE.MeshPhongMaterial({
      color: Math.random() > 0.5 ? 0x1e88e5 : 0xff5722,
    })
    const liquid = new THREE.Mesh(liquidGeometry, liquidMaterial)
    liquid.position.y = -0.5

    group.add(tube)
    group.add(cap)
    group.add(liquid)

    // Animation parameters
    group.userData.startY = Math.random() * 0.5 - 0.25
    group.userData.offset = Math.random() * Math.PI * 2
    group.position.y = group.userData.startY

    return group
  }

  // Handle window resize
  window.addEventListener("resize", () => {
    if (canvas.clientWidth > 0 && canvas.clientHeight > 0) {
      camera.aspect = canvas.clientWidth / canvas.clientHeight
      camera.updateProjectionMatrix()
      renderer.setSize(canvas.clientWidth, canvas.clientHeight)
    }
  })

  animate()
}

// Enhanced counter animation
function initCounters() {
  const counters = document.querySelectorAll(".stat-counter")

  counters.forEach((counter) => {
    const target = Number.parseInt(counter.getAttribute("data-target"))
    const duration = 2000 // ms
    const step = (target / duration) * 10
    let current = 0

    const updateCounter = () => {
      current += step
      if (current < target) {
        counter.textContent = Math.ceil(current).toLocaleString()
        setTimeout(updateCounter, 10)
      } else {
        counter.textContent = target.toLocaleString()
      }
    }

    // Start counting when element is in view
    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            updateCounter()
            observer.unobserve(entry.target)
          }
        })
      },
      { threshold: 0.5 },
    )

    observer.observe(counter)
  })
}

// Enhanced FAQ accordion
function initFAQ() {
  const faqQuestions = document.querySelectorAll(".faq-question")

  faqQuestions.forEach((question) => {
    question.addEventListener("click", function () {
      const answer = this.nextElementSibling
      const icon = this.querySelector("svg")
      const iconContainer = this.querySelector(".w-8")

      // Close all other FAQs
      document.querySelectorAll(".faq-answer").forEach((item) => {
        if (item !== answer && !item.classList.contains("hidden")) {
          item.style.maxHeight = "0px"
          setTimeout(() => {
            item.classList.add("hidden")
          }, 300)

          // Reset other icons
          const otherIcon = item.previousElementSibling.querySelector("svg")
          const otherIconContainer = item.previousElementSibling.querySelector(".w-8")
          otherIcon.classList.remove("rotate-180")
          otherIconContainer.classList.remove("bg-primary-500")
          otherIconContainer.classList.add("bg-primary-100")
          otherIcon.classList.remove("text-white")
          otherIcon.classList.add("text-primary-600")
        }
      })

      // Toggle current FAQ
      if (answer.classList.contains("hidden")) {
        answer.classList.remove("hidden")
        answer.style.maxHeight = "0px"

        // Trigger reflow
        answer.offsetHeight

        // Expand
        answer.style.maxHeight = answer.scrollHeight + "px"

        // Change icon
        icon.classList.add("rotate-180")
        iconContainer.classList.remove("bg-primary-100")
        iconContainer.classList.add("bg-primary-500")
        icon.classList.remove("text-primary-600")
        icon.classList.add("text-white")
      } else {
        // Collapse
        answer.style.maxHeight = "0px"

        setTimeout(() => {
          answer.classList.add("hidden")
        }, 300)

        // Reset icon
        icon.classList.remove("rotate-180")
        iconContainer.classList.remove("bg-primary-500")
        iconContainer.classList.add("bg-primary-100")
        icon.classList.remove("text-white")
        icon.classList.add("text-primary-600")
      }
    })
  })
}

// Custom cursor
function initCustomCursor() {
  const cursor = document.querySelector(".custom-cursor")
  const cursorDot = document.querySelector(".cursor-dot")

  if (!cursor || !cursorDot || window.innerWidth <= 768) return

  cursor.style.opacity = "1"
  cursorDot.style.opacity = "1"

  document.addEventListener("mousemove", (e) => {
    cursor.style.left = e.clientX + "px"
    cursor.style.top = e.clientY + "px"

    cursorDot.style.left = e.clientX + "px"
    cursorDot.style.top = e.clientY + "px"
  })

  // Change cursor size and style on hover over links and buttons
  const interactiveElements = document.querySelectorAll("a, button, input, .interactive-element")
  interactiveElements.forEach((element) => {
    element.addEventListener("mouseenter", () => {
      cursor.style.transform = "translate(-50%, -50%) scale(0.5)"
      cursor.style.borderColor = "#4CAF50"
      cursorDot.style.transform = "translate(-50%, -50%) scale(1.5)"
      cursorDot.style.backgroundColor = "#4CAF50"
    })

    element.addEventListener("mouseleave", () => {
      cursor.style.transform = "translate(-50%, -50%) scale(1)"
      cursor.style.borderColor = "#1E88E5"
      cursorDot.style.transform = "translate(-50%, -50%) scale(1)"
      cursorDot.style.backgroundColor = "#1E88E5"
    })
  })
}

// Preloader
function setupPreloader() {
  const preloader = document.querySelector(".preloader")
  if (!preloader) return

  window.addEventListener("load", () => {
    setTimeout(() => {
      preloader.classList.add("hidden")
      setTimeout(() => {
        preloader.remove()
      }, 500)
    }, 1500)
  })
}

// Fade in sections on scroll
function initFadeInSections() {
  const fadeInSections = document.querySelectorAll(".fade-in-section")

  const options = {
    threshold: 0.1,
    rootMargin: "0px 0px -50px 0px",
  }

  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        entry.target.classList.add("is-visible")
        observer.unobserve(entry.target)
      }
    })
  }, options)

  fadeInSections.forEach((section) => observer.observe(section))
}

// Initialize all animations
document.addEventListener("DOMContentLoaded", () => {
  // Setup preloader
  setupPreloader()

  // Initialize AOS
  if (typeof AOS !== "undefined") {
    AOS.init({
      duration: 800,
      easing: "ease-out",
      once: true,
    })
  } else {
    console.warn("AOS (Animate on Scroll) is not loaded. Ensure it is included in your HTML.")
  }

  // Initialize custom cursor
  initCustomCursor()

  // Initialize particles
  initParticles()

  // Initialize 3D scene
  init3DScene()

  // Initialize counters
  initCounters()

  // Initialize FAQ
  initFAQ()

  // Initialize fade in sections
  initFadeInSections()

  // Add heartbeat animation to heart icons
  document.querySelectorAll(".fa-heartbeat").forEach((icon) => {
    if (!icon.classList.contains("heartbeat")) {
      icon.classList.add("heartbeat")
    }
  })

  // Add pulse animation to important buttons
  document.querySelectorAll(".pulse-element").forEach((element) => {
    if (!element.classList.contains("pulse-element")) {
      element.classList.add("pulse-element")
    }
  })
})
