<template>
  <header class="header"></header>
</template>

<script>
export default {
  name: "HeaderComponent",
};
</script>

<style scoped>
.header {
  width: 100%;
  background: var(--color-green-light);
  height: 4.5rem;
  position: fixed;
  z-index: 9;
}
</style>
