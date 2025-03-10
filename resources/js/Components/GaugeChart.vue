<script setup lang="ts">
import { ref, computed } from "vue";
import VueApexCharts from "vue3-apexcharts";

const props = defineProps<{
  title: string;
  value: number; // Current profit value
  max: number; // Max value for the gauge
}>();

const chartOptions = computed(() => ({
  chart: {
    type: "radialBar",
  },
  plotOptions: {
    radialBar: {
      startAngle: -90,
      endAngle: 90,
      track: {
        background: "#e7e7e7",
        strokeWidth: "97%",
      },
      dataLabels: {
        name: {
          show: true,
        },
        value: {
          fontSize: "24px",
          fontWeight: "bold",
        },
      },
    },
  },
  labels: [props.title],
}));

const chartSeries = ref([(props.value / props.max) * 100]); // Converts value into percentage
</script>

<template>
  <div class="text-center bg-white dark:bg-gray-800 shadow rounded-lg p-6">
    <h2 class="text-sm text-gray-500 dark:text-gray-400">{{ title }}</h2>
    <VueApexCharts :options="chartOptions" :series="chartSeries" type="radialBar" height="200" />
  </div>
</template>
