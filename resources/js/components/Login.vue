<!-- resources/js/Pages/Auth/Login.vue -->
<template>
    <div>
      <h1>Login</h1>
      <form @submit.prevent="login">
        <!-- Add email and password fields here -->
        <button type="submit">Login</button>
      </form>
      <a href="/auth/google">Login with Google</a> <!-- Social login link -->
    </div>
  </template>

  <script>
  export default {
    methods: {
      login() {
        // Handle login logic
      }
    }
  }
  </script>
