<template>
  <div class="container">
    <EstudianteForm 
      :estudianteParaEditar="estudianteSeleccionado" 
      @actualizar-lista="cargarEstudiantes"
      @cancelar-edicion="estudianteSeleccionado = null"
    />

    <hr>

    <h2>Listado de Estudiantes</h2>
    <table class="styled-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nombre</th>
          <th>Email</th>
          <th>Curso Asignado</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="e in estudiantes" :key="e.id">
          <td>{{ e.id }}</td>
          <td>{{ e.nombre }}</td>
          <td>{{ e.email }}</td>
          <td>
            <span v-if="e.curso" class="badge-curso">
              {{ e.curso?.nombre }}
            </span>
            <span v-else class="badge-none">
              ⚠️ Sin curso (Desmatriculado)
            </span>
          </td>
          <td>
            <button @click="estudianteSeleccionado = e" class="btn-edit">Editar</button>
            <button @click="eliminar(e.id)" class="btn-delete">Eliminar</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import EstudianteForm from './EstudianteForm.vue'; 

const estudiantes = ref([]);
const estudianteSeleccionado = ref(null);

const cargarEstudiantes = async () => {
  try {
    const res = await axios.get('/api/estudiantes');
    // IMPORTANTE: Asegúrate que tu API haga: return Estudiante::with('curso')->get();
    estudiantes.value = res.data;
    estudianteSeleccionado.value = null;
  } catch (error) {
    console.error("Error cargando estudiantes:", error);
  }
};

const eliminar = async (id) => {
  if (confirm('¿Deseas eliminar a este estudiante?')) {
    try {
      await axios.delete(`/api/estudiantes/${id}`);
      cargarEstudiantes();
    } catch (error) {
      alert("Error al eliminar");
    }
  }
};

onMounted(cargarEstudiantes);
</script>

<style scoped>
.container { padding: 20px; }
.styled-table { width: 100%; border-collapse: collapse; margin-top: 20px; background: white; }
.styled-table th, .styled-table td { border: 1px solid #ddd; padding: 12px; text-align: left; }
.badge-curso { background: #e8f4fd; color: #2980b9; padding: 4px 10px; border-radius: 4px; font-weight: bold; border: 1px solid #3498db; }
.badge-none { background: #fef9e7; color: #f39c12; padding: 4px 10px; border-radius: 4px; font-style: italic; border: 1px solid #f1c40f; }
.btn-edit { background: #f39c12; color: white; border: none; padding: 6px 12px; border-radius: 4px; cursor: pointer; margin-right: 5px; }
.btn-delete { background: #c0392b; color: white; border: none; padding: 6px 12px; border-radius: 4px; cursor: pointer; }
</style>