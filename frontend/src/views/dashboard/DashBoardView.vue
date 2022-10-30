<template>
  <div class="container-fluid">
    <h2>DashBoard</h2>
    <hr />
  </div>
</template>

<script>
export default {
  name: "DashBoardView",
  data: () => ({
    menuOpen: true,
  }),
  methods: {
    toggleMenu() {
      if (this.menuOpen) this.menuOpen = false;
      else this.menuOpen = true;
    },
  },
};
</script>
