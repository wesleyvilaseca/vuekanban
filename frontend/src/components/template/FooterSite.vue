<template>
  <div>
    <footer class="footer">
      © {{ date }} {{ this.$store.state.nameSite }}
      <span class="d-none d-sm-inline-block">
        - Todos os direitos reservados </span
      >.
    </footer>
  </div>
</template>

<script>
import { mapState } from "vuex";

export default {
  name: "FooterSite",
  data: () => {
    return {
      date: "",
    };
  },
  mounted() {
    var dt = new Date();
    this.date = dt.getFullYear();
  },
  computed: {
    ...mapState({
      site: (state) => state.nameSite,
    }),
  },
};
</script>

<style scoped>
</style>