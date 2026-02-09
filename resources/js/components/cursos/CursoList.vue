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
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="c in cursos" :key="c.id">
          <td>{{ c.id }}</td>
          <td>{{ c.nombre }}</td>
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
  const res = await axios.get('/api/cursos');
  cursos.value = res.data;
};

const prepararEdicion = (c) => {
  cursoSeleccionado.value = c;
};

const finalizarAccion = () => {
  cursoSeleccionado.value = null;
  cargarCursos();
};

const eliminar = async (id) => {
  if (confirm('¿Eliminar curso?')) {
    await axios.delete(`/api/cursos/${id}`);
    cargarCursos();
  }
};

onMounted(cargarCursos);
</script>

<style scoped>
.styled-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
.styled-table th, .styled-table td { border: 1px solid #ddd; padding: 12px; text-align: left; }
.btn-edit { background: #3498db; color: white; border: none; padding: 5px 10px; border-radius: 4px; cursor: pointer; margin-right: 5px; }
.btn-delete { background: #e74c3c; color: white; border: none; padding: 5px 10px; border-radius: 4px; cursor: pointer; }
</style>