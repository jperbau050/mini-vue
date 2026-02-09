<template>
  <div class="form-container">
    <h3>{{ estudianteParaEditar ? 'Editar Estudiante' : 'Nuevo Estudiante' }}</h3>
    
    <form @submit.prevent="enviarFormulario">
      <div class="field">
        <label>Nombre Completo:</label>
        <input v-model="estudiante.nombre" type="text" placeholder="Ej: Juan Pérez" required>
      </div>

      <div class="field">
        <label>Correo Electrónico:</label>
        <input v-model="estudiante.email" type="email" placeholder="juan@ejemplo.com" required>
      </div>

      <div class="field">
        <label>Curso:</label>
        <select v-model="estudiante.curso_id" required>
          <option value="">Seleccione un curso...</option>
          <option v-for="curso in cursos" :key="curso.id" :value="curso.id">
            {{ curso.nombre }}
          </option>
        </select>
      </div>

      <div class="buttons">
        <button type="submit" class="btn-save">
          {{ estudianteParaEditar ? 'Actualizar' : 'Guardar' }}
        </button>
        <button v-if="estudianteParaEditar" @click="cancelar" type="button" class="btn-cancel">
          Cancelar
        </button>
      </div>
    </form>
  </div>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue';
import axios from 'axios';

const props = defineProps({ estudianteParaEditar: Object });
const emit = defineEmits(['actualizar-lista', 'cancelar-edicion']);

const estudiante = ref({ nombre: '', email: '', curso_id: '' });
const cursos = ref([]);

const cargarCursos = async () => {
  const res = await axios.get('/api/cursos');
  cursos.value = res.data;
};

const limpiarFormulario = () => {
  estudiante.value = { nombre: '', email: '', curso_id: '' };
};

const enviarFormulario = async () => {
  try {
    if (props.estudianteParaEditar) {
      await axios.put(`/api/estudiantes/${props.estudianteParaEditar.id}`, estudiante.value);
    } else {
      await axios.post('/api/estudiantes', estudiante.value);
    }
    limpiarFormulario();
    emit('actualizar-lista');
    alert('¡Estudiante guardado!');
  } catch (error) {
    // Si el email ya existe o hay error 422, lo veremos aquí
    console.error(error.response.data);
    alert('Error: ' + (error.response.data.message || 'No se pudo guardar'));
  }
};

const cancelar = () => {
  limpiarFormulario();
  emit('cancelar-edicion');
};

watch(() => props.estudianteParaEditar, (newVal) => {
  if (newVal) estudiante.value = { ...newVal };
  else limpiarFormulario();
}, { immediate: true });

onMounted(cargarCursos);
</script>

<style scoped>
.form-container { background: #fff; padding: 20px; border-radius: 8px; border: 1px solid #ddd; margin-bottom: 20px; }
.field { margin-bottom: 12px; }
label { display: block; font-weight: bold; margin-bottom: 5px; }
input, select { width: 100%; padding: 8px; border-radius: 4px; border: 1px solid #ccc; box-sizing: border-box; }
.btn-save { background: #2c3e50; color: white; border: none; padding: 10px 15px; cursor: pointer; border-radius: 4px; font-weight: bold; }
.btn-cancel { background: #95a5a6; color: white; border: none; padding: 10px 15px; cursor: pointer; border-radius: 4px; margin-left: 10px; }
</style>