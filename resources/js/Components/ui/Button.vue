<script setup>
import { cn } from '@/lib/utils';

defineProps({
  variant: {
    type: String,
    default: 'default', // Can be 'primary', 'secondary', etc.
  },
  size: {
    type: String,
    default: 'md', // Can be 'sm', 'md', 'lg'
  },
});

const variants = {
  default: 'bg-gray-300 text-black hover:bg-gray-400',
  primary: 'bg-blue-500 text-white hover:bg-blue-600',
  secondary: 'bg-gray-500 text-white hover:bg-gray-600',
};

const sizes = {
  sm: 'px-2 py-1 text-sm',
  md: 'px-4 py-2 text-base',
  lg: 'px-6 py-3 text-lg',
};
</script>

<template>
  <button
    :class="cn('rounded font-medium transition', variants[variant], sizes[size])"
  >
    <slot></slot>
  </button>
</template>
