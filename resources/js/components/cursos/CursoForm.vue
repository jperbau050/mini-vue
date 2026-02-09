<template>
  <div class="form-container">
    <h3>{{ cursoParaEditar ? 'Editar Curso' : 'Crear Nuevo Curso' }}</h3>
    
    <form @submit.prevent="enviarFormulario">
      <div class="field">
        <label>Nombre del curso:</label>
        <input v-model="curso.nombre" type="text" placeholder="Ej: Laravel" required>
      </div>

      <div class="field">
        <label>Descripción:</label>
        <textarea v-model="curso.descripcion" placeholder="Opcional"></textarea>
      </div>

      <div class="buttons">
        <button type="submit" class="btn-save">
          {{ cursoParaEditar ? 'Actualizar' : 'Guardar' }}
        </button>
        <button v-if="cursoParaEditar" @click="cancelarEdicion" type="button" class="btn-cancel">
          Cancelar
        </button>
      </div>
    </form>
  </div>
</template>

<script setup>
import { ref, watch } from 'vue';
import axios from 'axios';

const props = defineProps({
  cursoParaEditar: { type: Object, default: null }
});

const emit = defineEmits(['actualizar-lista', 'cancelar-edicion']);
const curso = ref({ nombre: '', descripcion: '' });

// --- FUNCIONES (Definidas antes del watch) ---
const limpiarFormulario = () => {
  curso.value = { nombre: '', descripcion: '' };
};

const enviarFormulario = async () => {
  try {
    if (props.cursoParaEditar) {
      // EDITAR (PUT)
      await axios.put(`/api/cursos/${props.cursoParaEditar.id}`, curso.value);
    } else {
      // CREAR (POST)
      await axios.post('/api/cursos', curso.value);
    }
    limpiarFormulario();
    emit('actualizar-lista');
  } catch (error) {
    console.error("Error al guardar:", error);
    alert('Error al conectar con el servidor');
  }
};

const cancelarEdicion = () => {
  limpiarFormulario();
  emit('cancelar-edicion');
};

// --- WATCH (Observa cambios en la selección de la tabla) ---
watch(() => props.cursoParaEditar, (newVal) => {
  if (newVal) {
    curso.value = { ...newVal };
  } else {
    limpiarFormulario();
  }
}, { immediate: true });
</script>

<style scoped>
.form-container { background: #f9f9f9; padding: 20px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #ddd; }
.field { margin-bottom: 10px; }
input, textarea { width: 100%; padding: 8px; border-radius: 4px; border: 1px solid #ccc; }
.btn-save { background: #2ecc71; color: white; border: none; padding: 10px 15px; cursor: pointer; border-radius: 4px; }
.btn-cancel { background: #95a5a6; color: white; border: none; padding: 10px 15px; cursor: pointer; border-radius: 4px; margin-left: 10px; }
</style>