<template>
  <div class="main-layout">
    <nav class="navbar">
      <router-link to="/cursos" class="nav-btn">Gestión de Cursos</router-link>
      <router-link to="/estudiantes" class="nav-btn">Gestión de Estudiantes</router-link>
    </nav>

    <div class="content">
      <router-view></router-view> 
    </div>
  </div>
</template>

<script setup>

</script>

<style scoped>
.navbar { background: #333; padding: 1rem; display: flex; gap: 10px; }
.nav-btn { color: white; text-decoration: none; padding: 8px 15px; border-radius: 4px; }
.router-link-active { background: #42b883; font-weight: bold; }
.content { padding: 20px; }
</style>