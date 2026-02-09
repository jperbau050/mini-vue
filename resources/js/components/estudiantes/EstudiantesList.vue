<template>
  <div class="container">
    <EstudianteForm 
      :estudianteParaEditar="estudianteSeleccionado" 
      @actualizar-lista="finalizarAccion"
      @cancelar-edicion="estudianteSeleccionado = null"
    />

    <hr>

    <h2>Listado de Estudiantes</h2>
    <table class="styled-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nombre</th>
          <th>Curso Asignado</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="e in estudiantes" :key="e.id">
          <td>{{ e.id }}</td>
          <td>{{ e.nombre }}</td>
          <td>{{ e.curso ? e.curso.nombre : 'Sin curso' }}</td>
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
// He corregido la importación: asegúrate de que el nombre del archivo es exactamente este
import EstudianteForm from './EstudianteForm.vue'; 

const estudiantes = ref([]);
const estudianteSeleccionado = ref(null);

const cargarEstudiantes = async () => {
  try {
    const res = await axios.get('/api/estudiantes');
    estudiantes.value = res.data;
  } catch (error) {
    console.error("Error cargando estudiantes:", error);
  }
};

const finalizarAccion = () => {
  estudianteSeleccionado.value = null;
  cargarEstudiantes();
};

const eliminar = async (id) => {
  if (confirm('¿Eliminar estudiante?')) {
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
.styled-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
.styled-table th, .styled-table td { border: 1px solid #ddd; padding: 10px; text-align: left; }
.btn-edit { background: #f39c12; color: white; border: none; padding: 5px 10px; border-radius: 4px; cursor: pointer; margin-right: 5px; }
.btn-delete { background: #c0392b; color: white; border: none; padding: 5px 10px; border-radius: 4px; cursor: pointer; }
</style>