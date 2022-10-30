<template>
  <PageTitle page="Adicionar marca" :pages="pages" />

  <div class="row">
    <div class="col-12">
      <FormBrand
        title="Adicione uma nova marca"
        description="Preencha os dados corretamente."
        @processaFormulario="processaFormulario($event)"
      />
    </div>
  </div>
</template>

<script>
import PageTitle from "@/components/template/PageTitle";
import FormBrand from "@/components/brands/FormBrand";
import { mapActions } from "vuex";

export default {
  name: "AddMarcaView",
  components: { FormBrand, PageTitle },
  data: () => ({
    pages: [
      {
        name: "Início",
        link: "/",
      },
      {
        name: "Marcas",
        link: "/marcas",
      },
    ],
  }),
  methods: {
    ...mapActions(["insertBrand"]),

    // Insere a marca
    processaFormulario(item) {
      // Repassa o obj para form obj.
      let form = new FormData();
      form.set("name", item.name);
      form.set("description", item.description);

      // Processa a api
      this.insertBrand(form)
        .then(() => { this.$router.push({name: 'marcas'})})
        .catch((err) => console.log("error", err));
    },
  },
};
</script>