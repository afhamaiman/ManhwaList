<template>
  <div id="app">
    <header>
      <nav class="navbar">
        <div class="nav-left">
          <router-link to="/">Home</router-link>
          <router-link to="/manhwa">All Manhwa</router-link>
        </div>
        <div class="nav-right">
          <ThemeToggle />
        </div>
      </nav>
    </header>

    <main class="content">
      <router-view />
    </main>

    <footer class="footer">
      <p>© 2025 My Manhwa App</p>
    </footer>
  </div>
</template>

<script>
import ThemeToggle from './components/ThemeToggle.vue'

export default {
  components: {
    ThemeToggle
  }
}
</script>

<style scoped>
/* Navbar */
.navbar {
  display: flex;
  justify-content: space-between;
  align-items: center;
  background: var(--nav-bg, #333);
  padding: 10px 20px;
  flex-wrap: wrap;
}

.nav-left a {
  color: var(--nav-text, #fff);
  margin-right: 1rem;
  text-decoration: none;
  font-weight: bold;
}

.nav-left a:last-child {
  margin-right: 0;
}

.nav-right {
  display: flex;
  align-items: center;
  margin-top: 10px;
}

@media (min-width: 600px) {
  .nav-right {
    margin-top: 0;
  }
}

/* Main content */
.content {
  flex: 1;
  width: 100%;
  padding: 20px;
  background-color: var(--bg);
  color: var(--text);
}

/* Footer */
.footer {
  text-align: center;
  padding: 15px 20px;
  background: var(--nav-bg, #333);
  color: var(--nav-text, #fff);
  font-size: 0.9rem;
}
</style>

<style>
/* Root & Dark Theme Variables */
:root {
  --bg: #ffffff;
  --text: #121212;
  --text-muted: #444;
  --card-bg: #ffffff;
  --input-bg: #f2f2f2;
  --border: #ccc;
  --accent: #00b894;
  --accent-hover: #019875;
  --disabled: #ccc;
  --nav-bg: #333;
  --nav-text: #ffffff;
}

.dark {
  --bg: #121212;
  --text: #e0e0e0;
  --text-muted: #bbb;
  --card-bg: #1e1e1e;
  --input-bg: #2a2a2a;
  --border: #444;
  --accent: #349e83;
  --accent-hover: #277e69;
  --disabled: #555;
  --nav-bg: #1a1a1a;
  --nav-text: #e0e0e0;
}

/* Full page height fix */
html, body, #app {
  height: 100%;
  min-height: 100vh;
  margin: 0;
  padding: 0;
  display: flex;
  flex-direction: column;
  background-color: var(--bg);
  color: var(--text);
}
</style>
