<template>
  <div class="card" style="border: none;">
    <div class="card-body shadowCard">
      <h5 class="tituloBoard card-title">{{ title }}</h5>
      <h6 class="card-subtitle mb-2 text-muted">{{ subtitle }}</h6>
      <p class="card-text">
        <slot name="body"></slot>
      </p>
      <slot name="footer" />
    </div>
  </div>
</template>

<script>
export default {
  name: "CardComponent",
  props: {
    title: {
      type: String,
      default: "",
    },
    subtitle: {
      type: String,
      default: "",
    },
  },
};
</script>

<style scoped>
</style>
