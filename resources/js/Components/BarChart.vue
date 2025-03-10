<script setup lang="ts">
import { defineProps, shallowRef, onMounted } from "vue";
import { use } from "echarts/core";
import { CanvasRenderer } from "echarts/renderers";
import { BarChart } from "echarts/charts";
import { GridComponent, TooltipComponent, LegendComponent } from "echarts/components";
import VChart from "vue-echarts";

use([CanvasRenderer, BarChart, GridComponent, TooltipComponent, LegendComponent]);

const props = defineProps({
  title: String,
  chartData: Object,
  color: String,
});

const options = shallowRef({
  tooltip: { trigger: "axis" },
  legend: { data: [] },
  xAxis: { type: "category", data: [] },
  yAxis: { type: "value" },
  series: [
    { name: "", type: "bar", data: [], itemStyle: { color: "" } },
  ],
});

onMounted(() => {
  if (props.chartData) {
    options.value.legend.data = [props.title];
    options.value.xAxis.data = props.chartData.labels;
    options.value.series[0].name = props.title;
    options.value.series[0].data = props.chartData.data;
    options.value.series[0].itemStyle.color = props.color;
  }
});
</script>

<template>
  <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
    <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">{{ title }}</h2>
    <VChart class="w-full h-[300px]" :option="options" autoresize />
  </div>
</template>
