<template>
  <slot v-bind="sidebarContext"></slot>
</template>

<script setup lang="ts">
import { useSidebarProvider } from '@/composables/admin/useSidebar'

const sidebarContext = useSidebarProvider()
</script>
