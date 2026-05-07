<template>
  <ThemeProvider>
    <SidebarProvider v-slot="{ isExpanded, isHovered }">
      <div class="admin-app min-h-screen xl:flex">
        <AdminSidebar />
        <Backdrop />
        <div
          class="flex-1 transition-all duration-300 ease-in-out"
          :class="[isExpanded || isHovered ? 'lg:ml-[290px]' : 'lg:ml-[90px]']"
        >
          <AdminHeader />
          <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
            <slot />
          </div>
        </div>
      </div>
    </SidebarProvider>
  </ThemeProvider>
</template>

<script setup lang="ts">
import '/resources/css/admin.css'
import 'swiper/css'
import 'swiper/css/navigation'
import 'swiper/css/pagination'
import 'flatpickr/dist/flatpickr.css'
import 'jsvectormap/dist/jsvectormap.css'
import AdminHeader from '@/components/admin/layout/AdminHeader.vue'
import AdminSidebar from '@/components/admin/layout/AdminSidebar.vue'
import Backdrop from '@/components/admin/layout/Backdrop.vue'
import SidebarProvider from '@/components/admin/layout/SidebarProvider.vue'
import ThemeProvider from '@/components/admin/layout/ThemeProvider.vue'
</script>
