<template>
  <div class="container">
    <CursoForm 
      :cursoParaEditar="cursoSeleccionado" 
      @actualizar-lista="finalizarAccion"
      @cancelar-edicion="cursoSeleccionado = null"
    />

    <hr>

    <h2>Listado de Cursos</h2>
    <table class="styled-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nombre</th>
          <th>Estado</th>
          <th>Inscripción</th> <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="c in cursos" :key="c.id">
          <td>{{ c.id }}</td>
          <td>{{ c.nombre }}</td>
          <td>
            <span :class="['badge', c.estado]">
              {{ c.estado.toUpperCase() }}
            </span>
          </td>
          <td>
            <small v-if="c.estado === 'active'" style="color: #2ecc71;">● Abierta</small>
            <small v-else style="color: #e74c3c;">● Cerrada</small>
          </td>
          <td>
            <button @click="prepararEdicion(c)" class="btn-edit">Editar</button>
            <button @click="eliminar(c.id)" class="btn-delete">Eliminar</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import CursoForm from './CursoForm.vue';

const cursos = ref([]);
const cursoSeleccionado = ref(null);

const cargarCursos = async () => {
  try {
    const res = await axios.get('/api/cursos');
    cursos.value = res.data;
  } catch (error) {
    console.error("Error cargando cursos:", error);
  }
};

const prepararEdicion = (c) => {
  cursoSeleccionado.value = c;
};

const finalizarAccion = () => {
  cursoSeleccionado.value = null;
  cargarCursos();
};

const eliminar = async (id) => {
  if (confirm('¿Eliminar curso? Se perderán todas las matriculaciones.')) {
    try {
      await axios.delete(`/api/cursos/${id}`);
      cargarCursos();
    } catch (error) {
      alert("Error al eliminar");
    }
  }
};

onMounted(cargarCursos);
</script>

<style scoped>
/* Tus estilos se mantienen igual, solo agregué orden */
.badge {
  padding: 4px 8px;
  border-radius: 12px;
  font-size: 11px;
  font-weight: bold;
  color: white;
  display: inline-block;
}
.active { background-color: #2ecc71; }
.draft { background-color: #f1c40f; color: #333; }
.archived { background-color: #95a5a6; }

.styled-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
.styled-table th, .styled-table td { border: 1px solid #ddd; padding: 12px; text-align: left; }
.btn-edit { background: #3498db; color: white; border: none; padding: 5px 10px; border-radius: 4px; cursor: pointer; margin-right: 5px; }
.btn-delete { background: #e74c3c; color: white; border: none; padding: 5px 10px; border-radius: 4px; cursor: pointer; }
</style>