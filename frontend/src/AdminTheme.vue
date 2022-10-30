<template>
  <!-- <NavBar /> -->
  <div>
    <HeaderComponent />
    <AdminTheme>
      <template v-slot:body>
        <router-view />
      </template>
    </AdminTheme>
  </div>
</template>

<script>
import HeaderComponent from "@/components/header/HeaderComponent.vue";
import AdminTheme from "@/components/template/AdminTheme.vue";

export default {
  components: {
    HeaderComponent,
    AdminTheme,
  },
};
</script>
