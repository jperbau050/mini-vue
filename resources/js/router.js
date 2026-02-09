import { createRouter, createWebHistory } from 'vue-router';

// Importamos tus componentes
import CursoList from './components/cursos/CursoList.vue';
import EstudianteList from './components/estudiantes/EstudiantesList.vue';

const routes = [
    { path: '/', redirect: '/cursos' }, // Por defecto va a cursos
    { path: '/cursos', component: CursoList },
    { path: '/estudiantes', component: EstudianteList },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;