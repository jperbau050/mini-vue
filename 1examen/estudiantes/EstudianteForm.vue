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
          <option 
            v-for="curso in cursos" 
            :key="curso.id" 
            :value="curso.id"
            :disabled="curso.estado !== 'active'"
          >
            {{ curso.nombre }} 
            {{ curso.estado !== 'active' ? `(${curso.estado.toUpperCase()})` : '✅' }}
          </option>
        </select>
        <p class="helper-text">
          Nota: Los cursos en <i>Draft</i> o <i>Archived</i> no aceptan inscripciones.
        </p>
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
  try {
    const res = await axios.get('/api/cursos');
    cursos.value = res.data;
  } catch (error) {
    console.error("Error cargando cursos:", error);
  }
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
    emit('actualizar-lista'); // Esto refresca la tabla en el componente padre
    alert('¡Guardado con éxito!');
  } catch (error) {
    const msg = error.response?.data?.message || 'Error al guardar';
    alert('Error: ' + msg);
  }
};

const cancelar = () => {
  limpiarFormulario();
  emit('cancelar-edicion');
};

watch(() => props.estudianteParaEditar, (newVal) => {
  if (newVal) {
    estudiante.value = { ...newVal };
  } else {
    limpiarFormulario();
  }
}, { immediate: true });

onMounted(cargarCursos);
</script>

<style scoped>
.form-container { background: #fff; padding: 20px; border-radius: 8px; border: 1px solid #ddd; margin-bottom: 20px; }
.field { margin-bottom: 12px; }
label { display: block; font-weight: bold; margin-bottom: 5px; }
input, select { width: 100%; padding: 8px; border-radius: 4px; border: 1px solid #ccc; box-sizing: border-box; }
select:disabled { background-color: #f5f5f5; color: #999; }
.helper-text { font-size: 0.8em; color: #7f8c8d; margin-top: 5px; }
.btn-save { background: #2c3e50; color: white; border: none; padding: 10px 15px; cursor: pointer; border-radius: 4px; font-weight: bold; }
.btn-cancel { background: #95a5a6; color: white; border: none; padding: 10px 15px; cursor: pointer; border-radius: 4px; margin-left: 10px; }
</style>