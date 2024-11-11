<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Pie } from 'vue-chartjs';
import { Chart as ChartJS, Title, Tooltip, Legend, ArcElement } from 'chart.js';
import { ref } from 'vue';

ChartJS.register(Title, Tooltip, Legend, ArcElement);

const props = defineProps({
  usuarios: { type: Object },
  estrenos: { type: Number },
});

const usu = ref([]);
const est = ref([]);
const colors = ref([]);
const chartData = ref({});
const chartOptions = ref({
  responsive: true,
  plugins: {
    legend: {
      position: 'top',
    },
  },
});

const randomColor = () => {
  return `rgb(${Math.floor(Math.random() * 256)}, ${Math.floor(Math.random() * 256)}, ${Math.floor(Math.random() * 256)})`;
};

// Configurar los datos para la gráfica
props.usuarios.forEach((row) => {
  est.value.push(row.estrenos.length);
  usu.value.push(`${row.last_name} ${row.name}`);
  colors.value.push(randomColor());
});

chartData.value = {
  labels: usu.value,
  datasets: [
    {
      label: 'Usuarios',
      data: est.value,
      backgroundColor: colors.value,
    },
  ],
};
</script>

<template>
  <Head title="Dashboard" />

  <AuthenticatedLayout>
    <template #header>
      Dashboard
    </template>

    <div class="p-4 bg-white rounded-lg shadow-xs">
      <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">
        <div class="border min-w-0 rounded-lg shadow-xs overflow-hidden bg-white dark:bg-gray-800">
          <div class="p-4 flex items-center">
            <div class="p-3 rounded-full text-orange-500 dark:text-orange-100 bg-orange-100 dark:bg-orange-500 mr-4">
              <!-- Icono SVG aquí -->
            </div>
            <div>
              <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">Total Usuarios</p>
              <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">{{ usuarios.length }}</p>
            </div>
          </div>
        </div>
        <div class="border min-w-0 rounded-lg shadow-xs overflow-hidden bg-white dark:bg-gray-800">
          <div class="p-4 flex items-center">
            <div class="p-3 rounded-full text-green-500 dark:text-green-100 bg-green-100 dark:bg-green-500 mr-4">
              <!-- Otro icono SVG aquí -->
            </div>
            <div>
              <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">Total Peliculas</p>
              <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">{{ estrenos }}</p>
            </div>
          </div>
        </div>
      </div>
      <div class="grid grap-6 bg-white mb-8 md:grid-cols-2 border rounded-lg">
        <div class="min-w-0 p-4 rounded-lg shadow-xs border">
          <span class="text-lg p-4">Estrenos por usuarios</span>
          <div class="flex items-center">
            <Pie :data="chartData" :options="chartOptions" />
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

